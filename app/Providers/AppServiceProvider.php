<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(125);
        \Illuminate\Database\Eloquent\Model::unguard();

        $this->configureRateLimiting();
    }

    /**
     * Configure application-wide named rate limiters.
     */
    protected function configureRateLimiting(): void
    {
        // 1. Universal Payment Processing Throttle (5 attempts per 10 mins per User/IP)
        // Protects Crypto TxID submissions now; stops card-testing later.
        RateLimiter::for('payment', function (Request $request) {
            $key = ($request->user()?->id ?: $request->ip());
            return Limit::perMinutes(10, 5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Too many payment attempts. Please wait 10 minutes before trying again.',
                        ], 429, $headers);
                    }
                    return back()->with('error', 'Too many payment attempts. For your security, please wait a few minutes before trying again.')->withHeaders($headers);
                });
        });

        // 2. Crypto TxID Submission Throttle (5 submissions per 10 mins per Invoice/User/IP)
        // Prevents spamming false blockchain hashes to the verification queue.
        RateLimiter::for('crypto-txid', function (Request $request) {
            $invoiceId = $request->route('invoice')?->id ?? 'global';
            $userKey = $request->user()?->id ?: $request->ip();
            $key = "{$userKey}|{$invoiceId}";

            return Limit::perMinutes(10, 5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Too many transaction hash submissions. Please wait before trying again.',
                        ], 429, $headers);
                    }
                    return back()->with('error', 'Too many transaction submissions. Please wait a few minutes before submitting another TxID.')->withHeaders($headers);
                });
        });

        // 3. Server Configuration & Coupon Code Throttle (15 attempts per minute per IP)
        // Stops coupon brute-force attacks and session flooding.
        RateLimiter::for('configure', function (Request $request) {
            return Limit::perMinute(15)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Too many configuration attempts. Please wait a moment.',
                        ], 429, $headers);
                    }
                    return back()->with('error', 'Too many requests. Please slow down and wait a moment.')->withHeaders($headers);
                });
        });

        // 4. Public Marketing & Catalog Browsing Throttle (60 requests per minute per IP)
        // Protects against aggressive scraping and DoS on homepage, plans, and sitemaps.
        RateLimiter::for('public', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // 5. Authentication & Registration Throttle (5 attempts per minute per Email + IP)
        // Defense against credential stuffing and brute-force registration scripts.
        RateLimiter::for('auth', function (Request $request) {
            $email = (string) $request->input('email', '');
            $key = Str::transliterate(Str::lower($email)) . '|' . $request->ip();
            return Limit::perMinute(5)
                ->by($key)
                ->response(function (Request $request, array $headers) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Too many authentication attempts. Please try again in 1 minute.',
                        ], 429, $headers);
                    }
                    return back()->with('error', 'Too many attempts. For your security, please wait 60 seconds before trying again.')->withHeaders($headers);
                });
        });
    }
}

