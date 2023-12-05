<?php

namespace App\Jobs;

use App\Models\Purchase;
use App\Models\PurchaseIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class StripeWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    static public function handleSuccessfulPayment(\Stripe\Event $event){
        $paymentIntent = $event->data->object;
        
        $purchaseIntent = PurchaseIntent::where('payment_intent_id', $paymentIntent->id)->get()->first();

        //we assume if the paymentIntent isn't found we just skip it. But it's never supposed to happen
        if(!isset($paymentIntent->id)){
            return;
        }
        $cart = $purchaseIntent->products()->get();
        $cartGrouped = $purchaseIntent->products()->groupBy('sold_by');
        DB::beginTransaction();
        $purchase = Purchase::create(['method' => 'stripe']);
        foreach ($cartGrouped as $soldBy => $products) {
            $order = $purchaseIntent->user()->orders()->create([
                'status' => 'pendingShipment', //payment at delivery goes straight to pendingShipment
                'shipping_address' => [
                    'name' => $purchaseIntent->shipping_address->full_name,
                    'email' => $purchaseIntent->shipping_address->email,
                    'country' => $purchaseIntent->shipping_address->country,
                    'address' => $purchaseIntent->shipping_address->address,
                    'zip-code' => $purchaseIntent->shipping_address->zip_code,
                    'phone' => $purchaseIntent->shipping_address->phone,
                ],
                'purchase' => $purchase->id,
            ]);

            $ids = [];
            foreach ($products as $product) {
                array_push($ids, $product->id);
            }
            $order->products()->attach($ids);
        }
        // TODO(luisd): send notification
        foreach ($cart as $product) {
            $product->inCart()->detach();
            $product->wishlist()->detach();
        }
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
        if($this->event->type === 'payment_intent.succeeded'){
            StripeWebhookJob::handleSuccessfulPayment($this->event);
        }
    }
}
