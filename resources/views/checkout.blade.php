<x-app-layout 
    :title="'Configure & Checkout - ' . $package->name" 
    description="Customize your high-performance NVMe cloud VPS instance with 1-click OS install, global datacenter regions, and instant automated provisioning."
    headerVariant="minimal"
    robots="noindex, nofollow"
>
    @php
        $specs = is_string($package->specs) ? json_decode($package->specs, true) : (is_array($package->specs) ? $package->specs : []);
        
        $coresVal = !empty($specs['cores']) 
            ? (str_contains(strtolower((string)$specs['cores']), 'core') || str_contains(strtolower((string)$specs['cores']), 'vcpu') 
                ? $specs['cores'] 
                : $specs['cores'] . ' vCPU Cores') 
            : '1 vCPU Core';

        $ramVal = !empty($specs['memory']) 
            ? (str_contains(strtolower((string)$specs['memory']), 'ram') || str_contains(strtolower((string)$specs['memory']), 'ddr') 
                ? $specs['memory'] 
                : $specs['memory'] . ' DDR5 RAM') 
            : '2 GB DDR5 RAM';

        $rawStorage = !empty($specs['storage']) ? (string)$specs['storage'] : '40 GB';
        $cleanStorage = preg_replace('/(nvme|ssd|storage)/i', '', $rawStorage);
        $storageVal = trim($cleanStorage) . ' Gen4 NVMe';

        $portVal = !empty($specs['port']) 
            ? $specs['port'] 
            : (!empty($specs['bandwidth']) ? $specs['bandwidth'] : '1 Gbps Unmetered');

        $baseMonthly = (float) $package->price_monthly;
        $annualMonthly = !empty($package->price_annually) ? round(((float)$package->price_annually)/12, 2) : round($baseMonthly * 0.85, 2); // 15% off
        if ($annualMonthly <= 0 && $baseMonthly > 0) $annualMonthly = round($baseMonthly * 0.85, 2);

        $biennialMonthly = !empty($package->price_biennially) ? round(((float)$package->price_biennially)/24, 2) : round($baseMonthly * 0.80, 2); // 20% off
        if ($biennialMonthly <= 0 && $baseMonthly > 0) $biennialMonthly = round($baseMonthly * 0.80, 2);

        // Pre-selected cycle passed from Homepage / Plans page or default to 24 months
        $currentCycle = request('cycle', request('billing_cycle', $selectedCycle ?? old('billing_cycle', 'biennially')));
        if (in_array($currentCycle, ['1month', 'monthly', 'month'])) {
            $currentCycle = 'monthly';
        } elseif (in_array($currentCycle, ['12months', 'annual', 'annually', '1year', 'year'])) {
            $currentCycle = 'annually';
        } else {
            $currentCycle = 'biennially';
        }
    @endphp

    <div class="py-10 md:py-16 bg-slate-50/70 min-h-[90vh]">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Top Funnel Header -->
            <div class="text-center max-w-2xl mx-auto mb-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-purple-50 border border-purple-200 text-[#673DE6] text-xs font-bold uppercase tracking-wider mb-3 shadow-soft-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>60-Second Instant Cloud Provisioning</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Configure Your VPS Server
                </h1>
                <p class="text-sm sm:text-base text-slate-600 mt-2">
                    Customize your cloud instance specifications. Your virtual server deploys automatically upon payment confirmation.
                </p>
            </div>

            <!-- Global Validation Alerts -->
            @if(isset($errors) && $errors->any())
                <div class="max-w-6xl mx-auto mb-8 bg-rose-50 border border-rose-200 text-rose-800 p-5 rounded-2xl shadow-soft-sm">
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

            <form id="checkout-form" action="{{ route('checkout.process', $package->id) }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method_id" id="payment_method_id">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start max-w-6xl mx-auto">
                    
                    <!-- LEFT COLUMN: Progressive Order Funnel Steps (7 Cols) -->
                    <div class="lg:col-span-7 space-y-8">
                        
                        <!-- STEP 1: CHOOSE BILLING PERIOD (Hostinger Style) -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm">
                            <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">1</span>
                                    <h2 class="text-lg font-bold text-slate-900">Choose Billing Period</h2>
                                </div>
                                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">Save up to 20%</span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3.5">
                                
                                <!-- 1 Month -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="billing_cycle" value="monthly" class="peer sr-only" {{ $currentCycle === 'monthly' ? 'checked' : '' }} onchange="updateCalculations()">
                                    <div class="h-full p-4 rounded-2xl border-2 border-slate-200 bg-white hover:border-purple-300 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/40 peer-checked:shadow-soft-md transition-all flex flex-col justify-between text-center group">
                                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">1 Month</div>
                                        <div class="my-2">
                                            <span class="text-2xl font-extrabold text-slate-900">${{ number_format($baseMonthly, 2) }}</span>
                                            <span class="text-xs text-slate-500 block">/mo</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">Standard rate</div>
                                    </div>
                                </label>

                                                                <!-- 3 Months -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="billing_cycle" value="quarterly" class="peer sr-only" {{ $currentCycle === 'quarterly' ? 'checked' : '' }} onchange="updateCalculations()">
                                    <div class="h-full p-4 rounded-2xl border-2 border-slate-200 bg-white hover:border-purple-300 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/40 peer-checked:shadow-soft-md transition-all flex flex-col justify-between text-center group">
                                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">3 Months</div>
                                        <div class="my-2">
                                            <span class="text-2xl font-extrabold text-slate-900">${{ number_format($baseMonthly, 2) }}</span>
                                            <span class="text-xs text-slate-500 block">/mo</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">Quarterly rate</div>
                                    </div>
                                </label>

                                <!-- 6 Months -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="billing_cycle" value="semi_annually" class="peer sr-only" {{ $currentCycle === 'semi_annually' ? 'checked' : '' }} onchange="updateCalculations()">
                                    <div class="h-full p-4 rounded-2xl border-2 border-slate-200 bg-white hover:border-purple-300 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/40 peer-checked:shadow-soft-md transition-all flex flex-col justify-between text-center group">
                                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">6 Months</div>
                                        <div class="my-2">
                                            <span class="text-2xl font-extrabold text-slate-900">${{ number_format($baseMonthly, 2) }}</span>
                                            <span class="text-xs text-slate-500 block">/mo</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500">Semi-Annual rate</div>
                                    </div>
                                </label>

                                <!-- 12 Months (SAVE 15%) -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="billing_cycle" value="annually" class="peer sr-only" {{ $currentCycle === 'annually' ? 'checked' : '' }} onchange="updateCalculations()">
                                    <div class="h-full p-4 rounded-2xl border-2 border-slate-200 bg-white hover:border-purple-300 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/40 peer-checked:shadow-soft-md transition-all flex flex-col justify-between text-center relative group">
                                        <!-- Top Badge -->
                                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-[#673DE6] text-white text-[10px] font-extrabold uppercase tracking-wider py-0.5 px-2.5 rounded-full shadow-sm whitespace-nowrap">
                                            Save 15%
                                        </div>
                                        <div class="text-xs font-bold text-purple-900 uppercase tracking-wider mb-1 pt-1">12 Months</div>
                                        <div class="my-2">
                                            <span class="text-2xl font-extrabold text-[#673DE6]">${{ number_format($annualMonthly, 2) }}</span>
                                            <span class="text-xs text-slate-500 block">/mo</span>
                                        </div>
                                        <div class="text-[11px] font-semibold text-emerald-600">Billed annually</div>
                                    </div>
                                </label>

                                <!-- 24 Months (SAVE 20%) -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="billing_cycle" value="biennially" class="peer sr-only" {{ $currentCycle === 'biennially' ? 'checked' : '' }} onchange="updateCalculations()">
                                    <div class="h-full p-4 rounded-2xl border-2 border-slate-200 bg-white hover:border-purple-300 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/40 peer-checked:shadow-soft-md transition-all flex flex-col justify-between text-center relative group">
                                        <!-- Top Badge -->
                                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-[10px] font-extrabold uppercase tracking-wider py-0.5 px-2.5 rounded-full shadow-sm whitespace-nowrap">
                                            Save 20%
                                        </div>
                                        <div class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-1 pt-1">24 Months</div>
                                        <div class="my-2">
                                            <span class="text-2xl font-extrabold text-slate-900">${{ number_format($biennialMonthly, 2) }}</span>
                                            <span class="text-xs text-slate-500 block">/mo</span>
                                        </div>
                                        <div class="text-[11px] font-semibold text-emerald-600">Billed 2 years</div>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <!-- STEP 2: CLOUD SERVER CONFIGURATOR -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm space-y-6">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">2</span>
                                    <h2 class="text-lg font-bold text-slate-900">Server Configuration</h2>
                                </div>
                                <span class="text-xs text-slate-500 font-medium">1-Click Auto Deploy</span>
                            </div>

                            <!-- Operating System Selector -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                                    Select Operating System
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @php $osList = $addons->get('os', collect()); @endphp
                                    @foreach($osList as $index => $os)
                                    <label class="cursor-pointer {{ Str::contains(strtolower($os->name), 'windows') ? 'col-span-2 sm:col-span-2' : '' }}">
                                        <input type="radio" name="os" value="{{ $os->value }}" data-price="{{ $os->price }}" class="addon-radio peer sr-only" {{ old('os', $index === 0 ? $os->value : '') === $os->value ? 'checked' : '' }} onchange="updateOSDisplay('{{ $os->name }}'); updateCalculations();">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-base font-bold shrink-0">
                                                    @if(Str::contains(strtolower($os->name), 'ubuntu')) 🐧
                                                    @elseif(Str::contains(strtolower($os->name), 'debian')) 🍥
                                                    @elseif(Str::contains(strtolower($os->name), 'almalinux')) 🛡️
                                                    @elseif(Str::contains(strtolower($os->name), 'rocky')) 🦅
                                                    @elseif(Str::contains(strtolower($os->name), 'windows')) 🪟
                                                    @else 💿
                                                    @endif
                                                </div>
                                                <div class="truncate">
                                                    <div class="text-xs font-bold text-slate-900 truncate">{{ $os->name }}</div>
                                                    <div class="text-[10px] text-slate-500">Premium Image</div>
                                                </div>
                                            </div>
                                            @if($os->price > 0)
                                                <span class="text-[10px] font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md">+${{ number_format($os->price, 2) }}/mo</span>
                                            @endif
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            r justify-between text-sm">
                                    <span class="text-slate-600">Period Subtotal</span>
                                    <span id="summary-subtotal" class="font-bold text-slate-900">${{ number_format($baseMonthly * 12, 2) }}</span>
                                </div>
                                <div id="summary-cycle-discount-row" class="flex items-center justify-between text-sm text-emerald-600 font-semibold">
                                    <span>Term Discount (<span id="summary-discount-pct">20%</span>)</span>
                                    <span id="summary-discount-amt">-${{ number_format(($baseMonthly * 12) * 0.20, 2) }}</span>
                                </div>
                                <div id="summary-coupon-row" class="hidden items-center justify-between text-sm text-purple-600 font-semibold">
                                    <span>Coupon Discount</span>
                                    <span id="summary-coupon-amt">-$0.00</span>
                                </div>
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
                                        <div id="summary-total-display" class="text-3xl font-extrabold text-slate-900 tracking-tight">
                                            ${{ number_format($annualMonthly * 12, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main CTA Submit Button -->
                            <div class="p-6 pt-0">
                                <button type="submit" id="submit-button" class="btn-shimmer w-full bg-[#673DE6] hover:bg-[#5428D8] text-white font-extrabold py-4 px-6 rounded-xl shadow-xl shadow-[#673DE6]/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 text-base">
                                    <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <span id="button-text">Complete Order & Deploy Server</span>
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
                                <span><strong>256-Bit SSL Encryption</strong> powered by Stripe</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span><strong>24/7 Dedicated Sysadmin Support</strong> desk</span>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Stripe JS SDK & Real-Time Price/Auth Script -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const baseMonthly = {{ $baseMonthly }};
        let currentDiscountPercent = 20; // default for 12 mo
        let currentMonths = 12;

        function updateOSDisplay(val) {
            const el = document.getElementById('summary-os-display');
            if (el) el.textContent = val;
        }

        function updateLocationDisplay(val) {
            const el = document.getElementById('summary-loc-display');
            if (el) el.textContent = val;
        }

        function switchAuthTab(type) {
            document.getElementById('auth_type').value = type;
            const regBtn = document.getElementById('tab-btn-register');
            const logBtn = document.getElementById('tab-btn-login');
            const regPanel = document.getElementById('auth-panel-register');
            const logPanel = document.getElementById('auth-panel-login');

            if (type === 'register') {
                regBtn.className = 'py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all bg-white text-[#673DE6] shadow-sm';
                logBtn.className = 'py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all text-slate-600 hover:text-slate-900';
                regPanel.classList.remove('hidden');
                logPanel.classList.add('hidden');
            } else {
                logBtn.className = 'py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all bg-white text-[#673DE6] shadow-sm';
                regBtn.className = 'py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all text-slate-600 hover:text-slate-900';
                logPanel.classList.remove('hidden');
                regPanel.classList.add('hidden');
            }
        }

        function togglePaymentMethod(method) {
            const stripeContainer = document.getElementById('stripe-container');
            const manualInfo = document.getElementById('manual-info');
            const btnText = document.getElementById('button-text');

            if (method === 'stripe') {
                stripeContainer.classList.remove('hidden');
                manualInfo.classList.add('hidden');
                btnText.textContent = 'Complete Order & Deploy Server';
            } else {
                stripeContainer.classList.add('hidden');
                manualInfo.classList.remove('hidden');
                btnText.textContent = 'Place Order (Pay with Crypto / Bank)';
            }
        }

        function updateCalculations() {
            const selectedCycle = document.querySelector('input[name="billing_cycle"]:checked')?.value || 'biennially';
            
            if (selectedCycle === 'monthly' || selectedCycle === '1month') {
                currentMonths = 1;
                currentDiscountPercent = 0;
            } else if (selectedCycle === 'quarterly' || selectedCycle === '3months') {
                currentMonths = 3;
                currentDiscountPercent = 0;
            } else if (selectedCycle === 'semi_annually' || selectedCycle === '6months') {
                currentMonths = 6;
                currentDiscountPercent = 0;
            } else if (selectedCycle === 'annually' || selectedCycle === '12months') {
                currentMonths = 12;
                currentDiscountPercent = 15; // 15% savings
            } else {
                currentMonths = 24;
                currentDiscountPercent = 20; // 20% savings
            }

            // Calculate Addon Prices
            let addonsMonthly = 0;
            document.querySelectorAll('.addon-radio:checked').forEach(function(el) {
                addonsMonthly += parseFloat(el.getAttribute('data-price') || 0);
            });

            const rawBase = (baseMonthly + addonsMonthly) * currentMonths;
            const discountAmt = (rawBase * currentDiscountPercent) / 100;
            const total = rawBase - discountAmt;

            document.getElementById('summary-subtotal').textContent = '$' + rawBase.toFixed(2);
            
            const discRow = document.getElementById('summary-cycle-discount-row');
            if (currentDiscountPercent > 0) {
                discRow.classList.remove('hidden');
                discRow.classList.add('flex');
                document.getElementById('summary-discount-pct').textContent = currentDiscountPercent + '%';
                document.getElementById('summary-discount-amt').textContent = '-$' + discountAmt.toFixed(2);
            } else {
                discRow.classList.add('hidden');
                discRow.classList.remove('flex');
            }

            document.getElementById('summary-total-display').textContent = '$' + total.toFixed(2);
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
            feedback.textContent = 'Coupon "' + code.toUpperCase() + '" will be verified upon checkout.';
        }

        // Stripe Card Element Setup
        document.addEventListener("DOMContentLoaded", function() {
            updateCalculations();

            const stripeKey = '{{ config('services.stripe.key') }}';
            let stripe = null;
            let elements = null;
            let card = null;

            if (stripeKey) {
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
                card.mount('#card-element');

                card.on('change', function(event) {
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = event.error ? event.error.message : '';
                });
            }

            const form = document.getElementById('checkout-form');
            form.addEventListener('submit', function(event) {
                const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

                if (paymentType === 'manual') {
                    return true;
                }

                event.preventDefault();

                if (!stripe) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = "Stripe credentials are not configured. Please choose Manual Payment or configure Stripe keys.";
                    return;
                }

                document.getElementById('submit-button').disabled = true;
                document.getElementById('button-text').textContent = 'Processing Payment...';
                document.getElementById('spinner').classList.remove('hidden');

                const nameInput = document.querySelector('input[name="name"]')?.value || '{{ auth()->user()?->name }}' || 'Customer';
                const emailInput = document.querySelector('input[name="email"]')?.value || document.querySelector('input[name="login_email"]')?.value || '{{ auth()->user()?->email }}';

                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: nameInput,
                        email: emailInput
                    }
                }).then(function(result) {
                    if (result.error) {
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        document.getElementById('submit-button').disabled = false;
                        document.getElementById('button-text').textContent = 'Complete Order & Deploy Server';
                        document.getElementById('spinner').classList.add('hidden');
                    } else {
                        document.getElementById('payment_method_id').value = result.paymentMethod.id;
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>

