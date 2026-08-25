<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;

Route::get('/', function () {
    return view('home');
});

Route::get('/plans', function () {
    return view('plans');
});

Route::get('/checkout/{package}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{package}', [CheckoutController::class, 'process'])->name('checkout.process');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');
