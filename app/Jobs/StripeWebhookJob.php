<?php

namespace App\Jobs;

use App\Models\PurchaseIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
