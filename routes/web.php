<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/search', [UserController::class, 'search']);

Route::middleware(['auth'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/{productId}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/{productId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/cart/complete', [CartController::class, 'completeCart'])->name('cart.complete');
    });
});

// Register
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store'])->middleware('throttle:1,1');
Route::delete('/register', [RegisterUserController::class, 'destroy'])->name('register.destroy');

Route::controller(SessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy')->name('logout');
});

// Products
Route::get('/', [ProductController::class, 'index'])->name('product.index');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.show');


Route::middleware(['role:admin'])->group(function () {
    Route::controller(ProductController::class)->group(function () {
//        Route::get('/products', 'index')->name('product.index');
        Route::get('/products', 'create')->name('product.create');
        Route::post('/products', 'store')->name('product.store');
        Route::get('/products/{product}/edit', 'edit')->name('product.edit');
        Route::put('/products/{product}', 'update')->name('product.update');
        Route::delete('/products/{product}', 'destroy')->name('product.destroy');
    });

    Route::controller(ServiceController::class)->group(function () {
        Route::get('/services', 'index')->name('service.index');
        Route::get('/services/create', 'create')->name('service.create');
        Route::post('/services', 'store')->name('service.store');
        Route::get('/services/{service}', 'show')->name('service.show');
        Route::get('/services/{service}/edit', 'edit')->name('service.edit');
        Route::put('/services/{service}', 'update')->name('service.update');
        Route::delete('/services/{service}', 'destroy')->name('service.destroy');
        Route::get('/services/{service}/edit-finish', 'editFinish')->name('service.editFinish');
        Route::put('/services/{service}/finish', 'finish')->name('service.finish');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth')
        ->name('dashboard');

    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/orders/completed', 'completedOrders')->name('orders.completed');
        Route::post('/orders/completed/pdf', 'generatePDF')->name('orders.generatePDF');
    });
});

Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications()->update(['read_at' => now()]);
    return response()->json(['status' => 'ok']);
})->name('notifications.read');
