<?php

namespace App\Http\Controllers;

use App\Jobs\PurchaseIntentTimeoutJob;
use App\Models\Purchase;
use App\Notifications\ProductCartGoneNotification;
use App\Notifications\ProductSoldNotification;
use App\Notifications\WishlistProductGoneNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Monarobase\CountryList\CountryListFacade as Countries;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public static function removePurchaseFromOtherUsers($user, $cart): void
    {
        //TODO: remove all vouchers that contain product
        foreach ($cart as $product) {
            Notification::send(
                $product->inCart()
                    ->whereNot(
                        function ($query) use ($user) {
                            $query->where('id', $user->id);
                        })
                    ->get(), new ProductCartGoneNotification($product));
            $product->inCart()->detach();
            Notification::send(
                $product->wishlist()
                    ->whereNot(
                        function ($query) use ($user) {
                            $query->where('id', $user->id);
                        })
                    ->get(), new WishlistProductGoneNotification($product));
            $product->wishlist()->detach();
            Notification::send(
                $product->soldBy()->get(),
                new ProductSoldNotification($product)
            );
        }

    }

    public static function canEnterCheckout(Request $request): bool
    {
        $cart = $request->user()->cart()->withCount('purchaseIntents')->get();
        $hasPurchaseIntent = false;
        foreach ($cart as $product) {
            if ($product->purchase_intents_count > 1) {
                $hasPurchaseIntent = true;
                break;
            } elseif ($product->purchase_intents_count === 1) {
                $purchaseIntent = $product->purchaseIntents()->get()->first();
                if ($purchaseIntent->user !== $request->user()->id) {
                    $hasPurchaseIntent = true;
                    break;
                }
            }
        }

        return ! $hasPurchaseIntent;
    }

    public static function validateCheckoutRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|max:250',
            'email' => 'required|email:rfc',
            'address' => 'required|max:500',
            'country' => 'required',
            'zip_code' => 'required|max:1000',
            'phone' => 'required|integer',
            'payment_method' => 'required',
        ]);
    }

    public static function createPaymentIntent(StripeClient $stripe, $cart, Request $request): \Stripe\PaymentIntent
    {
        $amount = CartController::getCartPrice($request);
        $appliedVouchers = VoucherController::getAppliedVouchers($request)->map(function ($value, $key) {
            return $value->code;
        })->toArray();
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
            'metadata' => ['vouchers' => json_encode($appliedVouchers)],
        ]);

        $purchaseIntent = $request->user()->purchaseIntents()->create([
            'shipping_address' => [
                'name' => $request->name,
                'email' => $request->email,
                'country' => $request->country,
                'address' => $request->address,
                'zip-code' => $request->zip_code,
                'phone' => $request->phone,
            ],
            'payment_intent_id' => $paymentIntent->id,
        ]);
        $purchaseIntent->products()->attach($cart);
        PurchaseIntentTimeoutJob::dispatch($purchaseIntent)->delay(now()->addMinutes(15));

        return $paymentIntent;
    }

    public function getPaymentIntent(Request $request)
    {
        $stripe = new StripeClient(config('payments.stripe_key'));

        try {
            CheckoutController::validateCheckoutRequest($request);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
        if ($request->payment_method !== '1') {
            return response()->json(['error' => 'In order to use payment intents you must use stripe as a payment method'], 400);
        }
        if (! CheckoutController::canEnterCheckout($request)) {
            return response()->json(['error' => "Can't get paymentIntent because there's someone buying a product in cart"], 401);
        }
        $user = $request->user();
        $cart = $user->cart()->get();
        foreach ($cart as $product) {
            if (ProductController::isProductSold($product)) {
                return response()->json(['error' => 'A product has been sold while on the checkout.'], 409);
            }
        }
        $purchaseIntent = $user->purchaseIntents()->get()->first();
        if (isset($purchaseIntent) && $purchaseIntent->first()->products()->get()->diff($cart)->isEmpty()) {
            $paymentIntent = $stripe->paymentIntents->retrieve($purchaseIntent->payment_intent_id);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } elseif (isset($purchaseIntent)) {
            //delete old paymentIntent and create a new one if the cart changes
            $stripe->paymentIntents->cancel($purchaseIntent->payment_intent_id);
            $purchaseIntent->delete();
        }
        $paymentIntent = CheckoutController::createPaymentIntent($stripe, $cart, $request);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function getPage(Request $request)
    {
        //FIXME(luisd): there can be a race condition on checkout if a product is already sold, handle that notification
        // and reload the checkout page
        $user = $request->user();

        if (! CheckoutController::canEnterCheckout($request)) {
            return redirect('/cart')->with('modal-error',
                [
                    'title' => 'Item reserved',
                    'content' => 'Looks like someone is trying to buy the same item as you at the same time. Please wait and try again.',
                    'confirm-button' => 'Close',
                ]);
        }

        $settings = $user->settings['shipping'];

        return view('pages.checkout', ['cart' => $user->cart()->get(), 'settings' => $settings, 'countries' => Countries::getList('en')]);
    }

    public function postPage(Request $request)
    {
        CheckoutController::validateCheckoutRequest($request);
        if ($request->payment_method === '1') {
            return back(); //this is never supposed to happen
        }
        if (! CheckoutController::canEnterCheckout($request)) {
            return back();
        }
        $appliedVouchers = VoucherController::getAppliedVouchers($request);
        DB::beginTransaction();
        $cart = $request->user()->cart()->get();
        $cartGrouped = $cart->groupBy('sold_by');
        if ($request->payment_method === '0') {
            $purchase = Purchase::create(['method' => 'delivery']);
            foreach ($cartGrouped as $soldBy => $products) {
                $order = $request->user()->orders()->create([
                    'status' => 'pendingShipment', //payment at delivery goes straight to pendingShipment
                    'shipping_address' => [
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'zip-code' => $request->zip_code,
                        'phone' => $request->phone,
                    ],
                    'purchase' => $purchase->id,
                ]);

                foreach ($products as $product) {
                    if (ProductController::isProductSold($product)) {
                        return back()->with('error', 'A product has been sold while on the checkout page. Please check the cart details and try again');
                    }
                    $voucher = $appliedVouchers->filter(function ($value, $key) use ($product) {
                        return $product->id === $value->product;
                    })->first();
                    if ($voucher === null) {
                        $order->products()->attach($product->id);
                    } else {
                        $voucher->used = true;
                        $voucher->save();
                        $order->products()->attach($product->id, ['discount' => $product->price - $voucher->bargainMessage->proposed_price]);
                    }
                }
            }
        }
        // remove the cart of all users because it has been bought
        CheckoutController::removePurchaseFromOtherUsers($request->user(), $cart);
        DB::commit();

        return redirect('/');
    }

    public function paymentConfirmationPage(Request $request)
    {
        if ($request->query('redirect_status') === 'failed') {
            //TODO: add error
            return redirect()->route('checkout')->with('modal-error',
                [
                    'title' => 'Payment error',
                    'content' => 'Something went wrong while processing your payment, please try again.',
                    'confirm-button' => 'Close',
                ]);
        }

        return view('pages.paymentConfirmation');
    }
}
