<?php

namespace App\Http\Controllers\webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\StripeWebhookJob;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function processWebhook(Request $request)
    {
        try {
            $event = \Stripe\Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature'), config('payments.stripe_webhook_secret'));
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'failed to process webhook'], 400);

        }
        StripeWebhookJob::dispatch($event);

        return response()->json([], 200);
    }
}
