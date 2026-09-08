<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;

// Public & Marketing Routes (Protected against aggressive scraping & DoS via throttle:public)
Route::middleware('throttle:public')->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/plans', function () {
        return view('plans');
    });

    Route::get('/privacy-policy', function () {
        return view('legal.privacy');
    })->name('legal.privacy');

    Route::get('/terms-of-service', function () {
        return view('legal.terms');
    })->name('legal.terms');

    Route::get('/cookie-policy', function () {
        return view('legal.cookies');
    })->name('legal.cookies');

    Route::get('/sitemap.xml', function () {
        $packages = \App\Models\Package::where('is_active', true)->get();
        return response()
            ->view('sitemap', compact('packages'))
            ->header('Content-Type', 'text/xml');
    })->name('sitemap');
});

// Checkout Flow with Granular Throttling
Route::get('/checkout/{package}', [CheckoutController::class, 'show'])
    ->middleware('throttle:public')
    ->name('checkout.show');

Route::post('/checkout/{package}/configure', [CheckoutController::class, 'configure'])
    ->middleware('throttle:configure')
    ->name('checkout.configure');

Route::get('/checkout/{package}/payment', [CheckoutController::class, 'showPayment'])
    ->middleware(['auth', 'throttle:public'])
    ->name('checkout.payment');

Route::post('/checkout/{package}/payment', [CheckoutController::class, 'processPayment'])
    ->middleware(['auth', 'throttle:payment'])
    ->name('checkout.process');

Route::get('/checkout/invoice/{invoice}/crypto-pay', [CheckoutController::class, 'showCryptoPayment'])
    ->middleware(['auth', 'throttle:public'])
    ->name('checkout.crypto-pay');

Route::post('/checkout/invoice/{invoice}/crypto-txid', [CheckoutController::class, 'submitCryptoTxid'])
    ->middleware(['auth', 'throttle:crypto-txid'])
    ->name('checkout.crypto-submit-txid');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->name('stripe.webhook');

Route::get('/customer/invoices/{invoice}/print', function (\App\Models\Invoice $invoice) {
    abort_unless(auth()->check() && (auth()->id() === $invoice->user_id || (auth()->user()->is_admin ?? false)), 403);
    return view('customer.invoice-print', ['invoice' => $invoice]);
})->middleware('auth')->name('customer.invoices.print');


