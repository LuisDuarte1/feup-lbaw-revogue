<?php

namespace App\Http\Controllers\webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class StripeController extends Controller
{
    public function processWebhook(Request $request){
        try{
            $event = \Stripe\Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature'), config('payments.stripe_webhook_secret'));
        } 
        catch(\UnexpectedValueException $e){
            return response()->json(["error" => "failed to process webhook"], 400);

        }
        //TODO (luisd): send job to process webhook

        return response()->json([], 200);
    }
}
