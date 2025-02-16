<?php

use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// past in postman : http://127.0.0.1:8000/
Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class,'index']);
    Route::post('/', [ProductController::class,'store']);
    Route::get('/{id}', [ProductController::class,'show']);
    Route::put('/{id}', [ProductController::class,'update']);
    Route::delete('/{id}', [ProductController::class,'destroy']);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class,'show']);
    Route::delete('/{id}', [CategoryController::class,'destroy']);
    Route::put('/{id}', [CategoryController::class,'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('cart-items', [CartItemController::class, 'index']);
    Route::post('cart-items', [CartItemController::class, 'store']);
    Route::put('cart-items/{cart_id}', [CartItemController::class, 'update']);
    Route::delete('cart-items/{cart_id}', [CartItemController::class, 'destroy']);
    Route::get('/cart/count', [CartItemController::class, 'count']);
});

Route::prefix('/mgt-user')->group(function () {
    Route::get('/', [UserController::class,'index']);
    Route::get('/id={id}', [UserController::class,'show']);
    Route::put('/update-on-id={id}', [UserController::class,'update']);
    Route::delete('/update-on-id={id}', [UserController::class, 'destroy']);
});
