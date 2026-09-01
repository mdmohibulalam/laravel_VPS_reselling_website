<x-app-layout 
    title="VPS & Cloud Server Plans" 
    description="Compare scalable NVMe VPS hosting plans powered by AMD EPYC processors, DDR5 memory, and high-speed RAID-10 storage starting at $4.99/mo."
    keywords="vps plans, vps pricing, cheap vps hosting, linux vps server, windows server rdp, nvme cloud"
    headerVariant="solid"
>
    <x-slot:schema>
        <!-- Product & AggregateOffer Schema for Google Search Pricing Rich Snippets -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org/",
            "@@type": "Product",
            "name": "VortexCloud High-Frequency NVMe VPS Hosting",
            "image": "{{ url('/images/og-cover.png') }}",
            "description": "Enterprise cloud VPS hosting instances powered by AMD EPYC CPUs, Samsung Gen4 NVMe, and KVM virtualization.",
            "brand": {
                "@@type": "Brand",
                "name": "VortexCloud"
            },
            "offers": {
                "@@type": "AggregateOffer",
                "priceCurrency": "USD",
                "lowPrice": "4.99",
                "highPrice": "29.99",
                "offerCount": "3",
                "availability": "https://schema.org/InStock",
                "seller": {
                    "@@type": "Organization",
                    "name": "VortexCloud"
                }
            }
        }
        </script>
    </x-slot:schema>

    <div class="py-16 md:py-24 bg-white">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            <div class="reveal-init text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1 rounded-full mb-3 border border-purple-100">
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
                            $delayClass = 'delay-' . ($loop->iteration * 100);
                        @endphp
                        <div class="reveal-init {{ $delayClass }} {{ $isPopular ? 'card-interactive relative rounded-3xl p-8 bg-gradient-to-b from-[#1E003E] via-[#14002B] to-[#25004A] border-2 border-[#673DE6] shadow-2xl shadow-purple-950/60 ring-2 ring-purple-500/30 text-white md:-translate-y-3' : 'card-interactive bg-white rounded-3xl p-8 border border-slate-200 shadow-soft-md hover:shadow-soft-xl hover:border-purple-200 text-slate-900' }} flex flex-col justify-between transition-all duration-300 group">
                            @if($isPopular)
                                <div class="absolute inset-0 overflow-hidden rounded-3xl pointer-events-none">
                                    <div class="absolute -top-12 -right-12 w-44 h-44 bg-purple-500/25 rounded-full blur-2xl animate-pulse-glow"></div>
                                </div>
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#673DE6] text-white text-[11px] font-extrabold uppercase tracking-wider py-1 px-4 rounded-full shadow-lg shadow-purple-950/80 border border-purple-300/40 flex items-center gap-1.5 whitespace-nowrap z-20">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>Most Popular</span>
                                </div>
                            @endif
                            
                            <div class="relative z-10">
                                <div class="mb-6 {{ $isPopular ? 'pt-2' : '' }}">
                                    <h3 class="text-2xl font-bold {{ $isPopular ? 'text-white' : 'text-slate-900' }} mb-2">{{ $package->name }}</h3>
                                    <p class="text-sm {{ $isPopular ? 'text-purple-200' : 'text-slate-600' }} min-h-[40px] leading-relaxed font-normal">
                                        {{ $package->description ?? ($isPopular ? 'Optimized for production workloads, high-traffic APIs, and active databases.' : 'Ideal for staging environments, microservices, and development workloads.') }}
                                    </p>
                                </div>

                                <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b {{ $isPopular ? 'border-white/10' : 'border-slate-100' }}">
                                    <span class="text-4xl sm:text-5xl font-extrabold {{ $isPopular ? 'text-white' : 'text-slate-900' }} tracking-tight">${{ number_format($package->price_monthly, 2) }}</span>
                                    <span class="text-sm font-medium {{ $isPopular ? 'text-purple-300' : 'text-slate-500' }}">/mo</span>
                                </div>
                                
                                <div class="space-y-3.5 mb-8">
                                    <div class="text-xs font-bold uppercase tracking-wider {{ $isPopular ? 'text-purple-300' : 'text-slate-400' }}">Included Hardware Specs</div>
                                    <ul class="space-y-3 text-sm {{ $isPopular ? 'text-slate-100' : 'text-slate-700' }} font-medium">
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ $isPopular ? 'text-emerald-400' : 'text-[#673DE6]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['cores']) ? (str_contains(strtolower($specs['cores']), 'core') || str_contains(strtolower($specs['cores']), 'vcpu') ? $specs['cores'] : $specs['cores'] . ' vCPU Cores') : '1 vCPU Core' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ $isPopular ? 'text-emerald-400' : 'text-[#673DE6]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['memory']) ? (str_contains(strtolower($specs['memory']), 'ram') ? $specs['memory'] : $specs['memory'] . ' RAM') : '2 GB DDR5 RAM' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ $isPopular ? 'text-emerald-400' : 'text-[#673DE6]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span><strong>{{ !empty($specs['storage']) ? (str_contains(strtolower($specs['storage']), 'storage') ? $specs['storage'] : $specs['storage'] . ' NVMe Storage') : '40 GB Gen4 NVMe' }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ $isPopular ? 'text-emerald-400' : 'text-[#673DE6]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>{{ strtolower($package->category) === 'rdp' ? 'Windows OS (RDP Edition)' : 'Linux OS (Ubuntu, Debian, Alma)' }}</span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 {{ $isPopular ? 'text-emerald-400' : 'text-[#673DE6]' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Unmetered Gigabit Bandwidth</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <a href="/checkout/{{ $package->id }}" class="btn-shimmer block w-full text-center {{ $isPopular ? 'bg-[#673DE6] hover:bg-[#5428D8] text-white shadow-xl shadow-[#673DE6]/30' : 'bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 hover:border-slate-300 shadow-soft-sm' }} py-3.5 rounded-xl font-semibold transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                                Configure & Deploy
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-12 text-center max-w-xl mx-auto">
                    <p class="text-slate-600 mb-6">No packages are currently listed. Please check back shortly or deploy directly from the homepage.</p>
                    <a href="/" class="btn-shimmer bg-[#673DE6] hover:bg-[#5428D8] text-white font-semibold px-6 py-3 rounded-xl shadow-md inline-block">Return to Homepage</a>
                </div>
            @endif

            <!-- Supported OS Platform list -->
            <div class="reveal-init mt-16 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-center gap-3 text-center">
                <span class="text-sm font-medium text-slate-600">Supported operating systems with 1-click install:</span>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 transition-colors">Ubuntu</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 transition-colors">Debian</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 transition-colors">Rocky Linux</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 transition-colors">AlmaLinux</span>
                    <span class="px-3 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700 hover:border-purple-300 hover:bg-purple-50 transition-colors">Windows Server</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
