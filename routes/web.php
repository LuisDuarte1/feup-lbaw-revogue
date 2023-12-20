<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdminOrderController;
use App\Http\Controllers\admin\AdminPayoutController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\api\AttributeController;
use App\Http\Controllers\api\CartProductController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\Auth\EmailConfirmationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompleteProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
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
Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'getTrendingProducts')->name('landing');

});

// API
Route::prefix('api')->group(function () {
    Route::controller(AttributeController::class)->group(function () {
        Route::get('/attributes', 'getValues');
    });
    Route::middleware(['auth:web', 'verified'])->group(function () {
        Route::controller(CartProductController::class)->group(function () {
            Route::post('/cart', 'AddProductToCart');
            Route::delete('/cart', 'RemoveProductFromCart');
        });
        Route::controller(WishlistController::class)->group(function () {
            Route::post('/wishlist', 'AddProductToWishlist');
            Route::delete('/wishlist', 'RemoveProductFromWishlist');
        });
        Route::controller(SearchController::class)->group(function () {
            Route::get('/search', 'searchGetApi');
        });
        Route::prefix('checkout')->group(function () {
            Route::controller(CheckoutController::class)->group(function () {
                Route::post('/getPaymentIntent', 'getPaymentIntent');
            });
        });
        Route::prefix('notifications')->group(function () {
            Route::controller(NotificationController::class)->group(function () {
                Route::get('/', 'getNotificationsAPI');
                Route::get('unreadCount', 'unreadNotificationCountAPI');

                Route::prefix('{id}')->group(function () {
                    Route::post('/read', 'toggleReadNotificationAPI');

                    Route::post('/dismiss', 'toggleDismissNotificationAPI');
                });
            });
        });
        Route::prefix('messages')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::controller(MessageController::class)->group(function () {
                    Route::post('/', 'sendMessageAPI');
                    Route::get('/', 'getMessagesAPI');
                    Route::post('/bargain', 'sendBargainAPI');
                });
            });
        });
        Route::prefix('bargains')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::controller(MessageController::class)->group(function () {
                    Route::post('/accept', 'acceptBargainAPI');
                    Route::post('/reject', 'rejectBargainAPI');
                });
            });
        });
    });
    Route::prefix('products')->group(function () {
        Route::prefix('{id}')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('/', 'getProductAPI');
            });
        });
    });
});

// Authentication
Route::controller(LoginController::class)->middleware('auth:web')->group(function () {
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->middleware('guest:web')->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::prefix('login')->group(function () {
    Route::controller(LoginController::class)->middleware('guest:web')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'authenticate');
    });

    Route::controller(EmailConfirmationController::class)->middleware('auth:web')->group(function () {
        Route::get('/email-confirmation', 'getPage')->name('verification.notice');
        Route::post('/email-confirmation', 'resendEmail')->middleware('throttle:2,1');
        Route::get('/email-confirmation/verify/{id}/{hash}', 'verifyEmail')->middleware('signed')->name('verification.verify');
    });
});

Route::prefix('products')->group(function () {
    Route::controller(ProductListingController::class)->middleware(['auth:web', 'verified'])->group(function () {
        Route::get('/new', 'getPage')->name('productListing');
        Route::post('/new', 'addProduct');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/{id}', 'getPage')->name('product');
        Route::post('/{id}/delete', 'deleteProduct');
        Route::get('/{id}/edit', 'editProductPage');
        Route::post('/{id}/edit', 'editProduct');
        Route::get('/', 'listProductsDate');
    });
    Route::prefix('{id}')->group(function () {
        Route::prefix('/messages')->group(function () {
            Route::controller(MessageController::class)->group(function () {
                Route::post('/', 'createMessageThread');
            });
        });
    });
});

Route::prefix('profile')->middleware(['auth:web', 'verified'])->group(function () {
    Route::controller(CompleteProfileController::class)->group(function () {
        Route::get('complete', 'getPage')->name('complete-profile');
        Route::post('complete', 'postProfile');
    });
    Route::prefix('{id}')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('/', 'sellingProducts');
            Route::get('/sold', 'soldProducts');
            Route::get('/likes', 'likedProducts');
            Route::get('/history', 'historyProducts');
            Route::get('/reviews', 'reviews');
        });
    });
});

Route::prefix('search')->group(function () {
    Route::controller(SearchController::class)->group(function () {
        Route::get('/', 'searchGet')->name('search');
    });
});

Route::prefix('cart')->middleware(['auth:web', 'verified'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/', 'getPage')->name('cart');
    });
});

Route::prefix('checkout')->middleware(['auth:web', 'verified'])->group(function () {
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/', 'getPage')->name('checkout');
        Route::post('/', 'postPage');
        Route::get('/paymentConfirmation', 'paymentConfirmationPage');
    });
});

Route::prefix('admin')->middleware('auth:webadmin')->group(function () {
    Route::view('/', 'pages.admin.landing');
    Route::view('/payouts', 'pages.admin.payouts');
    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/orders', 'getPage')->name('admin.orders');
        Route::post('/orders', 'updateStatus')->name('admin.orders.update');
    });
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/users', 'getPage')->name('admin.users');
        Route::post('/users/delete', 'removeUser')->name('admin.users.delete');
        Route::post('/users/block', 'banUser')->name('admin.users.block');
        Route::post('/users/update', 'updateUserStatus')->name('admin.users.update');
    });
    Route::controller(AdminPayoutController::class)->group(function () {
        Route::get('/payouts', 'getPage')->name('admin.payouts');
    });
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('admin-login')->withoutMiddleware('auth:webadmin')->middleware('guest:webadmin');
        Route::post('/login', 'authenticate')->withoutMiddleware('auth:webadmin')->middleware('guest:webadmin');
        Route::get('/logout', 'logout');
    });
});

Route::controller(NotificationController::class)->middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/notifications', 'getPage')->name('notifications');
    Route::post('/notifications', 'actionPost');

});

Route::prefix('admin')->group(function () {

    Route::view('/', 'pages.admin.landing');
    Route::view('/users', 'pages.admin.users');
    Route::view('/payouts', 'pages.admin.payouts');
    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/orders', 'getPage')->name('admin.orders');
    });
    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/users', 'getPage')->name('admin.users');
    });
    Route::controller(AdminPayoutController::class)->group(function () {
        Route::get('/payouts', 'getPage')->name('admin.payouts');
    });
});

Route::prefix('orders')->middleware(['auth:web', 'verified'])->group(function () {
    Route::prefix('{id}')->group(function () {
        Route::controller(ReviewController::class)->group(function () {
            Route::get('/review/new', 'getPage')->name('review');
            Route::post('/review/new', 'postPage');
            Route::get('/review/edit', 'editReviewPage');
            Route::post('/review/edit', 'editReview');
            Route::post('/review/delete', 'deleteReview');
        });
    });
});

Route::prefix('messages')->middleware(['auth:web', 'verified'])->group(function () {
    Route::controller(MessageController::class)->group(function () {
        Route::get('/', 'getPage');
    });
});
