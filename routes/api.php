<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register'])->name('api.register');
Route::post('/login', [UserController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('api.logout');
    Route::get('/user',  [UserController::class, 'user'])->name('api.user');

    Route::post('/products/filter', [ProductController::class, 'filter'])->name('api.products.filter');
    Route::get('/products', [ProductController::class, 'show'])->name('api.products.show');
    Route::post('/products', [ProductController::class, 'showById'])->name('api.products.showById');
    Route::post('/products/cart/add', [ProductController::class, 'addtocart'])->name('api.cart.add');
    Route::post('/products/cart/delete', [ProductController::class, 'delete'])->name('api.cart.delete');
});
Route::post('/stripe/webhook', [StripeController::class, 'handle'])->name('stripe.webhook');
