<x-app-layout>
    <div class="py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-display font-bold text-white mb-8 text-center">Checkout</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-2xl font-bold text-white mb-6">Order Summary</h2>
                <div class="glass-dark p-6 rounded-2xl border border-white/5">
                    <h3 class="text-xl font-bold text-white mb-2">{{ $package->name }}</h3>
                    @php $specs = is_string($package->specs) ? json_decode($package->specs, true) : $package->specs; @endphp
                    <ul class="text-slate-400 space-y-2 mb-6">
                        <li>{{ $specs['cores'] ?? 'N/A' }} vCPU Cores</li>
                        <li>{{ $specs['memory'] ?? 'N/A' }} RAM</li>
                        <li>{{ $specs['storage'] ?? 'N/A' }} Storage</li>
                        <li>{{ strtolower($package->category) === 'rdp' ? 'Windows OS (RDP)' : 'Linux OS' }}</li>
                    </ul>
                    <div class="border-t border-white/10 pt-4 flex justify-between items-center text-lg font-bold text-white">
                        <span>Total Due Today:</span>
                        <span>${{ number_format($package->price_monthly, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-2xl font-bold text-white mb-6">Payment & Details</h2>
                
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl mb-6">
                        <ul class="list-disc pl-5">
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
                                <label class="block text-sm font-medium text-slate-300 mb-1">Full Name</label>
                                <input type="text" name="name" required class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                                <input type="email" name="email" required class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                                <input type="password" name="password" required minlength="8" class="w-full bg-dark-900 border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    @endguest
                    
                    @auth
                        <div class="mb-6 p-4 bg-primary-500/10 border border-primary-500/30 rounded-xl">
                            <p class="text-primary-300">Logged in as <strong>{{ auth()->user()->email }}</strong>.</p>
                            <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="is_logged_in" value="1">
                        </div>
                    @endauth
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-300 mb-3">Select Payment Method</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_type" value="stripe" class="peer sr-only" {{ old('payment_type', 'stripe') === 'stripe' ? 'checked' : '' }} onchange="togglePaymentMethod(this.value)">
                                <div class="bg-dark-900 border border-white/10 rounded-xl p-4 text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                                    <span class="block text-white font-medium mb-1">Credit/Debit Card</span>
                                    <span class="text-xs text-slate-400">Via Stripe</span>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_type" value="manual" class="peer sr-only" {{ old('payment_type') === 'manual' ? 'checked' : '' }} onchange="togglePaymentMethod(this.value)">
                                <div class="bg-dark-900 border border-white/10 rounded-xl p-4 text-center peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                                    <span class="block text-white font-medium mb-1">Manual Payment</span>
                                    <span class="text-xs text-slate-400">Crypto / Bank Transfer</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="stripe-container" class="mb-6 {{ old('payment_type', 'stripe') === 'stripe' ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Card Details</label>
                        <div id="card-element" class="bg-dark-900 border border-white/10 p-4 rounded-lg"></div>
                        <div id="card-errors" class="text-red-500 text-sm mt-2"></div>
                    </div>
                    
                    <div id="manual-info" class="mb-6 {{ old('payment_type', 'stripe') === 'manual' ? '' : 'hidden' }} bg-dark-900 border border-white/10 p-4 rounded-lg">
                        <p class="text-sm text-slate-300">
                            You will receive payment instructions (Wallet addresses / Bank details) via email and in your Customer Portal once your order is placed.
                        </p>
                    </div>
                    
                    <input type="hidden" name="payment_method_id" id="payment_method_id">
                    
                    <button type="submit" id="submit-button" class="w-full bg-primary-600 hover:bg-primary-500 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center">
                        <span id="button-text">{{ old('payment_type', 'stripe') === 'stripe' ? 'Pay $' . number_format($package->price_monthly, 2) : 'Place Order (Pay Later)' }}</span>
                        <svg id="spinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function togglePaymentMethod(method) {
            if (method === 'stripe') {
                document.getElementById('stripe-container').classList.remove('hidden');
                document.getElementById('manual-info').classList.add('hidden');
                document.getElementById('button-text').textContent = 'Pay ${{ number_format($package->price_monthly, 2) }}';
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
                        color: '#ffffff',
                        fontFamily: '"Inter", sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#94a3b8'
                        }
                    },
                    invalid: {
                        color: '#ef4444',
                        iconColor: '#ef4444'
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
                    // Just submit the form for manual payment
                    return true; 
                }
                
                // Stripe Flow
                event.preventDefault();
                
                if (!stripe) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = "Stripe is not configured. Please add the Stripe keys to the .env file.";
                    return;
                }
                
                document.getElementById('submit-button').disabled = true;
                document.getElementById('button-text').textContent = 'Processing...';
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
                        document.getElementById('button-text').textContent = 'Pay ${{ number_format($package->price_monthly, 2) }}';
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
