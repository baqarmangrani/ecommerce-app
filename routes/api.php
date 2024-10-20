<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index'])->middleware('throttle:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::post('/inventory/restock/{id}', [InventoryController::class, 'restock']);
});