<?php

use App\Http\Controllers\webhooks\StripeController;
use Illuminate\Support\Facades\Route;

Route::prefix('webhook')->group(function () {
    Route::controller(StripeController::class)->group(function () {
        Route::post('stripe', 'processWebhook');
    });
});
