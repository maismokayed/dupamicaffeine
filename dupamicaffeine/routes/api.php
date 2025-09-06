<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\WishlistController;


// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//products
//public
Route::prefix('products')->group(function () {
     Route::get('/', [ProductController::class, 'index']);
      Route::get('{product}', [ProductController::class, 'show']);
       // Admin فقط
    Route::post('/', [ProductController::class, 'store'])
        ->middleware(['auth:sanctum', 'role:Admin']);
    Route::put('{product}', [ProductController::class, 'update'])
        ->middleware(['auth:sanctum', 'role:Admin']);
    Route::delete('{product}', [ProductController::class, 'destroy'])
        ->middleware(['auth:sanctum', 'role:Admin']);
});
//category
//public
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);       
    Route::get('{category}', [CategoryController::class, 'show']);   
    // Admin فقط
    Route::post('/', [CategoryController::class, 'store'])
        ->middleware(['auth:sanctum', 'role:Admin']);
    Route::put('{category}', [CategoryController::class, 'update'])
        ->middleware(['auth:sanctum', 'role:Admin']);
    Route::delete('{category}', [CategoryController::class, 'destroy'])
        ->middleware(['auth:sanctum', 'role:Admin']);

});
// Cart (Customer فقط)
Route::prefix('cart')->middleware(['auth:sanctum', 'role:Customer'])->group(function () {
    Route::get('{cartId}', [CartController::class, 'show']);
    Route::post('add', [CartController::class, 'addOrUpdate']);
    Route::delete('{cartId}/remove/{productId}', [CartController::class, 'removeItem']);
});

//order
Route::middleware(['auth:sanctum', 'role:Customer'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::get('/admin/orders', [OrderController::class, 'indexAdmin']);
});
//coupon
Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::apiResource('coupons', CouponController::class);
});

Route::post('coupons/apply', [CouponController::class, 'apply'])
    ->middleware(['auth:sanctum', 'role:Customer']);

//productreview
Route::middleware(['auth:sanctum', 'role:Customer'])->group(function () {
    Route::post('reviews', [ProductReviewController::class, 'store']);
});
//wishlist
Route::middleware(['auth:sanctum', 'role:Customer'])->group(function () {
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist', [WishlistController::class, 'store']);
    Route::delete('wishlist/{productId}', [WishlistController::class, 'destroy']);
});

