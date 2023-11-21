<?php

use App\Http\Controllers\api\AttributeController;
use App\Http\Controllers\Auth\EmailConfirmationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompleteProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::view('/', 'pages.landing');

// API
Route::prefix('api')->group(function () {
    Route::controller(AttributeController::class)->group(function () {
        Route::get('/attributes', 'getValues');
    });
});
// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/logout', 'logout')->name('logout');
})->middleware('auth');

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
})->middleware('guest');

Route::prefix('login')->group(function () {
    Route::controller(LoginController::class)->middleware('guest')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'authenticate');
    });

    Route::controller(EmailConfirmationController::class)->middleware('auth')->group(function () {
        Route::get('/email-confirmation', 'getPage')->name('verification.notice');
        Route::post('/email-confirmation', 'resendEmail')->middleware('throttle:2,1');
        Route::get('/email-confirmation/verify/{id}/{hash}', 'verifyEmail')->middleware('signed')->name('verification.verify');
    });
});

Route::prefix('products')->group(function () {
    Route::controller(ProductListingController::class)->middleware(['auth', 'verified'])->group(function () {
        Route::get('/new', 'getPage')->name('productListing');
        Route::post('/new', 'addProduct');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/{id}', 'getPage')->name('product');
    });
});

Route::prefix('profile')->group(function () {
    Route::controller(CompleteProfileController::class)->group(function () {
        Route::get('complete', 'getPage')->name('complete-profile');
        Route::post('complete', 'postProfile');
    });
})->middleware(['auth', 'verified']);

Route::prefix('cart')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/', 'getPage')->name('cart');
    });
})->middleware(['auth', 'verified']);
