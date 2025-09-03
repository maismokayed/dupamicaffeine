<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//products
Route::prefix('products')->group(function () {
     Route::get('/', [ProductController::class, 'index']);
      Route::post('/', [ProductController::class, 'store']);
      Route::get('{product}', [ProductController::class, 'show']);
       Route::put('{product}', [ProductController::class, 'update']);
        Route::delete('{product}', [ProductController::class, 'destroy']);
});
//category
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);    
    Route::post('/', [CategoryController::class, 'store']);    
    Route::get('{category}', [CategoryController::class, 'show']);   
    Route::put('{category}', [CategoryController::class, 'update']); 
    Route::delete('{category}', [CategoryController::class, 'destroy']); 
});
//cart
use App\Http\Controllers\CartController;

Route::prefix('cart')->group(function () {
    Route::get('{cartId}', [CartController::class, 'show']);
    Route::post('add', [CartController::class, 'addOrUpdate']);
    Route::delete('{cartId}/remove/{productId}', [CartController::class, 'removeItem']);
});
//order
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::middleware('role:admin')->group(function () {
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    });
});