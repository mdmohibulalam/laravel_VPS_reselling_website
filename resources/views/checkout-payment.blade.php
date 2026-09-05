<x-app-layout 
    title="Secure Payment & Server Deployment - VortexCloud" 
    description="Finalize your cloud VPS order and initiate immediate server provisioning." 
    headerVariant="solid"
    robots="noindex, nofollow">

    @php
        $user = auth()->user();
        $coresVal = $specsJson['cores'] ?? '4 vCPU Cores';
        $ramVal = $specsJson['memory'] ?? '8 GB RAM';
        $storageVal = $pendingOrder['storage_type'] ?? ($specsJson['storage'] ?? '100 GB Gen4 NVMe');
        $portVal = $specsJson['bandwidth'] ?? ($specsJson['port'] ?? '1 Gbps');

        $stripeActive = $stripeEnabled ?? config('services.stripe.enabled', true);
        $cryptoActive = $cryptoEnabled ?? config('services.crypto.enabled', true);

        $defaultPaymentMethod = old('payment_type');
        if (!$defaultPaymentMethod) {
            if ($stripeActive) {
                $defaultPaymentMethod = 'stripe';
            } elseif ($cryptoActive) {
                $defaultPaymentMethod = 'manual';
            } else {
                $defaultPaymentMethod = '';
            }
        }
    @endphp

    <div class="py-10 md:py-16 bg-slate-50/70 min-h-[90vh]">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Top Funnel Header -->
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-purple-50 border border-purple-200 text-[#673DE6] text-xs font-bold uppercase tracking-wider mb-3 shadow-soft-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Step 3 of 3: Final Step</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Review Order & Secure Payment
                </h1>
                <p class="text-sm sm:text-base text-slate-600 mt-2">
                    Review your configured server specs and select your preferred payment gateway to initiate instant provisioning.
                </p>
            </div>

            <!-- Standard 3-Step Funnel Stepper Card -->
            <div class="max-w-3xl mx-auto mb-10">
                <div class="bg-white border border-slate-200/90 rounded-2xl p-2 sm:p-2.5 shadow-soft-sm">
                    <div class="grid grid-cols-3 gap-1.5 sm:gap-3">
                        
                        <!-- Step 1: Completed -->
                        <a href="{{ route('checkout.show', ['package' => $package->id, 'cycle' => $cycle]) }}" class="flex items-center gap-2 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-700 hover:bg-emerald-100/70 transition-all group" title="Click to edit server configuration">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-emerald-500 text-white font-black text-xs sm:text-sm flex items-center justify-center shadow-md shadow-emerald-500/25 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="hidden sm:block text-[10px] font-extrabold uppercase tracking-wider text-emerald-600 leading-none mb-0.5">Completed</span>
                                <span class="block text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-700 truncate">1. Configure</span>
                            </div>
                        </a>

                        <!-- Step 2: Completed -->
                        <div class="flex items-center gap-2 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 text-emerald-700">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-emerald-500 text-white font-black text-xs sm:text-sm flex items-center justify-center shadow-md shadow-emerald-500/25 shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="min-w-0">
                                <span class="hidden sm:block text-[10px] font-extrabold uppercase tracking-wider text-emerald-600 leading-none mb-0.5">Verified</span>
                                <span class="block text-xs sm:text-sm font-bold text-slate-900 truncate">2. Identity</span>
                            </div>
                        </div>

                        <!-- Step 3: Active -->
                        <div class="flex items-center gap-2 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-purple-50/90 border border-purple-200/80 text-[#673DE6]">
                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-[#673DE6] text-white font-extrabold text-xs sm:text-sm flex items-center justify-center shadow-md shadow-[#673DE6]/30 shrink-0">
                                3
                            </div>
                            <div class="min-w-0">
                                <span class="hidden sm:block text-[10px] font-extrabold uppercase tracking-wider text-purple-600 leading-none mb-0.5">Active Step</span>
                                <span class="block text-xs sm:text-sm font-bold text-slate-900 truncate">3. Payment & Deploy</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Global Validation Alerts -->
            @if(isset($errors) && $errors->any())
                <div class="w-full mb-8 bg-rose-50 border border-rose-200 text-rose-800 p-5 rounded-2xl shadow-soft-sm">
                    <div class="flex items-center gap-2.5 font-bold text-sm mb-2 text-rose-900">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Please correct the following before proceeding:</span>
                    </div>
                    <ul class="list-disc pl-6 space-y-1 text-xs sm:text-sm text-rose-700 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="checkout-payment-form" action="{{ route('checkout.process', $package->id) }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method_id" id="payment_method_id">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-start w-full">
                    
                    <!-- LEFT COLUMN: Account & Payment Steps (7-8 Cols) -->
                    <div class="lg:col-span-7 xl:col-span-8 space-y-8">
                        
                        <!-- CARD 0: OFFICIAL INVOICE GENERATED -->
                        @if(isset($invoice) && $invoice)
                            <div class="bg-white p-6 sm:p-7 rounded-3xl border-2 border-purple-200 shadow-soft-sm relative overflow-hidden">
                                <div class="absolute top-0 right-0 transform translate-x-4 -translate-y-4 w-28 h-28 bg-purple-500/10 rounded-full blur-2xl pointer-events-none"></div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 mb-4 border-b border-slate-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-purple-100 text-[#673DE6] flex items-center justify-center font-bold shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h2 class="text-lg font-extrabold text-slate-900">Invoice #{{ $invoice->invoice_number }}</h2>
                                                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-700 text-[11px] font-bold uppercase tracking-wider flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    Pending Payment
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">Order Ref: <span class="font-mono font-semibold text-slate-700">{{ $order->order_number ?? 'ORD-PENDING' }}</span> • Generated on {{ $invoice->created_at ? $invoice->created_at->format('M d, Y') : now()->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ url('/customer/invoices') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#673DE6] hover:text-[#5428D8] bg-purple-50 hover:bg-purple-100 border border-purple-200 px-3.5 py-2 rounded-xl transition-all self-start sm:self-auto shrink-0">
                                        <span>View In Portal</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <span class="text-slate-400 block font-medium">Billed To</span>
                                        <span class="font-bold text-slate-900 truncate block">{{ $user->name }}</span>
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <span class="text-slate-400 block font-medium">Due Date</span>
                                        <span class="font-bold text-slate-900 block">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') : now()->addDays(7)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <span class="text-slate-400 block font-medium">Amount Due</span>
                                        <span class="font-bold text-[#673DE6] text-sm block">${{ number_format($invoice->total, 2) }}</span>
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <span class="text-slate-400 block font-medium">Payment Status</span>
                                        <span class="font-bold text-amber-600 block">Awaiting Payment</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- CARD 1: VERIFIED CUSTOMER IDENTITY -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm">
                            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-xs flex items-center justify-center shadow-md shadow-emerald-500/30">✓</span>
                                    <h2 class="text-lg font-bold text-slate-900">Customer Account</h2>
                                </div>
                                <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Verified & Linked
                                </span>
                            </div>

                            <div class="p-4 bg-purple-50/60 border border-purple-200/80 rounded-2xl flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-12 h-12 rounded-xl bg-[#673DE6] text-white font-extrabold flex items-center justify-center text-lg shadow-md shadow-[#673DE6]/25">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs text-purple-900 font-semibold">Active Client Account</div>
                                        <div class="text-base font-extrabold text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-600 font-mono">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <a href="{{ url('/customer/profile') }}" target="_blank" class="text-xs text-[#673DE6] hover:text-[#5428D8] font-bold underline transition-colors">
                                    Manage Profile
                                </a>
                            </div>
                        </div>

                        <!-- CARD 2: CONFIGURED SERVER SPECS REVIEW -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm">
                            <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">⚙️</span>
                                    <h2 class="text-lg font-bold text-slate-900">Configured Cloud Instance</h2>
                                </div>
                                <a href="{{ route('checkout.show', ['package' => $package->id, 'cycle' => $cycle]) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#673DE6] hover:text-[#5428D8] bg-purple-50 hover:bg-purple-100 px-3 py-1.5 rounded-xl transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span>Edit Configuration</span>
                                </a>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Plan & Billing Cycle</div>
                                    <div class="text-sm font-extrabold text-slate-900">{{ $package->name }}</div>
                                    <div class="text-xs text-[#673DE6] font-semibold mt-0.5">{{ $cycleLabel }}</div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Operating System</div>
                                    <div class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                        <span>🐧</span>
                                        <span>{{ $pendingOrder['os'] ?? 'Ubuntu 24.04 LTS' }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">Automated image install</div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Datacenter Region</div>
                                    <div class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                        <span>📍</span>
                                        <span>{{ $pendingOrder['datacenter'] ?? 'US East (New York)' }}</span>
                                    </div>
                                    <div class="text-xs text-emerald-600 font-semibold mt-0.5">Low-latency premium tier</div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">Hostname</div>
                                    <div class="text-sm font-extrabold text-slate-900 font-mono truncate">
                                        {{ $pendingOrder['hostname'] ?: 'vps-auto.vortexcloud.net' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">Automated DNS binding</div>
                                </div>
                            </div>

                            @if(!empty($pendingOrder['auto_backup']) || !empty($pendingOrder['private_networking']))
                                <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap gap-2">
                                    @if(!empty($pendingOrder['auto_backup']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                                            <span>🛡️</span> Daily Automated Backups
                                        </span>
                                    @endif
                                    @if(!empty($pendingOrder['private_networking']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold">
                                            <span>🔒</span> 10Gbps Private VPC Networking
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- CARD 3: PAYMENT METHOD -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">💳</span>
                                    <h2 class="text-lg font-bold text-slate-900">Select Payment Method</h2>
                                </div>
                                <span class="text-xs text-slate-500 font-medium flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    256-Bit SSL Encrypted
                                </span>
                            </div>

                            <!-- Payment Method Toggle -->
                            @if($stripeActive && $cryptoActive)
                                <div class="grid grid-cols-2 gap-3.5">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_type" value="stripe" class="peer sr-only" {{ $defaultPaymentMethod === 'stripe' ? 'checked' : '' }} onchange="togglePaymentMethod('stripe')">
                                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 peer-checked:shadow-soft-sm hover:border-purple-300 transition-all text-center">
                                            <div class="text-2xl mb-1">💳</div>
                                            <span class="block text-slate-900 font-bold text-sm">Credit / Debit Card</span>
                                            <span class="text-[11px] text-slate-500">Instant via Stripe</span>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_type" value="manual" class="peer sr-only" {{ $defaultPaymentMethod === 'manual' ? 'checked' : '' }} onchange="togglePaymentMethod('manual')">
                                        <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 peer-checked:shadow-soft-sm hover:border-purple-300 transition-all text-center">
                                            <div class="text-2xl mb-1">💎</div>
                                            <span class="block text-slate-900 font-bold text-sm">Cryptocurrency</span>
                                            <span class="text-[11px] text-slate-500">USDT & USDC (Tron / Polygon)</span>
                                        </div>
                                    </label>
                                </div>
                            @elseif($stripeActive)
                                <div class="grid grid-cols-1">
                                    <label class="cursor-default">
                                        <input type="radio" name="payment_type" value="stripe" class="sr-only" checked>
                                        <div class="p-4 rounded-2xl border-2 border-[#673DE6] bg-purple-50/50 shadow-soft-sm flex items-center justify-between">
                                            <div class="flex items-center gap-3.5">
                                                <div class="text-2xl">💳</div>
                                                <div class="text-left">
                                                    <span class="block text-slate-900 font-bold text-sm">Credit / Debit Card</span>
                                                    <span class="text-[11px] text-slate-500">Instant server deployment via Stripe</span>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-[#673DE6] bg-white border border-purple-200 px-3 py-1 rounded-full">
                                                Active Method
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            @elseif($cryptoActive)
                                <div class="grid grid-cols-1">
                                    <label class="cursor-default">
                                        <input type="radio" name="payment_type" value="manual" class="sr-only" checked>
                                        <div class="p-4 rounded-2xl border-2 border-[#673DE6] bg-purple-50/50 shadow-soft-sm flex items-center justify-between">
                                            <div class="flex items-center gap-3.5">
                                                <div class="text-2xl">💎</div>
                                                <div class="text-left">
                                                    <span class="block text-slate-900 font-bold text-sm">Cryptocurrency (USDT & USDC)</span>
                                                    <span class="text-[11px] text-slate-500">Tron TRC-20 & Polygon PoS • Fast settlement & low gas fees</span>
                                                </div>
                                            </div>
                                            <span class="text-xs font-bold text-[#673DE6] bg-white border border-purple-200 px-3 py-1 rounded-full">
                                                Active Method
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            @else
                                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm">
                                    <div class="font-bold flex items-center gap-2 mb-1">
                                        <span>⚠️</span> Online Payments Temporarily Unavailable
                                    </div>
                                    <p>Online payment methods are currently undergoing maintenance. Please reach out to our 24/7 support desk to process your order.</p>
                                </div>
                            @endif

                            <!-- Stripe Card Element Container -->
                            @if($stripeActive)
                                <div id="stripe-container" class="{{ $defaultPaymentMethod === 'stripe' ? '' : 'hidden' }} space-y-2">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Card Information</label>
                                    <div id="card-element" class="bg-white border border-slate-200 p-4 rounded-xl shadow-soft-sm"></div>
                                    <div id="card-errors" class="text-rose-600 text-xs font-semibold mt-1"></div>
                                </div>
                            @endif

                            <!-- Crypto Payment Info Box -->
                            @if($cryptoActive)
                                <div id="manual-info" class="{{ $defaultPaymentMethod === 'manual' ? '' : 'hidden' }} p-4 rounded-2xl bg-purple-50/80 border border-purple-200 text-purple-950 text-xs sm:text-sm leading-relaxed">
                                    <div class="font-bold mb-1 flex items-center gap-1.5 text-purple-900">
                                        <span>ℹ️</span> How Crypto Payment Works:
                                    </div>
                                    <p>When you click <strong>Place Order & Pay with Crypto</strong>, you will be directed to our interactive payment station with our verified USDT (Tron), USDC (Polygon), and USDT (Polygon) wallet addresses and scannable QR codes. Once transferred, submit your transaction hash to initiate instant server provisioning.</p>
                                </div>
                            @endif

                            <!-- Coupon Code Input -->
                            <div class="pt-4 border-t border-slate-100">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Have a Promotional Code?</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $pendingOrder['coupon_code'] ?? '') }}" placeholder="e.g. VORTEX20" class="flex-grow bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 uppercase font-mono tracking-wider focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none">
                                    <button type="button" onclick="applyCouponClient()" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-4 py-2.5 rounded-xl text-xs transition-colors shrink-0">
                                        Apply
                                    </button>
                                </div>
                                <div id="coupon-feedback" class="text-xs mt-1.5 font-medium {{ $appliedCoupon ? 'text-emerald-600 block' : 'hidden' }}">
                                    @if($appliedCoupon)
                                        ✓ Coupon "{{ $appliedCoupon->code }}" applied (Saved ${{ number_format($couponDiscount, 2) }})
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Sticky Order Summary (4-5 Cols) -->
                    <div class="lg:col-span-5 xl:col-span-4 sticky top-28 space-y-5">
                        
                        <div class="rounded-3xl bg-white border border-slate-200 shadow-soft-lg overflow-hidden">
                            
                            <!-- Cosmic Violet Gradient Header Strip -->
                            <div class="p-6 bg-gradient-to-r from-[#180033] to-[#25004A] text-white">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider text-purple-300">Selected Plan</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-bold font-mono">Instant Setup</span>
                                </div>
                                <h3 class="text-2xl font-extrabold text-white tracking-tight">{{ $package->name }}</h3>
                                <div class="text-xs text-purple-200 mt-0.5">High-Frequency AMD EPYC™ Cloud Instance</div>
                            </div>

                            <!-- Hardware Specs Snapshot -->
                            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Included Hardware Specs</div>
                                <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">⚡</span> CPU Compute
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $coresVal }}</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">🧠</span> Memory (RAM)
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $ramVal }}</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">💾</span> NVMe Storage
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $storageVal }}</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">🌐</span> Network Port
                                        </span>
                                        <span class="font-bold text-slate-900">{{ $portVal }}</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">🐧</span> OS Image
                                        </span>
                                        <span class="font-bold text-slate-900 truncate max-w-[150px]">
                                            {{ $pendingOrder['os'] ?? 'Ubuntu 24.04 LTS' }}
                                        </span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">📍</span> Datacenter
                                        </span>
                                        <span class="font-bold text-slate-900 truncate max-w-[150px]">
                                            {{ $pendingOrder['datacenter'] ?? 'US East (New York)' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Final Price Calculation Breakdown -->
                            <div class="p-6 space-y-3">
                                @if(isset($invoice) && $invoice)
                                    <div class="flex items-center justify-between text-xs pb-2.5 mb-1 border-b border-slate-100">
                                        <span class="text-slate-500 font-medium">Invoice Reference</span>
                                        <span class="font-mono font-bold text-[#673DE6] bg-purple-50 px-2 py-0.5 rounded-md border border-purple-200/80">#{{ $invoice->invoice_number }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Period Subtotal</span>
                                    <span class="font-bold text-slate-900">${{ number_format($baseTotal, 2) }}</span>
                                </div>

                                @if($cycleDiscountAmount > 0)
                                    <div class="flex items-center justify-between text-sm text-emerald-600 font-semibold">
                                        <span>Term Discount ({{ $cycleDiscountPercent }}%)</span>
                                        <span>-${{ number_format($cycleDiscountAmount, 2) }}</span>
                                    </div>
                                @endif

                                @if($couponDiscount > 0)
                                    <div class="flex items-center justify-between text-sm text-purple-600 font-semibold">
                                        <span>Coupon Discount</span>
                                        <span>-${{ number_format($couponDiscount, 2) }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">Setup & Provisioning</span>
                                    <span class="font-bold text-emerald-600 uppercase text-xs">FREE ($0.00)</span>
                                </div>

                                <div class="pt-3 border-t border-slate-100 flex items-baseline justify-between">
                                    <div>
                                        <div class="text-base font-bold text-slate-900">Total Due Today:</div>
                                        <div class="text-xs text-slate-500">Includes all taxes & fees</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                            ${{ number_format($finalTotal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main CTA Submit Button -->
                            <div class="p-6 pt-0">
                                <button type="submit" id="submit-button" {{ (!$stripeActive && !$cryptoActive) ? 'disabled' : '' }} class="btn-shimmer w-full bg-[#673DE6] hover:bg-[#5428D8] text-white font-extrabold py-4 px-6 rounded-xl shadow-xl shadow-[#673DE6]/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 text-base cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <span id="button-text">
                                        @if(!$stripeActive && !$cryptoActive)
                                            Payment Methods Unavailable
                                        @elseif($defaultPaymentMethod === 'manual')
                                            Place Order & Pay with Crypto
                                        @else
                                            Pay ${{ number_format($finalTotal, 2) }} & Deploy Server
                                        @endif
                                    </span>
                                    <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </button>
                            </div>

                        </div>

                        <!-- Trust & Security Badges -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 space-y-3 text-xs text-slate-600 shadow-soft-sm">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>30-Day Money-Back Guarantee</strong> if unsatisfied</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>256-Bit SSL Encryption</strong> enterprise secure</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>Instant Provisioning Engine</strong> active</span>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Stripe JS SDK & Checkout Scripts -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function togglePaymentMethod(method) {
            const stripeContainer = document.getElementById('stripe-container');
            const manualInfo = document.getElementById('manual-info');
            const btnText = document.getElementById('button-text');

            if (method === 'stripe') {
                if (stripeContainer) stripeContainer.classList.remove('hidden');
                if (manualInfo) manualInfo.classList.add('hidden');
                if (btnText) btnText.textContent = 'Pay ${{ number_format($finalTotal, 2) }} & Deploy Server';
            } else {
                if (stripeContainer) stripeContainer.classList.add('hidden');
                if (manualInfo) manualInfo.classList.remove('hidden');
                if (btnText) btnText.textContent = 'Place Order & Pay with Crypto';
            }
        }

        function applyCouponClient() {
            const code = document.getElementById('coupon_code').value.trim();
            const feedback = document.getElementById('coupon-feedback');
            
            if (!code) {
                feedback.className = 'text-xs mt-1.5 font-medium text-rose-600 block';
                feedback.textContent = 'Please enter a coupon code.';
                return;
            }

            feedback.className = 'text-xs mt-1.5 font-medium text-emerald-600 block';
            feedback.textContent = 'Coupon "' + code.toUpperCase() + '" will be verified upon placing order.';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const stripeKey = '{{ config('services.stripe.key') }}';
            const stripeActive = {{ $stripeActive ? 'true' : 'false' }};
            let stripe = null;
            let elements = null;
            let card = null;

            if (stripeKey && stripeActive) {
                stripe = Stripe(stripeKey);
                elements = stripe.elements();

                const style = {
                    base: {
                        color: '#0f172a',
                        fontFamily: '"Inter", sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '15px',
                        '::placeholder': { color: '#94a3b8' }
                    },
                    invalid: {
                        color: '#e11d48',
                        iconColor: '#e11d48'
                    }
                };

                card = elements.create('card', { style: style });
                const cardMountElem = document.getElementById('card-element');
                if (cardMountElem) {
                    card.mount('#card-element');

                    card.on('change', function(event) {
                        const displayError = document.getElementById('card-errors');
                        if (displayError) {
                            displayError.textContent = event.error ? event.error.message : '';
                        }
                    });
                }
            }

            const form = document.getElementById('checkout-payment-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    const checkedRadio = document.querySelector('input[name="payment_type"]:checked');
                    if (!checkedRadio) {
                        event.preventDefault();
                        alert('No payment method is selected or available.');
                        return;
                    }
                    const paymentType = checkedRadio.value;

                    if (paymentType === 'manual') {
                        document.getElementById('submit-button').disabled = true;
                        document.getElementById('button-text').textContent = 'Placing Order...';
                        document.getElementById('spinner').classList.remove('hidden');
                        return true;
                    }

                    event.preventDefault();

                    if (!stripe || !card) {
                        const errorElement = document.getElementById('card-errors');
                        if (errorElement) {
                            errorElement.textContent = "Stripe credentials are not configured in environment. Please choose Crypto / Bank Wire.";
                        }
                        return;
                    }

                    document.getElementById('submit-button').disabled = true;
                    document.getElementById('button-text').textContent = 'Processing Payment...';
                    document.getElementById('spinner').classList.remove('hidden');

                    stripe.createPaymentMethod({
                        type: 'card',
                        card: card,
                        billing_details: {
                            name: '{{ $user->name ?? "Customer" }}',
                            email: '{{ $user->email ?? "user@example.com" }}'
                        }
                    }).then(function(result) {
                        if (result.error) {
                            const errorElement = document.getElementById('card-errors');
                            if (errorElement) {
                                errorElement.textContent = result.error.message;
                            }
                            document.getElementById('submit-button').disabled = false;
                            document.getElementById('button-text').textContent = 'Pay ${{ number_format($finalTotal, 2) }} & Deploy Server';
                            document.getElementById('spinner').classList.add('hidden');
                        } else {
                            document.getElementById('payment_method_id').value = result.paymentMethod.id;
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>
