<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [MarketplaceController::class, 'index'])->name('home');

Route::get('/checkout/{listing}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{listing}', [CheckoutController::class, 'store'])->name('checkout.store');