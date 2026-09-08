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
use App\Services\AddonResolverService;

class CheckoutController extends Controller
{
    /**
     * STEP 1: Show Server Configuration Screen
     */
    public function show(Request $request, Package $package, AddonResolverService $resolver)
    {
        $pendingOrder = session('pending_order');
        $isPendingMatch = $pendingOrder && ($pendingOrder['package_id'] ?? null) == $package->id;

        $defaultCycle = $isPendingMatch ? ($pendingOrder['billing_cycle'] ?? 'biennially') : 'biennially';
        $selectedCycle = $request->query('cycle', $request->query('billing_cycle', $defaultCycle));

        if (in_array($selectedCycle, ['1month', 'monthly', 'month'])) {
            $selectedCycle = 'monthly';
        } elseif (in_array($selectedCycle, ['12months', 'annual', 'annually', '1year', 'year'])) {
            $selectedCycle = 'annually';
        } else {
            $selectedCycle = 'biennially';
        }

        $addons = $resolver->getResolvedAddonsForPackage($package);
        return view('checkout', compact('package', 'selectedCycle', 'addons', 'pendingOrder'));
    }

    /**
     * STEP 1 -> STEP 2/3: Validate Configuration, Save Session, Route to Auth or Payment
     */
    public function configure(Request $request, Package $package)
    {
        $request->validate([
            'billing_cycle' => 'required|string|in:monthly,quarterly,semi_annually,annually,biennially,1month,3months,6months,12months,24months',
            'os' => 'nullable|string|max:100',
            'datacenter' => 'nullable|string|max:100',
            'storage_type' => 'nullable|string|max:50',
            'auto_backup' => 'nullable|boolean',
            'private_networking' => 'nullable|boolean',
            'hostname' => 'nullable|string|max:255',
            'root_password' => 'nullable|string|min:6',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $rawCycle = $request->input('billing_cycle', 'biennially');
        if (in_array($rawCycle, ['1month', 'monthly', 'month'])) {
            $cycle = 'monthly';
        } elseif (in_array($rawCycle, ['12months', 'annual', 'annually', '1year', 'year'])) {
            $cycle = 'annually';
        } else {
            $cycle = 'biennially';
        }

        $pendingOrder = session('pending_order', []);
        $pendingOrder = array_merge($pendingOrder, [
            'package_id' => $package->id,
            'billing_cycle' => $cycle,
            'os' => $request->input('os', 'Ubuntu 24.04 LTS'),
            'datacenter' => $request->input('datacenter', 'US East (New York)'),
            'storage_type' => $request->input('storage_type'),
            'auto_backup' => $request->boolean('auto_backup'),
            'private_networking' => $request->boolean('private_networking'),
            'hostname' => $request->input('hostname'),
            'root_password' => $request->input('root_password'),
            'coupon_code' => $request->input('coupon_code'),
        ]);

        session(['pending_order' => $pendingOrder]);

        // If guest, set intended URL to Step 3 and redirect to customer login
        if (!Auth::check()) {
            session(['url.intended' => route('checkout.payment', $package->id)]);
            return redirect('/customer/login')->with('info', 'Please log in or create an account to finalize your order. Your server configuration has been saved!');
        }

        return redirect()->route('checkout.payment', $package->id);
    }

    /**
     * STEP 3: Show Dedicated Payment & Confirmation Screen (Generates Unpaid Invoice Immediately)
     */
    public function showPayment(Request $request, Package $package, AddonResolverService $resolver)
    {
        if (!Auth::check()) {
            session(['url.intended' => route('checkout.payment', $package->id)]);
            return redirect('/customer/login')->with('info', 'Please log in or create an account to finalize your order.');
        }

        $user = Auth::user();
        $pendingOrder = session('pending_order');
        if (!$pendingOrder || ($pendingOrder['package_id'] ?? null) != $package->id) {
            return redirect()->route('checkout.show', $package->id)->with('error', 'Please configure your server options first.');
        }

        // Calculate pricing
        $monthlyPrice = (float) $package->price_monthly;
        $cycle = $pendingOrder['billing_cycle'] ?? 'biennially';

        if ($cycle === 'monthly') {
            $months = 1;
            $cycleDiscountPercent = 0;
            $cycleLabel = 'Monthly (1 Month)';
        } elseif ($cycle === 'annually') {
            $months = 12;
            $cycleDiscountPercent = 15;
            $cycleLabel = 'Annual (12 Months)';
        } else {
            $months = 24;
            $cycleDiscountPercent = 20;
            $cycleLabel = 'Biennial (24 Months)';
        }

        $selectedAddonValues = [
            $pendingOrder['os'] ?? null,
            $pendingOrder['datacenter'] ?? null,
            $pendingOrder['storage_type'] ?? null,
            !empty($pendingOrder['auto_backup']) ? '1' : null,
            !empty($pendingOrder['private_networking']) ? '1' : null,
        ];

        $addonsCalculation = $resolver->calculateAddonsTotal($package, $selectedAddonValues);
        $addonsMonthly = $addonsCalculation['total_monthly'];
        $selectedAddons = $addonsCalculation['addons'];

        $baseTotal = ($monthlyPrice + $addonsMonthly) * $months;
        $cycleDiscountAmount = ($baseTotal * $cycleDiscountPercent) / 100;
        $subtotalAfterCycle = $baseTotal - $cycleDiscountAmount;

        // Apply Coupon if present
        $couponDiscount = 0;
        $appliedCoupon = null;
        $couponCode = $pendingOrder['coupon_code'] ?? null;
        if ($couponCode) {
            $coupon = Coupon::where('code', strtoupper(trim($couponCode)))->first();
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
                }
            }
        }

        $finalTotal = max(0, round($subtotalAfterCycle - $couponDiscount, 2));
        $specsJson = is_string($package->specs) ? json_decode($package->specs, true) : (is_array($package->specs) ? $package->specs : []);

        // 1. Immediately create or retrieve the Order & Unpaid Invoice in the database
        $order = null;
        $invoice = null;
        if (!empty($pendingOrder['invoice_id'])) {
            $invoice = Invoice::where('id', $pendingOrder['invoice_id'])->where('user_id', $user->id)->first();
            $order = $invoice ? Order::find($invoice->order_id) : null;
        }

        if (!$invoice || !$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $finalTotal,
                'status' => 'pending',
            ]);

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'invoice_number' => Invoice::generateNextNumber(),
                'amount' => $baseTotal,
                'tax' => 0,
                'total' => $finalTotal,
                'status' => 'pending',
                'due_date' => now()->addDays(7),
            ]);

            $pendingOrder['order_id'] = $order->id;
            $pendingOrder['invoice_id'] = $invoice->id;
            session(['pending_order' => $pendingOrder]);
        } else {
            // Synchronize totals in case options changed
            $order->update(['total_amount' => $finalTotal]);
            $invoice->update(['amount' => $baseTotal, 'total' => $finalTotal]);
        }

        $stripeEnabled = (bool) config('services.stripe.enabled', true);
        $cryptoEnabled = (bool) config('services.crypto.enabled', true);

        return view('checkout-payment', compact(
            'package',
            'pendingOrder',
            'order',
            'invoice',
            'cycle',
            'cycleLabel',
            'months',
            'monthlyPrice',
            'addonsMonthly',
            'selectedAddons',
            'baseTotal',
            'cycleDiscountPercent',
            'cycleDiscountAmount',
            'appliedCoupon',
            'couponDiscount',
            'finalTotal',
            'specsJson',
            'stripeEnabled',
            'cryptoEnabled'
        ));
    }

    /**
     * STEP 3: Process Final Payment & Server Deployment
     */
    public function processPayment(Request $request, Package $package, AddonResolverService $resolver)
    {
        $user = Auth::user();
        if (!$user) {
            session(['url.intended' => route('checkout.payment', $package->id)]);
            return redirect('/customer/login')->with('info', 'Please log in to complete your payment.');
        }

        $pendingOrder = session('pending_order');
        if (!$pendingOrder || ($pendingOrder['package_id'] ?? null) != $package->id) {
            return redirect()->route('checkout.show', $package->id)->with('error', 'Your session expired. Please configure your server again.');
        }

        $allowedPaymentTypes = [];
        if (config('services.stripe.enabled', true)) {
            $allowedPaymentTypes[] = 'stripe';
        }
        if (config('services.crypto.enabled', true)) {
            $allowedPaymentTypes[] = 'manual';
            $allowedPaymentTypes[] = 'crypto';
        }

        if (empty($allowedPaymentTypes)) {
            return back()->withInput()->withErrors(['payment_type' => 'Payment gateways are currently unavailable. Please contact support.']);
        }

        $request->validate([
            'payment_type' => ['required', 'in:' . implode(',', $allowedPaymentTypes)],
            'payment_method_id' => 'required_if:payment_type,stripe|nullable|string',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        if ($request->filled('coupon_code')) {
            $pendingOrder['coupon_code'] = $request->coupon_code;
        }

        // Pricing calculation
        $monthlyPrice = (float) $package->price_monthly;
        $cycle = $pendingOrder['billing_cycle'] ?? 'biennially';

        if ($cycle === 'monthly') {
            $months = 1;
            $cycleDiscountPercent = 0;
        } elseif ($cycle === 'annually') {
            $months = 12;
            $cycleDiscountPercent = 15;
        } else {
            $months = 24;
            $cycleDiscountPercent = 20;
        }

        $selectedAddonValues = [
            $pendingOrder['os'] ?? null,
            $pendingOrder['datacenter'] ?? null,
            $pendingOrder['storage_type'] ?? null,
            !empty($pendingOrder['auto_backup']) ? '1' : null,
            !empty($pendingOrder['private_networking']) ? '1' : null,
        ];

        $addonsCalculation = $resolver->calculateAddonsTotal($package, $selectedAddonValues);
        $addonsMonthly = $addonsCalculation['total_monthly'];
        $selectedAddons = $addonsCalculation['addons'];

        $baseTotal = ($monthlyPrice + $addonsMonthly) * $months;
        $cycleDiscountAmount = ($baseTotal * $cycleDiscountPercent) / 100;
        $subtotalAfterCycle = $baseTotal - $cycleDiscountAmount;

        $couponDiscount = 0;
        $appliedCoupon = null;
        $couponCode = $pendingOrder['coupon_code'] ?? null;
        if ($couponCode) {
            $coupon = Coupon::where('code', strtoupper(trim($couponCode)))->first();
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

        // Stripe Payment Processing
        $paymentIntent = null;
        if ($request->payment_type === 'stripe' && $finalTotal > 0) {
            $stripe = new StripeClient(config('services.stripe.secret'));
            try {
                $paymentIntent = $stripe->paymentIntents->create([
                    'amount' => (int) round($finalTotal * 100),
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

        // Retrieve or Create Order
        $order = !empty($pendingOrder['order_id']) ? Order::find($pendingOrder['order_id']) : null;
        if (!$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $finalTotal,
                'status' => $request->payment_type === 'stripe' ? 'completed' : 'pending',
            ]);
        } else {
            $order->update([
                'total_amount' => $finalTotal,
                'status' => $request->payment_type === 'stripe' ? 'completed' : 'pending',
            ]);
        }

        // Retrieve or Create Invoice
        $invoice = !empty($pendingOrder['invoice_id']) ? Invoice::find($pendingOrder['invoice_id']) : null;
        if (!$invoice) {
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'invoice_number' => Invoice::generateNextNumber(),
                'amount' => $baseTotal,
                'tax' => 0,
                'total' => $finalTotal,
                'status' => $request->payment_type === 'stripe' ? 'paid' : 'pending',
                'payment_method' => $request->payment_type === 'stripe' ? 'stripe' : 'crypto',
                'stripe_payment_intent_id' => $paymentIntent->id ?? null,
                'due_date' => $request->payment_type === 'stripe' ? null : now()->addDays(7),
                'paid_at' => $request->payment_type === 'stripe' ? now() : null,
            ]);
        } else {
            $invoice->update([
                'amount' => $baseTotal,
                'total' => $finalTotal,
                'status' => $request->payment_type === 'stripe' ? 'paid' : 'pending',
                'payment_method' => $request->payment_type === 'stripe' ? 'stripe' : 'crypto',
                'stripe_payment_intent_id' => $paymentIntent->id ?? null,
                'paid_at' => $request->payment_type === 'stripe' ? now() : null,
            ]);
        }

        // Server Provisioning Data
        $specsJson = is_string($package->specs) ? json_decode($package->specs, true) : (is_array($package->specs) ? $package->specs : []);
        $selectedOS = $selectedAddons->firstWhere('type', 'os');
        $selectedRegion = $selectedAddons->firstWhere('type', 'region');
        $selectedStorage = $selectedAddons->firstWhere('type', 'storage');

        $serverSpecsConfig = [
            'os' => $selectedOS ? $selectedOS->name : ($pendingOrder['os'] ?? 'Ubuntu 24.04 LTS'),
            'os_api_identifier' => $selectedOS?->api_identifier,
            'datacenter' => $selectedRegion ? $selectedRegion->name : ($pendingOrder['datacenter'] ?? 'US East (New York)'),
            'region_api_identifier' => $selectedRegion?->api_identifier,
            'storage_type' => $selectedStorage ? $selectedStorage->name : ($pendingOrder['storage_type'] ?? '100GB'),
            'auto_backup' => !empty($pendingOrder['auto_backup']),
            'private_networking' => !empty($pendingOrder['private_networking']),
            'hostname' => $pendingOrder['hostname'] ?? ('vps-' . strtolower(Str::random(6)) . '.vortexcloud.net'),
            'root_password' => !empty($pendingOrder['root_password']) ? Hash::make($pendingOrder['root_password']) : null,
            'billing_period' => $cycle,
            'coupon_applied' => $appliedCoupon ? $appliedCoupon->code : null,
        ];

        $cycleRecurringAmount = round($subtotalAfterCycle, 2);

        Service::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'package_id' => $package->id,
            'status' => 'awaiting_provisioning',
            'billing_cycle' => $cycle,
            'recurring_amount' => $cycleRecurringAmount,
            'specs_snapshot' => [
                'package_name' => $package->name,
                'cores' => $specsJson['cores'] ?? 'N/A',
                'memory' => $specsJson['memory'] ?? 'N/A',
                'storage' => $selectedStorage ? $selectedStorage->name : ($specsJson['storage'] ?? 'N/A'),
                'bandwidth' => $specsJson['bandwidth'] ?? ($specsJson['port'] ?? '1 Gbps'),
                'os' => $selectedOS ? $selectedOS->name : 'Ubuntu 24.04 LTS',
                'datacenter' => $selectedRegion ? $selectedRegion->name : 'US East (New York)',
            ],
            'active_addons' => $selectedAddons->map(fn($a) => [
                'id' => $a->id,
                'type' => $a->type,
                'name' => $a->name,
                'value' => $a->value,
                'api_identifier' => $a->api_identifier,
                'price' => (float) $a->price,
            ])->toArray(),
            'next_due_date' => now()->addMonths($months),
            'encrypted_credentials' => json_encode($serverSpecsConfig),
        ]);

        // Clean up pending session order
        session()->forget('pending_order');

        if ($request->payment_type === 'stripe') {
            return redirect('/customer/invoices')->with('success', '🎉 Payment successful! Invoice ' . $invoice->invoice_number . ' is marked as paid and server provisioning has initiated.');
        }

        // For Crypto payment, redirect immediately to the dedicated Crypto Payment Screen:
        return redirect()->route('checkout.crypto-pay', $invoice->id)->with('info', 'Invoice generated! Please transfer the exact crypto amount and submit your transaction hash below.');
    }

    /**
     * Dedicated Interactive Crypto Payment Screen
     */
    public function showCryptoPayment(Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $invoice->user_id && !Auth::guard('admin')->check())) {
            session(['url.intended' => route('checkout.crypto-pay', $invoice->id)]);
            return redirect('/customer/login')->with('info', 'Please sign in to view your payment instructions.');
        }

        $wallets = config('services.crypto.wallets', [
            'usdt_trc20' => env('CRYPTO_USDT_TRC20_ADDRESS', 'TPFMfZU4cPcfi3ivmUECDj9bYy5aWdZ4EE'),
            'usdc_polygon' => env('CRYPTO_USDC_POLYGON_ADDRESS', '0x73F701571238739aBce996b6D7358599411FE233'),
            'usdt_polygon' => env('CRYPTO_USDT_POLYGON_ADDRESS', '0x73F701571238739aBce996b6D7358599411FE233'),
        ]);

        $order = $invoice->order;
        $service = Service::where('order_id', $order?->id)->latest()->first();

        return view('checkout-crypto-pay', compact('invoice', 'order', 'service', 'wallets'));
    }

    /**
     * Submit Crypto Transaction Proof (TxID / Hash)
     */
    public function submitCryptoTxid(Request $request, Invoice $invoice)
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $invoice->user_id && !Auth::guard('admin')->check())) {
            return redirect('/customer/login')->with('error', 'Unauthorized.');
        }

        $request->validate([
            'crypto_network' => 'required|string|in:usdt_trc20,usdc_polygon,usdt_polygon',
            'crypto_txid' => 'required|string|min:8|max:120',
        ], [
            'crypto_txid.required' => 'Please provide the transaction hash (TxID) from your wallet or exchange.',
            'crypto_txid.min' => 'The transaction hash seems too short. Please verify your blockchain transaction ID.',
        ]);

        $wallets = config('services.crypto.wallets', []);
        $chosenWallet = $wallets[$request->crypto_network] ?? null;

        $invoice->update([
            'crypto_network' => $request->crypto_network,
            'crypto_wallet_address' => $chosenWallet,
            'crypto_txid' => trim($request->crypto_txid),
            'payment_method' => 'crypto',
        ]);

        return back()->with('success', '✓ Transaction hash submitted successfully! Our team will verify the transfer on the blockchain and activate your server.');
    }
}
