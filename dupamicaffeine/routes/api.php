<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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