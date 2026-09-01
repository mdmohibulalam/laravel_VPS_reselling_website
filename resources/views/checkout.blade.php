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

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                                
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
                                    
                                    <!-- Ubuntu 24.04 LTS (Default) -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="os" value="Ubuntu 24.04 LTS" class="peer sr-only" {{ old('os', 'Ubuntu 24.04 LTS') === 'Ubuntu 24.04 LTS' ? 'checked' : '' }} onchange="updateOSDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-base font-bold shrink-0">🐧</div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-900 truncate">Ubuntu</div>
                                                <div class="text-[10px] text-slate-500">24.04 LTS</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Debian 12 -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="os" value="Debian 12 Bookworm" class="peer sr-only" {{ old('os') === 'Debian 12 Bookworm' ? 'checked' : '' }} onchange="updateOSDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-base font-bold shrink-0">🍥</div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-900 truncate">Debian</div>
                                                <div class="text-[10px] text-slate-500">12 Bookworm</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- AlmaLinux 9 -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="os" value="AlmaLinux 9" class="peer sr-only" {{ old('os') === 'AlmaLinux 9' ? 'checked' : '' }} onchange="updateOSDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-base font-bold shrink-0">🛡️</div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-900 truncate">AlmaLinux</div>
                                                <div class="text-[10px] text-slate-500">9 Enterprise</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Rocky Linux 9 -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="os" value="Rocky Linux 9" class="peer sr-only" {{ old('os') === 'Rocky Linux 9' ? 'checked' : '' }} onchange="updateOSDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-base font-bold shrink-0">🦅</div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-900 truncate">Rocky Linux</div>
                                                <div class="text-[10px] text-slate-500">9 Enterprise</div>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Windows Server 2022 (RDP) -->
                                    <label class="cursor-pointer col-span-2 sm:col-span-2">
                                        <input type="radio" name="os" value="Windows Server 2022" class="peer sr-only" {{ old('os') === 'Windows Server 2022' ? 'checked' : '' }} onchange="updateOSDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-100 text-[#673DE6] flex items-center justify-center text-base font-bold shrink-0">🪟</div>
                                            <div class="truncate">
                                                <div class="text-xs font-bold text-slate-900 truncate">Windows Server 2022 Standard</div>
                                                <div class="text-[10px] text-slate-500">Pre-activated with Remote Desktop (RDP)</div>
                                            </div>
                                        </div>
                                    </label>

                                </div>
                            </div>

                            <!-- Datacenter Region Location Picker with Visual Flags -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                                    Datacenter Region
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    
                                    <!-- US East (New York) -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="datacenter" value="US East (New York)" class="peer sr-only" {{ old('datacenter', 'US East (New York)') === 'US East (New York)' ? 'checked' : '' }} onchange="updateLocationDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all text-center flex flex-col items-center justify-between h-full group">
                                            <div class="w-10 h-7 rounded-md overflow-hidden shadow-sm border border-slate-200/80 mb-2 flex items-center justify-center bg-white shrink-0 group-hover:scale-105 transition-transform">
                                                <svg class="w-full h-full object-cover" viewBox="0 0 640 480">
                                                    <g fill-rule="evenodd">
                                                        <path fill="#bd3d44" d="M0 0h640v480H0z"/>
                                                        <path stroke="#fff" stroke-width="37" d="M0 55.4h640M0 129.2h640M0 203h640M0 277h640M0 350.8h640M0 424.6h640"/>
                                                        <path fill="#192f5d" d="M0 0h296v258.5H0z"/>
                                                        <g fill="#fff">
                                                            <circle cx="28" cy="20" r="7"/><circle cx="70" cy="20" r="7"/><circle cx="112" cy="20" r="7"/><circle cx="154" cy="20" r="7"/><circle cx="196" cy="20" r="7"/><circle cx="238" cy="20" r="7"/><circle cx="280" cy="20" r="7"/>
                                                            <circle cx="49" cy="45" r="7"/><circle cx="91" cy="45" r="7"/><circle cx="133" cy="45" r="7"/><circle cx="175" cy="45" r="7"/><circle cx="217" cy="45" r="7"/><circle cx="259" cy="45" r="7"/>
                                                            <circle cx="28" cy="70" r="7"/><circle cx="70" cy="70" r="7"/><circle cx="112" cy="70" r="7"/><circle cx="154" cy="70" r="7"/><circle cx="196" cy="70" r="7"/><circle cx="238" cy="70" r="7"/><circle cx="280" cy="70" r="7"/>
                                                            <circle cx="49" cy="95" r="7"/><circle cx="91" cy="95" r="7"/><circle cx="133" cy="95" r="7"/><circle cx="175" cy="95" r="7"/><circle cx="217" cy="95" r="7"/><circle cx="259" cy="95" r="7"/>
                                                            <circle cx="28" cy="120" r="7"/><circle cx="70" cy="120" r="7"/><circle cx="112" cy="120" r="7"/><circle cx="154" cy="120" r="7"/><circle cx="196" cy="120" r="7"/><circle cx="238" cy="120" r="7"/><circle cx="280" cy="120" r="7"/>
                                                            <circle cx="49" cy="145" r="7"/><circle cx="91" cy="145" r="7"/><circle cx="133" cy="145" r="7"/><circle cx="175" cy="145" r="7"/><circle cx="217" cy="145" r="7"/><circle cx="259" cy="145" r="7"/>
                                                            <circle cx="28" cy="170" r="7"/><circle cx="70" cy="170" r="7"/><circle cx="112" cy="170" r="7"/><circle cx="154" cy="170" r="7"/><circle cx="196" cy="170" r="7"/><circle cx="238" cy="170" r="7"/><circle cx="280" cy="170" r="7"/>
                                                            <circle cx="49" cy="195" r="7"/><circle cx="91" cy="195" r="7"/><circle cx="133" cy="195" r="7"/><circle cx="175" cy="195" r="7"/><circle cx="217" cy="195" r="7"/><circle cx="259" cy="195" r="7"/>
                                                            <circle cx="28" cy="220" r="7"/><circle cx="70" cy="220" r="7"/><circle cx="112" cy="220" r="7"/><circle cx="154" cy="220" r="7"/><circle cx="196" cy="220" r="7"/><circle cx="238" cy="220" r="7"/><circle cx="280" cy="220" r="7"/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="text-xs font-bold text-slate-900 leading-tight">US East</div>
                                            <div class="text-[10px] text-slate-500 mb-1.5">New York, US</div>
                                            <div class="text-[10px] text-emerald-600 bg-emerald-50 border border-emerald-200 font-mono font-bold px-2 py-0.5 rounded-full">9 ms</div>
                                        </div>
                                    </label>

                                    <!-- EU Central (Frankfurt) -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="datacenter" value="EU Central (Frankfurt)" class="peer sr-only" {{ old('datacenter') === 'EU Central (Frankfurt)' ? 'checked' : '' }} onchange="updateLocationDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all text-center flex flex-col items-center justify-between h-full group">
                                            <div class="w-10 h-7 rounded-md overflow-hidden shadow-sm border border-slate-200/80 mb-2 flex items-center justify-center bg-white shrink-0 group-hover:scale-105 transition-transform">
                                                <svg class="w-full h-full object-cover" viewBox="0 0 640 480">
                                                    <path fill="#ffce00" d="M0 320h640v160H0z"/>
                                                    <path fill="#000" d="M0 0h640v160H0z"/>
                                                    <path fill="#d00" d="M0 160h640v160H0z"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs font-bold text-slate-900 leading-tight">EU Central</div>
                                            <div class="text-[10px] text-slate-500 mb-1.5">Frankfurt, DE</div>
                                            <div class="text-[10px] text-emerald-600 bg-emerald-50 border border-emerald-200 font-mono font-bold px-2 py-0.5 rounded-full">12 ms</div>
                                        </div>
                                    </label>

                                    <!-- UK London -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="datacenter" value="UK (London)" class="peer sr-only" {{ old('datacenter') === 'UK (London)' ? 'checked' : '' }} onchange="updateLocationDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all text-center flex flex-col items-center justify-between h-full group">
                                            <div class="w-10 h-7 rounded-md overflow-hidden shadow-sm border border-slate-200/80 mb-2 flex items-center justify-center bg-white shrink-0 group-hover:scale-105 transition-transform">
                                                <svg class="w-full h-full object-cover" viewBox="0 0 640 480">
                                                    <path fill="#012169" d="M0 0h640v480H0z"/>
                                                    <path fill="#fff" d="m75 0 245 180L565 0h75v60L400 240l240 180v60h-75L320 300 75 480H0v-60l240-180L0 60V0z"/>
                                                    <path fill="#c8102e" d="m425 240 215 160v40L370 240zm140-240L320 180 75 0h490zm-565 40 215 160H60L0 40zm0 400 215-160h55L0 440z"/>
                                                    <path fill="#fff" d="M260 0h120v480H260zM0 180h640v120H0z"/>
                                                    <path fill="#c8102e" d="M280 0h80v480H280zM0 200h640v80H0z"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs font-bold text-slate-900 leading-tight">UK London</div>
                                            <div class="text-[10px] text-slate-500 mb-1.5">London, GB</div>
                                            <div class="text-[10px] text-emerald-600 bg-emerald-50 border border-emerald-200 font-mono font-bold px-2 py-0.5 rounded-full">14 ms</div>
                                        </div>
                                    </label>

                                    <!-- Singapore -->
                                    <label class="cursor-pointer">
                                        <input type="radio" name="datacenter" value="Asia (Singapore)" class="peer sr-only" {{ old('datacenter') === 'Asia (Singapore)' ? 'checked' : '' }} onchange="updateLocationDisplay(this.value)">
                                        <div class="p-3.5 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 hover:border-purple-300 transition-all text-center flex flex-col items-center justify-between h-full group">
                                            <div class="w-10 h-7 rounded-md overflow-hidden shadow-sm border border-slate-200/80 mb-2 flex items-center justify-center bg-white shrink-0 group-hover:scale-105 transition-transform">
                                                <svg class="w-full h-full object-cover" viewBox="0 0 640 480">
                                                    <path fill="#fff" d="M0 240h640v240H0z"/>
                                                    <path fill="#ed2939" d="M0 0h640v240H0z"/>
                                                    <path fill="#fff" d="M120 40a80 80 0 1 0 0 160 80 80 0 0 0 0-160z"/>
                                                    <path fill="#ed2939" d="M140 40a80 80 0 1 0 0 160 80 80 0 0 0 0-160z"/>
                                                    <g fill="#fff">
                                                        <circle cx="160" cy="80" r="10"/><circle cx="190" cy="100" r="10"/><circle cx="180" cy="135" r="10"/><circle cx="140" cy="135" r="10"/><circle cx="130" cy="100" r="10"/>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="text-xs font-bold text-slate-900 leading-tight">Singapore</div>
                                            <div class="text-[10px] text-slate-500 mb-1.5">APAC Hub, SG</div>
                                            <div class="text-[10px] text-emerald-600 bg-emerald-50 border border-emerald-200 font-mono font-bold px-2 py-0.5 rounded-full">38 ms</div>
                                        </div>
                                    </label>

                                </div>
                            </div>

                            <!-- Server Hostname & Root Password (Optional Customization) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Server Hostname <span class="text-slate-400 font-normal">(Optional)</span></label>
                                    <input type="text" name="hostname" value="{{ old('hostname') }}" placeholder="vps-01.vortexcloud.net" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400 font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Root / SSH Password <span class="text-slate-400 font-normal">(Optional)</span></label>
                                    <input type="password" name="root_password" placeholder="Auto-generated if empty" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: ACCOUNT DETAILS & EXISTING CLIENT LOGIN -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm">
                            <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">3</span>
                                    <h2 class="text-lg font-bold text-slate-900">Account Information</h2>
                                </div>
                                <span class="text-xs text-slate-500 font-medium">Customer Portal</span>
                            </div>

                            @auth
                                <!-- Authenticated Customer Banner -->
                                <div class="p-4 bg-purple-50/80 border border-purple-200 rounded-2xl flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-11 h-11 rounded-xl bg-[#673DE6] text-white font-bold flex items-center justify-center text-base shadow-md shadow-[#673DE6]/25">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs text-purple-900 font-semibold">Signed In Customer</div>
                                            <div class="text-sm font-extrabold text-slate-900">{{ auth()->user()->name }}</div>
                                            <div class="text-xs text-slate-600 font-mono">{{ auth()->user()->email }}</div>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-white border border-purple-200 text-xs font-bold text-[#673DE6] rounded-full shadow-soft-sm">
                                        Active Account
                                    </span>
                                </div>
                                <input type="hidden" name="auth_type" value="logged_in">
                            @else
                                <!-- Non-Logged In User: Tabbed Switcher (New vs Existing) -->
                                <div class="mb-6">
                                    <input type="hidden" name="auth_type" id="auth_type" value="{{ old('auth_type', 'register') }}">
                                    
                                    <div class="grid grid-cols-2 p-1 rounded-2xl bg-slate-100 border border-slate-200">
                                        <button type="button" id="tab-btn-register" onclick="switchAuthTab('register')" class="py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all {{ old('auth_type', 'register') === 'register' ? 'bg-white text-[#673DE6] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                            ✨ Create New Account
                                        </button>
                                        <button type="button" id="tab-btn-login" onclick="switchAuthTab('login')" class="py-2.5 px-4 text-xs sm:text-sm font-bold rounded-xl transition-all {{ old('auth_type') === 'login' ? 'bg-white text-[#673DE6] shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                            🔑 Existing Client Log In
                                        </button>
                                    </div>
                                </div>

                                <!-- Tab 1: New Account Form -->
                                <div id="auth-panel-register" class="{{ old('auth_type', 'register') === 'register' ? '' : 'hidden' }} space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Jane Doe" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="jane@company.com" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Account Password</label>
                                        <input type="password" name="password" minlength="8" placeholder="Create a strong password (min 8 chars)" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                </div>

                                <!-- Tab 2: Existing Client Login Form -->
                                <div id="auth-panel-login" class="{{ old('auth_type') === 'login' ? '' : 'hidden' }} space-y-4">
                                    <div class="p-3 bg-purple-50/60 border border-purple-100 rounded-xl text-xs text-purple-900 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Enter your registered email and password to link this server to your account.</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Registered Email</label>
                                        <input type="email" name="login_email" value="{{ old('login_email') }}" placeholder="your-email@domain.com" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-1.5">
                                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Account Password</label>
                                            <a href="{{ url('/customer/password/reset') }}" target="_blank" class="text-xs text-[#673DE6] hover:underline font-medium">Forgot Password?</a>
                                        </div>
                                        <input type="password" name="login_password" placeholder="Enter your account password" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-900 focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none transition-all placeholder:text-slate-400">
                                    </div>
                                </div>
                            @endauth
                        </div>

                        <!-- STEP 4: PAYMENT METHOD & COUPON ENGINE -->
                        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-soft-sm space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="w-7 h-7 rounded-full bg-[#673DE6] text-white font-bold text-xs flex items-center justify-center shadow-md shadow-[#673DE6]/30">4</span>
                                    <h2 class="text-lg font-bold text-slate-900">Payment Method</h2>
                                </div>
                                <span class="text-xs text-slate-500 font-medium">256-Bit Encrypted</span>
                            </div>

                            <!-- Payment Method Toggle -->
                            <div class="grid grid-cols-2 gap-3.5">
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_type" value="stripe" class="peer sr-only" {{ old('payment_type', 'stripe') === 'stripe' ? 'checked' : '' }} onchange="togglePaymentMethod('stripe')">
                                    <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 peer-checked:shadow-soft-sm hover:border-purple-300 transition-all text-center">
                                        <div class="text-xl mb-1">💳</div>
                                        <span class="block text-slate-900 font-bold text-sm">Credit / Debit Card</span>
                                        <span class="text-[11px] text-slate-500">Instant via Stripe</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_type" value="manual" class="peer sr-only" {{ old('payment_type') === 'manual' ? 'checked' : '' }} onchange="togglePaymentMethod('manual')">
                                    <div class="p-4 rounded-2xl border-2 border-slate-200 peer-checked:border-[#673DE6] peer-checked:bg-purple-50/50 peer-checked:shadow-soft-sm hover:border-purple-300 transition-all text-center">
                                        <div class="text-xl mb-1">🏦</div>
                                        <span class="block text-slate-900 font-bold text-sm">Crypto / Bank Wire</span>
                                        <span class="text-[11px] text-slate-500">Manual verification</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Stripe Card Element Container -->
                            <div id="stripe-container" class="{{ old('payment_type', 'stripe') === 'stripe' ? '' : 'hidden' }} space-y-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Card Information</label>
                                <div id="card-element" class="bg-white border border-slate-200 p-4 rounded-xl shadow-soft-sm"></div>
                                <div id="card-errors" class="text-rose-600 text-xs font-semibold mt-1"></div>
                            </div>

                            <!-- Manual Payment Info Box -->
                            <div id="manual-info" class="{{ old('payment_type') === 'manual' ? '' : 'hidden' }} p-4 rounded-2xl bg-amber-50/70 border border-amber-200 text-amber-900 text-xs sm:text-sm leading-relaxed">
                                <div class="font-bold mb-1 flex items-center gap-1.5">
                                    <span>ℹ️</span> How Manual Payment Works:
                                </div>
                                <p>You will receive instant transfer instructions (Crypto Wallet address / Bank wire details) in your customer portal. Once your transfer is confirmed, your server spins up automatically.</p>
                            </div>

                            <!-- Coupon Code Input -->
                            <div class="pt-4 border-t border-slate-100">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Have a Promotional Code?</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code') }}" placeholder="e.g. VORTEX20" class="flex-grow bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 uppercase font-mono tracking-wider focus:ring-2 focus:ring-[#673DE6] focus:border-[#673DE6] outline-none">
                                    <button type="button" onclick="applyCouponClient()" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-4 py-2.5 rounded-xl text-xs transition-colors shrink-0">
                                        Apply
                                    </button>
                                </div>
                                <div id="coupon-feedback" class="text-xs mt-1.5 font-medium hidden"></div>
                            </div>

                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Real-Time Sticky Order Summary (5 Cols) -->
                    <div class="lg:col-span-5 sticky top-28 space-y-5">
                        
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
                                        <span id="summary-os-display" class="font-bold text-slate-900">Ubuntu 24.04 LTS</span>
                                    </li>
                                    <li class="flex items-center justify-between">
                                        <span class="text-slate-500 flex items-center gap-2">
                                            <span class="text-purple-600">📍</span> Datacenter
                                        </span>
                                        <span id="summary-loc-display" class="font-bold text-slate-900">US East (New York)</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Live Price Calculation Breakdown -->
                            <div class="p-6 space-y-3">
                                <div class="flex items-center justify-between text-sm">
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
            } else if (selectedCycle === 'annually' || selectedCycle === '12months') {
                currentMonths = 12;
                currentDiscountPercent = 15; // 15% savings
            } else {
                currentMonths = 24;
                currentDiscountPercent = 20; // 20% savings
            }

            const rawBase = baseMonthly * currentMonths;
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

