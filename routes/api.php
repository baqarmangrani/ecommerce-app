<?php
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index'])->middleware('throttle:api');
;

Route::post('login', 'API\RegisterController@login');


// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/orders', [OrderController::class, 'store']);
//     Route::middleware('can:manage-inventory')->group(function () {
//         Route::post('/inventory/restock', [InventoryController::class, 'restock']);
//     });
// });