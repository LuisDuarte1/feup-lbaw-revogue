<?php

namespace App\Jobs;

use App\Http\Controllers\CheckoutController;
use App\Models\Purchase;
use App\Models\PurchaseIntent;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class StripeWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public static function handleSuccessfulPayment(\Stripe\Event $event)
    {
        $paymentIntent = $event->data->object;

        $purchaseIntent = PurchaseIntent::where('payment_intent_id', $paymentIntent->id)->first();

        //we assume if the paymentIntent isn't found we just skip it. But it's never supposed to happen
        if (! isset($purchaseIntent)) {
            error_log('cannot find paymentIntent '.$paymentIntent->id);

            return;
        }
        
        $appliedVouchers = collect(array_map(function ($value) {
            return Voucher::where('code', $value)->get()->first();
        },json_decode($paymentIntent['metadata']['vouchers'])));

        $user = $purchaseIntent->user()->get()->first();
        $cart = $purchaseIntent->products()->get();
        $cartGrouped = $purchaseIntent->products()->get()->groupBy('sold_by');
        DB::beginTransaction();
        $purchase = Purchase::create(['method' => 'stripe']);
        foreach ($cartGrouped as $soldBy => $products) {
            $order = $purchaseIntent->user()->get()->first()->orders()->create([
                'status' => 'pendingShipment', //payment at delivery goes straight to pendingShipment
                'shipping_address' => $purchaseIntent->shipping_address,
                'purchase' => $purchase->id,
            ]);

            foreach ($products as $product) {
                $voucher = $appliedVouchers->filter(function ($value, $key) use ($product) {
                    return $product->id === $value->product;
                })->first();
                if($voucher === null){
                    $order->products()->attach($product->id);
                } else {
                    $voucher->used = true;
                    $voucher->save();
                    $order->products()->attach($product->id, ['discount' => $product->price - $voucher->bargainMessage->proposed_price]);
                }
            }
        }
        CheckoutController::removePurchaseFromOtherUsers($user, $cart);
        $purchaseIntent->delete();
        DB::commit();
    }

    /**
     * Create a new job instance.
     */
    public function __construct(public \Stripe\Event $event)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //TODO (luisd): in the future we can maybe handle the payment_intent.processing but it's uncommon be cause we don't support bank debits when it's most common
        if ($this->event->type === 'payment_intent.succeeded') {
            StripeWebhookJob::handleSuccessfulPayment($this->event);
        }
    }
}
