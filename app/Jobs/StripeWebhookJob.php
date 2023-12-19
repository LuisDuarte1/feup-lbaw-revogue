<?php

namespace App\Jobs;

use App\Http\Controllers\CheckoutController;
use App\Models\Purchase;
use App\Models\PurchaseIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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

            $ids = [];
            foreach ($products as $product) {
                array_push($ids, $product->id);
            }
            $order->products()->attach($ids);
            CheckoutController::createOrderMessageThread($order);
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
