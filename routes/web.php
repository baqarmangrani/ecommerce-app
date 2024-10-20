<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Middleware\ApplyDiscounts;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index');
    }
    return view('welcome');
})->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::put('/products/restock/{id}', [ProductController::class, 'restock'])->name('products.restock');

    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class)->middleware(ApplyDiscounts::class);
    Route::resource('tags', TagController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-email', function () {
    $order = Order::first(); // Assuming you have at least one order in the database
    Mail::to('recipient@example.com')->send(new OrderPlacedMail($order));
    return 'Email sent!';
});

require __DIR__ . '/auth.php';
