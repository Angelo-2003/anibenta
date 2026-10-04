<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;

// Marketplace Routes
Route::get('/', [MarketplaceController::class, 'index'])->name('home');
Route::get('/checkout/{listing}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{listing}', [CheckoutController::class, 'store'])->name('checkout.store');

// Proxy Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/listings', [DashboardController::class, 'storeListing'])->name('dashboard.storeListing');
Route::patch('/dashboard/orders/{order}/complete', [DashboardController::class, 'completeOrder'])->name('dashboard.completeOrder');