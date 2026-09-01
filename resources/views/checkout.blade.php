<x-app-layout>
    <div class="py-16 md:py-24 bg-white min-h-[85vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3.5 py-1 rounded-full mb-3 border border-indigo-100">
                    Secure Checkout
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Complete Your VPS Order</h1>
                <p class="text-slate-600 mt-2">Instant automated provisioning will begin immediately upon payment verification.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start">
                
                <!-- Order Summary (Left) -->
                <div class="md:col-span-5 order-2 md:order-1">
                    <div class="bg-slate-50 p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-soft-sm sticky top-28">
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-200">
                            <h2 class="text-lg font-bold text-slate-900">Order Summary</h2>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-md bg-indigo-100 text-indigo-700">1 Month</span>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-slate-900">{{ $package->name }}</h3>
                            <span class="text-xs text-slate-500">Dedicated Virtual Private Server</span>
                        </div>

                        @php $specs = is_string($package->specs) ? json_decode($package->specs, true) : $package->specs; @endphp
                        
                        <ul class="text-sm text-slate-700 space-y-2.5 mb-6 py-4 border-y border-slate-200/80">
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">CPU Compute</span>
                                <span class="font-semibold">{{ !empty($specs['cores']) ? (str_contains(strtolower($specs['cores']), 'core') || str_contains(strtolower($specs['cores']), 'vcpu') ? $specs['cores'] : $specs['cores'] . ' vCPU Cores') : '1 vCPU Core' }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">System Memory</span>
                                <span class="font-semibold">{{ !empty($specs['memory']) ? (str_contains(strtolower($specs['memory']), 'ram') ? $specs['memory'] : $specs['memory'] . ' RAM') : '2 GB DDR5' }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">NVMe Storage</span>
                                <span class="font-semibold">{{ !empty($specs['storage']) ? (str_contains(strtolower($specs['storage']), 'storage') ? $specs['storage'] : $specs['storage'] . ' NVMe') : '40 GB Gen4' }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">Operating System</span>
                                <span class="font-semibold">{{ strtolower($package->category) === 'rdp' ? 'Windows OS (RDP)' : 'Linux (Ubuntu 24.04)' }}</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">Network Uplink</span>
                                <span class="font-semibold">1 Gbps Unmetered</span>
                            </li>
                            <li class="flex items-center justify-between">
                                <span class="text-slate-500">DDoS Mitigation</span>
                                <span class="font-semibold text-emerald-600">Included Free</span>
                            </li>
                        </ul>

                        <div class="pt-2 flex justify-between items-baseline">
                            <span class="text-sm font-semibold text-slate-700">Total Due Today:</span>
                            <div class="text-right">
                                <span class="text-3xl font-extrabold text-slate-900">${{ number_format($package->price_monthly, 2) }}</span>
                                <span class="text-xs text-slate-500 block">Renews monthly, cancel anytime</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment & Customer Form (Right) -->
                <div class="md:col-span-7 order-1 md:order-2">
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-soft-md">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 pb-3 border-b border-slate-100">Account & Payment Details</h2>
                        
                        @if(isset($errors) && $errors->any())
                            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl mb-6 text-sm">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form id="payment-form" action="{{ route('checkout.process', $package->id) }}" method="POST">
                            @csrf
                            
                            @guest
                                <div class="space-y-4 mb-6">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Full Name</label>
                                        <input type="text" name="name" required placeholder="Jane Doe" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Address</label>
                                        <input type="email" name="email" required placeholder="jane@company.com" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Account Password</label>
                                        <input type="password" name="password" required minlength="8" placeholder="••••••••••••" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                </div>
                            @endguest
                            
                            @auth
                                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs text-slate-500">Logged in account:</div>
                                        <div class="text-sm font-bold text-slate-900">{{ auth()->user()->name }} ({{ auth()->user()->email }})</div>
                                    </div>
                                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                    <input type="hidden" name="is_logged_in" value="1">
                                </div>
                            @endauth
                            
                            <div class="mb-6">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Select Payment Method</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_type" value="stripe" class="peer sr-only" {{ old('payment_type', 'stripe') === 'stripe' ? 'checked' : '' }} onchange="togglePaymentMethod(this.value)">
                                        <div class="bg-slate-50 border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 rounded-2xl p-4 text-center transition-all">
                                            <span class="block text-slate-900 font-bold text-sm mb-0.5">Credit / Debit Card</span>
                                            <span class="text-xs text-slate-500">Instant via Stripe</span>
                                        </div>
                                    </label>
                                    
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_type" value="manual" class="peer sr-only" {{ old('payment_type') === 'manual' ? 'checked' : '' }} onchange="togglePaymentMethod(this.value)">
                                        <div class="bg-slate-50 border-2 border-slate-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 rounded-2xl p-4 text-center transition-all">
                                            <span class="block text-slate-900 font-bold text-sm mb-0.5">Manual Payment</span>
                                            <span class="text-xs text-slate-500">Crypto / Bank Transfer</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div id="stripe-container" class="mb-6 {{ old('payment_type', 'stripe') === 'stripe' ? '' : 'hidden' }}">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Card Details</label>
                                <div id="card-element" class="bg-white border border-slate-200 p-4 rounded-xl shadow-soft-sm"></div>
                                <div id="card-errors" class="text-rose-600 text-xs mt-2 font-medium"></div>
                            </div>
                            
                            <div id="manual-info" class="mb-6 {{ old('payment_type', 'stripe') === 'manual' ? '' : 'hidden' }} bg-slate-50 border border-slate-200 p-4 rounded-2xl">
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    You will receive manual payment instructions (Crypto Wallet addresses / Bank wire details) immediately via email and in your Customer Portal. Server will deploy once transfer is verified.
                                </p>
                            </div>
                            
                            <input type="hidden" name="payment_method_id" id="payment_method_id">
                            
                            <button type="submit" id="submit-button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-500/25 hover:-translate-y-0.5 transition-all duration-200 flex justify-center items-center gap-2 text-base">
                                <span id="button-text">{{ old('payment_type', 'stripe') === 'stripe' ? 'Pay $' . number_format($package->price_monthly, 2) . ' & Deploy Server' : 'Place Order (Pay Later)' }}</span>
                                <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function togglePaymentMethod(method) {
            if (method === 'stripe') {
                document.getElementById('stripe-container').classList.remove('hidden');
                document.getElementById('manual-info').classList.add('hidden');
                document.getElementById('button-text').textContent = 'Pay ${{ number_format($package->price_monthly, 2) }} & Deploy Server';
            } else {
                document.getElementById('stripe-container').classList.add('hidden');
                document.getElementById('manual-info').classList.remove('hidden');
                document.getElementById('button-text').textContent = 'Place Order (Pay Later)';
            }
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            var stripeKey = '{{ config('services.stripe.key') }}';
            var stripe = null;
            var elements = null;
            var card = null;
            
            if (stripeKey) {
                stripe = Stripe(stripeKey);
                elements = stripe.elements();
                
                var style = {
                    base: {
                        color: '#0f172a',
                        fontFamily: '"Inter", sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '15px',
                        '::placeholder': {
                            color: '#94a3b8'
                        }
                    },
                    invalid: {
                        color: '#e11d48',
                        iconColor: '#e11d48'
                    }
                };
                
                card = elements.create('card', {style: style});
                card.mount('#card-element');
                
                card.on('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
            }
            
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                var paymentType = document.querySelector('input[name="payment_type"]:checked').value;
                
                if (paymentType === 'manual') {
                    return true; 
                }
                
                // Stripe Flow
                event.preventDefault();
                
                if (!stripe) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = "Stripe is not configured. Please select Manual Payment or configure Stripe keys.";
                    return;
                }
                
                document.getElementById('submit-button').disabled = true;
                document.getElementById('button-text').textContent = 'Processing Payment...';
                document.getElementById('spinner').classList.remove('hidden');
                
                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: document.querySelector('input[name="name"]')?.value || '{{ auth()->user()?->name }}',
                        email: document.querySelector('input[name="email"]')?.value || '{{ auth()->user()?->email }}'
                    }
                }).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        
                        document.getElementById('submit-button').disabled = false;
                        document.getElementById('button-text').textContent = 'Pay ${{ number_format($package->price_monthly, 2) }} & Deploy Server';
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
