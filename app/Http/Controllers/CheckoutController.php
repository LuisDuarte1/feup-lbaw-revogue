<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public static function canEnterCheckout(Request $request): bool {
        $cart = $request->user()->cart()->withCount('purchaseIntents')->get();
        $hasPurchaseIntent = false;
        foreach($cart as $product){
            if($product->purchase_intents_count > 1){
                $hasPurchaseIntent = true;
                break;
            }
            else if($product->purchase_intents_count === 1){
                $purchaseIntent = $product->purchaseIntent()->get()->first;
                if($purchaseIntent->user()->id !== $request->user()->id){
                    $hasPurchaseIntent = true;
                    break;
                }
            }
        }
        return !$hasPurchaseIntent;
    }

    public static function validateCheckoutRequest(Request $request){
        $request->validate([
            'full_name' => 'required|max:250',
            'email' => 'required|email:rfc',
            'address' => 'required|max:500',
            'country' => 'required',
            'zip_code' => 'required|max:1000',
            'phone' => 'required|integer',
            'payment_method' => 'required',
        ]);
    }

    public function getPaymentIntent(Request $request)
    {
        try{
            CheckoutController::validateCheckoutRequest($request);
        } catch( ValidationException $e){
            return response()->json(['error' => $e->errors()], 400);
        }
        if($request->payment_method !== '1'){
            return response()->json(['error' => "In order to use payment intents you must use stripe as a payment method"], 400);
        }
        if(!CheckoutController::canEnterCheckout($request)){
            return response()->json(['error' => "Can't get paymentIntent because there's someone buying a product in cart"], 401);
        }
        $user = $request->user();
        $cart = $user->cart()->get();
        $amount = 0;
        foreach($cart as $product){
            $amount += $product->price;
        }
        $stripe = new StripeClient(config('payments.stripe_key'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount*100,
            'currency' => 'eur',
            'automatic_payment_methods' => [
                'enabled' => true,
            ]
        ]);

        $purchaseIntent = $request->user()->purchaseIntents()->create([
            'shipping_address' => [
                'name' => $request->full_name,
                'email' => $request->email,
                'country' => $request->country,
                'address' => $request->address,
                'zip-code' => $request->zip_code,
                'phone' => $request->phone,
            ],
            'payment_intent_id' => $paymentIntent->id
        ]);
        $purchaseIntent->products()->attach($cart);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

    public function getPage(Request $request)
    {
        $user = $request->user();

        if (!CheckoutController::canEnterCheckout($request)){
            //TODO(luisd): redirect to cart with an error
            return redirect('/cart');
        }
        return view('pages.checkout', ['cart' => $user->cart()->get()]);
    }

    public function postPage(Request $request)
    {
        //dd($request);
        CheckoutController::validateCheckoutRequest($request);
        if($request->payment_method === '1'){
            return back(); //this is never supposed to happen 
        }
        if(!CheckoutController::canEnterCheckout($request)){
            return back();
        }
        DB::beginTransaction();
        $cart = $request->user()->cart()->get();
        $cartGrouped = $cart->groupBy('sold_by');
        if ($request->payment_method === '0') {
            $purchase = Purchase::create(['method' => 'delivery']);
            foreach ($cartGrouped as $soldBy => $products) {
                $order = $request->user()->orders()->create([
                    'status' => 'pendingShipment', //payment at delivery goes straight to pendingShipment
                    'shipping_address' => [
                        'name' => $request->full_name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'zip-code' => $request->zip_code,
                        'phone' => $request->phone,
                    ],
                    'purchase' => $purchase->id,
                ]);

                $ids = [];
                foreach ($products as $product) {
                    array_push($ids, $product->id);
                }
                $order->products()->attach($ids);
            }
        }
        // remove the cart of all users because it has been bought
        // TODO(luisd): send notification
        foreach ($cart as $product) {
            $product->inCart()->detach();
            $product->wishlist()->detach();
        }
        DB::commit();

        return redirect('/');
    }

    public function paymentConfirmationPage(Request $request){
        return view('pages.paymentConfirmation');
    }
}
