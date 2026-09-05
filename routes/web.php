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
Route::post('/checkout/{package}/configure', [CheckoutController::class, 'configure'])->name('checkout.configure');
Route::get('/checkout/{package}/payment', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
Route::post('/checkout/{package}/payment', [CheckoutController::class, 'processPayment'])->name('checkout.process');

Route::get('/checkout/invoice/{invoice}/crypto-pay', [CheckoutController::class, 'showCryptoPayment'])->name('checkout.crypto-pay');
Route::post('/checkout/invoice/{invoice}/crypto-txid', [CheckoutController::class, 'submitCryptoTxid'])->name('checkout.crypto-submit-txid');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

Route::get('/customer/invoices/{invoice}/print', function (\App\Models\Invoice $invoice) {
    abort_unless(auth()->check() && (auth()->id() === $invoice->user_id || (auth()->user()->is_admin ?? false)), 403);
    return view('customer.invoice-print', ['invoice' => $invoice]);
})->middleware('auth')->name('customer.invoices.print');

