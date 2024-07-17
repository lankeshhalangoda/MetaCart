<?php

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/csrf-token', function() {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::middleware('auth')->group(function () {
    //Pages
    Route::get('/', [BaseController::class, 'index'])->name('dashboard');
    Route::get('/productspage', [BaseController::class, 'productspage'])->name('productspage');
    Route::get('/orderspage', [BaseController::class, 'orderspage'])->name('orderspage');

    //Advanced Search Query Controllers
    Route::get('/orders-with-users-and-items', [OrderController::class, 'getOrdersWithUsersAndItems']);
    Route::get('/users-with-roles', [UserController::class, 'getUsersWithRoles']);
    Route::get('/ordered-products', [ProductController::class, 'getOrderedProducts']);
    Route::get('/search-products', [ProductController::class, 'searchProducts']);

    //Count
    Route::get('/products/count', [ProductController::class, 'countProducts']);
    Route::get('/orders/count', [OrderController::class, 'countOrders']);

    Route::prefix('api')->group(function () {
        // Product Routes
        Route::get('/products', [ProductController::class, 'index']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::get('/products/{product}', [ProductController::class, 'show']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        // Order Routes
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
    });


});

require __DIR__.'/auth.php';
