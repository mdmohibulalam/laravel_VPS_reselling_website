<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Order;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function show(Package $package)
    {
        return view('checkout', compact('package'));
    }

    public function process(Request $request, Package $package)
    {
        $authType = $request->input('auth_type', 'register');
        $user = Auth::user();

        // 1. Authenticate or Register User
        if (!$user) {
            if ($authType === 'login') {
                $request->validate([
                    'login_email' => 'required|email',
                    'login_password' => 'required|string',
                ], [
                    'login_email.required' => 'Please enter your account email address.',
                    'login_password.required' => 'Please enter your password.',
                ]);

                if (!Auth::attempt(['email' => $request->login_email, 'password' => $request->login_password], true)) {
                    return back()
                        ->withInput()
                        ->withErrors(['login_error' => 'Invalid email or password. Please check your credentials or reset your password.']);
                }

                $user = Auth::user();
            } else {
                // New User Registration
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                ], [
                    'email.unique' => 'An account with this email already exists. Click "Existing Client Log In" above to sign in.',
                ]);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                Auth::login($user);
            }
        }

        // 2. Validate Checkout Form Details
        $request->validate([
            'billing_cycle' => 'required|in:monthly,annually,biennially',
            'os' => 'nullable|string|max:100',
            'datacenter' => 'nullable|string|max:100',
            'hostname' => 'nullable|string|max:255',
            'root_password' => 'nullable|string|min:6',
            'payment_type' => 'required|in:stripe,manual',
            'payment_method_id' => 'required_if:payment_type,stripe|nullable|string',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        // 3. Calculate Pricing & Discounts
        $monthlyPrice = (float) $package->price_monthly;
        $cycle = $request->input('billing_cycle', 'monthly');
        $months = 1;
        $cycleDiscountPercent = 0;

        if ($cycle === 'annually') {
            $months = 12;
            $cycleDiscountPercent = 20; // 20% savings
        } elseif ($cycle === 'biennially') {
            $months = 24;
            $cycleDiscountPercent = 30; // 30% savings
        }

        $baseTotal = $monthlyPrice * $months;
        $cycleDiscountAmount = ($baseTotal * $cycleDiscountPercent) / 100;
        $subtotalAfterCycle = $baseTotal - $cycleDiscountAmount;

        // Apply Coupon if valid
        $couponDiscount = 0;
        $appliedCoupon = null;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();
            if ($coupon) {
                $isExpired = $coupon->expiry_date && now()->gt($coupon->expiry_date);
                $isLimitReached = $coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit;

                if (!$isExpired && !$isLimitReached) {
                    $appliedCoupon = $coupon;
                    if ($coupon->type === 'percentage') {
                        $couponDiscount = ($subtotalAfterCycle * $coupon->value) / 100;
                    } else {
                        $couponDiscount = min($subtotalAfterCycle, (float) $coupon->value);
                    }
                    $coupon->increment('used_count');
                }
            }
        }

        $finalTotal = max(0, round($subtotalAfterCycle - $couponDiscount, 2));

        // 4. Process Stripe Payment if selected
        $paymentIntent = null;
        if ($request->payment_type === 'stripe' && $finalTotal > 0) {
            $stripe = new StripeClient(config('services.stripe.secret'));

            try {
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => (int) round($finalTotal * 100), // in cents
                    'currency' => 'usd',
                    'payment_method' => $request->payment_method_id,
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                    'description' => "VortexCloud VPS Order: {$package->name} ({$cycle}) for {$user->email}",
                ]);

                if ($paymentIntent->status !== 'succeeded') {
                    return back()->withInput()->withErrors(['stripe_error' => 'Payment authorization failed. Please try a different card.']);
                }
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['stripe_error' => 'Stripe Error: ' . $e->getMessage()]);
            }
        }

        // 5. Create Order Record
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $finalTotal,
            'status' => $request->payment_type === 'stripe' ? 'completed' : 'pending',
        ]);

        // 6. Create Invoice Record
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount' => $baseTotal,
            'tax' => 0,
            'total' => $finalTotal,
            'status' => $request->payment_type === 'stripe' ? 'paid' : 'pending',
            'stripe_payment_intent_id' => $paymentIntent->id ?? null,
            'due_date' => $request->payment_type === 'stripe' ? null : now()->addDays(7),
            'paid_at' => $request->payment_type === 'stripe' ? now() : null,
        ]);

        // 7. Store Server Provisioning Data & Create Service
        $serverSpecsConfig = [
            'os' => $request->input('os', 'Ubuntu 24.04 LTS'),
            'datacenter' => $request->input('datacenter', 'US East (New York)'),
            'hostname' => $request->input('hostname', 'vps-' . strtolower(Str::random(6)) . '.vortexcloud.net'),
            'root_password' => $request->input('root_password') ? Hash::make($request->root_password) : null,
            'billing_period' => $cycle,
            'coupon_applied' => $appliedCoupon ? $appliedCoupon->code : null,
        ];

        Service::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'package_id' => $package->id,
            'status' => $request->payment_type === 'stripe' ? 'awaiting_provisioning' : 'awaiting_provisioning',
            'billing_cycle' => $cycle,
            'next_due_date' => now()->addMonths($months),
            'encrypted_credentials' => json_encode($serverSpecsConfig),
        ]);

        $successMessage = $request->payment_type === 'stripe'
            ? '🎉 Payment successful! Your ' . $package->name . ' server provisioning has initiated.'
            : 'Order received! Please complete your payment via Crypto or Bank transfer in your dashboard.';

        return redirect('/customer')->with('success', $successMessage);
    }
}

