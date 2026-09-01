<x-app-layout>
    <div class="py-16 md:py-24 bg-white">
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-3.5 py-1 rounded-full mb-3 border border-indigo-100">
                    High-Performance Packages
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">VPS & Cloud Server Plans</h1>
                <p class="text-lg text-slate-600">Enterprise cloud infrastructure tailored for developers, scalable businesses, and production workloads.</p>
            </div>

            @php
                $packages = \App\Models\Package::where('is_active', true)->orderBy('price_monthly')->get();
            @endphp

            @if($packages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    @foreach($packages as $package)
                        @php 
                            $specs = is_string($package->specs) ? json_decode($package->specs, true) : $package->specs; 
                            $isPopular = $loop->iteration == 2 || $loop->count == 1;
                        @endphp
                        <div class="bg-white rounded-3xl p-8 border {{ $isPopular ? 'border-t-2 border-t-indigo-600 border-x border-b border-slate-200 shadow-soft-xl ring-1 ring-indigo-500/20 md:-translate-y-2' : 'border-slate-200 shadow-soft-md hover:shadow-soft-lg' }} flex flex-col justify-between relative transition-all duration-200">
                            @if($isPopular)
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[11px] font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-md shadow-indigo-500/30">
                                    Most Popular
                                </div>
                            @endif
                            
                            <div>
                                <div class="mb-6 {{ $isPopular ? 'pt-1' : '' }}">
                                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $package->name }}</h3>
                                    <p class="text-sm text-slate-600 min-h-[40px] leading-relaxed">
                                        {{ $package->description ?? ($isPopular ? 'Optimized for production workloads, high-traffic APIs, and active databases.' : 'Ideal for staging environments, microservices, and development workloads.') }}
                                    </p>
                                </div>

                                <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b border-slate-100">
                                    <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">${{ number_format($package->price_monthly, 2) }}</span>
                                    <span class="text-sm font-medium text-slate-500">/mo</span>
                                </div>
                                
                                <div class="space-y-3.5 mb-8">
                                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Included Hardware Specs</div>
                                    <ul class="space-y-3 text-sm text-slate-700 font-medium">
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['cores']) ? (str_contains(strtolower($specs['cores']), 'core') || str_contains(strtolower($specs['cores']), 'vcpu') ? $specs['cores'] : $specs['cores'] . ' vCPU Cores') : '1 vCPU Core' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['memory']) ? (str_contains(strtolower($specs['memory']), 'ram') ? $specs['memory'] : $specs['memory'] . ' RAM') : '2 GB DDR5 RAM' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['storage']) ? (str_contains(strtolower($specs['storage']), 'storage') ? $specs['storage'] : $specs['storage'] . ' NVMe Storage') : '40 GB Gen4 NVMe' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>{{ strtolower($package->category) === 'rdp' ? 'Windows OS (RDP Edition)' : 'Linux OS (Ubuntu, Debian, Alma)' }}</span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Unmetered Gigabit Bandwidth</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <a href="/checkout/{{ $package->id }}" class="block w-full text-center {{ $isPopular ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-500/25' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 hover:border-slate-300 shadow-soft-sm' }} py-3.5 rounded-xl font-semibold transition-all duration-200 hover:-translate-y-0.5">
                                Configure & Deploy
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-12 text-center max-w-xl mx-auto">
                    <p class="text-slate-600 mb-6">No packages are currently listed. Please check back shortly or deploy directly from the homepage.</p>
                    <a href="/" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md inline-block">Return to Homepage</a>
                </div>
            @endif

            <!-- Supported OS Platform list -->
            <div class="mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-center gap-3 text-center">
                <span class="text-sm font-medium text-slate-600">Supported operating systems with 1-click install:</span>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">Ubuntu</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">Debian</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">Rocky Linux</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">AlmaLinux</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">Windows Server</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
