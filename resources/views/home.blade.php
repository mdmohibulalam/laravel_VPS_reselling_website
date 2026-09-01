<x-app-layout 
    title="High-Speed Cloud VPS & NVMe Hosting"
    description="Deploy high-performance NVMe cloud VPS instances starting at $4.99/mo with AMD EPYC processors, 99.99% uptime SLA, and 24/7 expert support."
    keywords="vps hosting, cloud vps, nvme vps, amd epyc server, linux vps, windows rdp, kvm hosting, developer cloud"
    headerVariant="hero"
>
    <x-slot:schema>
        <!-- FAQPage Structured Data Schema for Google Search Rich Snippets -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "FAQPage",
            "mainEntity": [
                {
                    "@@type": "Question",
                    "name": "How long does it take to deploy a virtual private server?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Deployment is completely automated. Once your payment is confirmed, your server dashboard configuration initiates, and your operating system spins up in under 60 seconds."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "Can I upgrade my VPS resources later without losing my data?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "Yes. You can instantly scale your CPU, RAM, and storage directly from your billing dashboard. The upgrade requires a simple automated reboot with zero data loss or structural configuration changes."
                    }
                },
                {
                    "@@type": "Question",
                    "name": "What happens if I exceed my monthly bandwidth limit?",
                    "acceptedAnswer": {
                        "@@type": "Answer",
                        "text": "We do not charge hidden overage fees. If you hit your monthly traffic cap, your network speed is gently throttled to 10Mbps until the next billing cycle, or you can instantly upgrade your bandwidth allotment via your account panel."
                    }
                }
            ]
        }
        </script>
    </x-slot:schema>

    <!-- SECTION 1: EXACT HOSTINGER-STYLE CENTERED HERO SECTION & INTERACTIVE SHOWCASE DECK -->
    <section class="relative overflow-hidden pt-28 sm:pt-36 pb-20 md:pb-28 bg-[#120024] text-white">
        
        <!-- Ambient Cosmic Violet & Magenta Radial Glow (Hostinger Lighting) -->
        <div class="absolute top-1/4 -right-20 w-[600px] h-[600px] bg-gradient-to-br from-purple-600/40 to-fuchsia-600/30 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-10 left-1/4 w-[500px] h-[500px] bg-indigo-600/20 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute -bottom-20 left-1/3 w-[800px] h-[300px] bg-purple-900/30 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16 relative z-10 text-center">
            
            <!-- 1. Top Capsule Prompt / Search Pill (Hostinger Exact) -->
            <div class="inline-flex items-center justify-between w-full max-w-xl px-4 py-2 rounded-full bg-white/[0.07] border border-white/20 backdrop-blur-xl shadow-lg mb-10 hover:border-white/30 transition-colors">
                <span class="text-slate-300 text-xs sm:text-sm pl-2 font-normal truncate text-left">Have a configuration in mind? Find a VPS plan.</span>
                <a href="#pricing" class="bg-white hover:bg-slate-100 text-[#120024] text-xs font-bold px-4 py-1.5 rounded-full transition-all shrink-0 ml-2 shadow-sm">
                    Search
                </a>
            </div>

            <!-- 2. Centered Grand Headline (Hostinger Exact 2-Line Format) -->
            <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-[76px] font-extrabold text-white tracking-tight leading-[1.06] max-w-4xl mx-auto">
                Your server, online.<br>
                Made easy.
            </h1>

            <!-- 3. Centered Subheadline -->
            <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto mt-6 leading-relaxed font-normal">
                One high-performance cloud platform, powered by AMD EPYC™ from the first deploy, with the tools to build, launch, manage, and scale your applications.
            </p>

            <!-- 4. Primary CTA & Trust Guarantee -->
            <div class="mt-8 flex flex-col items-center justify-center gap-3">
                <a href="#pricing" class="bg-white hover:bg-slate-100 text-[#120024] font-bold px-9 py-3.5 rounded-xl shadow-2xl transition-all duration-200 hover:scale-105 text-sm sm:text-base">
                    Get started
                </a>
                <div class="flex items-center gap-2 text-slate-400 text-xs mt-1">
                    <svg class="w-4 h-4 text-purple-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>30-day money-back guarantee</span>
                    <span class="text-white/30">•</span>
                    <span>Instant 60-second activation</span>
                </div>
            </div>

            <!-- 5. Horizontal 4-Tile Interactive Showcase Deck (Hostinger Exact Grid) -->
            <div class="mt-14 sm:mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-left max-w-[1440px] mx-auto">
                
                <!-- Tile 1: Active Interactive Build / Prompt Card (Highlighted with Glowing Violet Border) -->
                <div class="relative rounded-3xl p-5 bg-gradient-to-b from-[#220042] to-[#16002C] border-2 border-purple-500 shadow-2xl shadow-purple-600/30 flex flex-col justify-between h-64 overflow-hidden group">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-white text-[11px] font-bold backdrop-blur-md border border-white/15">
                            <span class="text-purple-300">✦</span> Build
                        </span>
                        <span class="text-[10px] font-mono text-purple-300 font-semibold">AMD EPYC™ 9654</span>
                    </div>

                    <!-- Visual Prompt Input Bar in Card -->
                    <div class="space-y-2">
                        <div class="w-full bg-white/10 backdrop-blur-md rounded-2xl p-2.5 border border-white/20 flex items-center justify-between shadow-inner">
                            <span class="text-slate-200 text-xs font-medium pl-1">Deploy Ubuntu 24.04...</span>
                            <a href="#pricing" class="w-7 h-7 rounded-xl bg-purple-600 hover:bg-purple-500 flex items-center justify-center text-white shrink-0 shadow-md">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Dedicated root & SSH instant ready</span>
                        </div>
                    </div>
                </div>

                <!-- Tile 2: Launch / Speed & Network Tile -->
                <div class="rounded-3xl p-5 bg-white/[0.05] hover:bg-white/[0.08] border border-white/10 backdrop-blur-xl flex flex-col justify-between h-64 transition-all hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-lg">
                            🌐
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-mono font-bold">11.4 ms ping</span>
                    </div>
                    <div>
                        <div class="text-xs text-purple-300 uppercase font-bold tracking-wider mb-1">Direct Tier-1 Fiber</div>
                        <h4 class="text-lg font-bold text-white leading-tight">10 Gbps Unmetered</h4>
                        <p class="text-xs text-slate-400 mt-1.5">14 global datacenter regions with low-latency routes.</p>
                    </div>
                </div>

                <!-- Tile 3: Storage & Performance Tile -->
                <div class="rounded-3xl p-5 bg-white/[0.05] hover:bg-white/[0.08] border border-white/10 backdrop-blur-xl flex flex-col justify-between h-64 transition-all hover:-translate-y-1 group">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-lg">
                            ⚡
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-[10px] font-bold">Gen4 NVMe</span>
                    </div>
                    <div>
                        <div class="text-xs text-indigo-300 uppercase font-bold tracking-wider mb-1">Samsung® Flash Array</div>
                        <h4 class="text-lg font-bold text-white leading-tight">7,200 MB/s Read Speed</h4>
                        <p class="text-xs text-slate-400 mt-1.5">PCIe 4.0 high-resiliency RAID-10 storage nodes.</p>
                    </div>
                </div>

                <!-- Tile 4: Live Cloud Assistant / Sysadmin Support Tile -->
                <div class="rounded-3xl p-5 bg-white/[0.05] hover:bg-white/[0.08] border border-white/10 backdrop-blur-xl flex flex-col justify-between h-64 transition-all hover:-translate-y-1 group">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                            VC
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Hello 👋</div>
                            <div class="text-[10px] text-slate-400">How can I help you deploy?</div>
                        </div>
                    </div>
                    <div class="space-y-1.5 pt-2">
                        <a href="{{ url('/plans') }}" class="w-full text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs text-slate-200 flex items-center justify-between transition-colors">
                            <span>↗ 1-Click Server Migration</span>
                            <span class="text-slate-400 text-[10px]">Free</span>
                        </a>
                        <a href="{{ url('/plans') }}" class="w-full text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs text-slate-200 flex items-center justify-between transition-colors">
                            <span>↗ Windows RDP Deploy</span>
                            <span class="text-slate-400 text-[10px]">Admin</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- 6. Trustpilot Rating Strip (Hostinger Exact Center Bottom Bar) -->
            <div class="mt-14 sm:mt-16 flex items-center justify-center gap-3 text-xs sm:text-sm text-slate-300 font-medium">
                <span class="font-bold text-white">Excellent</span>
                <!-- 5 Trustpilot Green Stars -->
                <div class="flex items-center gap-1">
                    <span class="w-5 h-5 bg-[#00B67A] rounded flex items-center justify-center text-white text-xs font-bold">★</span>
                    <span class="w-5 h-5 bg-[#00B67A] rounded flex items-center justify-center text-white text-xs font-bold">★</span>
                    <span class="w-5 h-5 bg-[#00B67A] rounded flex items-center justify-center text-white text-xs font-bold">★</span>
                    <span class="w-5 h-5 bg-[#00B67A] rounded flex items-center justify-center text-white text-xs font-bold">★</span>
                    <span class="w-5 h-5 bg-[#00B67A] rounded flex items-center justify-center text-white text-xs font-bold">★</span>
                </div>
                <span><u>71,826 reviews</u> on</span>
                <span class="font-bold text-white flex items-center gap-1">
                    <span class="text-[#00B67A] font-extrabold text-base">★</span> Trustpilot
                </span>
            </div>

        </div>
    </section>


    <!-- SECTION 2: BRANDS YOU TRUST / HARDWARE PARTNERS SECTION -->
    <section id="hardware" class="py-16 md:py-24 bg-slate-50 border-b border-slate-200/80">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight mb-4">
                    Enterprise Hardware You Can Trust.
                </h2>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    We never compromise on infrastructure. Your workloads run on industry-leading, high-availability server components.
                </p>
            </div>

            <!-- Hardware Logo Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Partner Card 1: AMD EPYC -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 group-hover:text-[#673DE6] group-hover:border-purple-200 transition-colors mb-4">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="4" width="16" height="16" rx="2"></rect>
                            <rect x="9" y="9" width="6" height="6"></rect>
                            <line x1="9" y1="1" x2="9" y2="4"></line>
                            <line x1="15" y1="1" x2="15" y2="4"></line>
                            <line x1="9" y1="20" x2="9" y2="23"></line>
                            <line x1="15" y1="20" x2="15" y2="23"></line>
                            <line x1="20" y1="9" x2="23" y2="9"></line>
                            <line x1="20" y1="14" x2="23" y2="14"></line>
                            <line x1="1" y1="9" x2="4" y2="9"></line>
                            <line x1="1" y1="14" x2="4" y2="14"></line>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-1">AMD EPYC™ Processors</h3>
                    <p class="text-xs text-slate-500">Up to 3.7 GHz boost frequency with multi-threaded performance</p>
                </div>

                <!-- Partner Card 2: Intel Xeon -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 group-hover:text-[#673DE6] group-hover:border-purple-200 transition-colors mb-4">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-1">Intel® Xeon® Scalable</h3>
                    <p class="text-xs text-slate-500">Robust virtualization compute optimized for intense database throughput</p>
                </div>

                <!-- Partner Card 3: Samsung Gen4 NVMe -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 group-hover:text-[#673DE6] group-hover:border-purple-200 transition-colors mb-4">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                            <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                            <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-1">Samsung® Gen4 Enterprise NVMe</h3>
                    <p class="text-xs text-slate-500">PCIe 4.0 ultra-low latency flash storage in high-resiliency RAID-10</p>
                </div>

                <!-- Partner Card 4: KVM Architecture -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md hover:-translate-y-1 transition-all duration-200 flex flex-col items-center text-center group">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 group-hover:text-[#673DE6] group-hover:border-purple-200 transition-colors mb-4">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-1">KVM Virtualization Architecture</h3>
                    <p class="text-xs text-slate-500">100% hardware-isolated dedicated kernel with complete root access</p>
                </div>

            </div>

        </div>
    </section>


    <!-- SECTION 3: PRICING TABLE (3-Column VPS Tiers) -->
    <section id="pricing" class="py-16 md:py-24 bg-white">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1 rounded-full mb-3 border border-purple-100">
                    Transparent Cloud Pricing
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Affordable VPS Hosting Plans Built to Scale.
                </h2>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    Choose the right amount of compute, memory, and high-speed storage for your application. No hidden contracts. Cancel anytime.
                </p>
            </div>

            <!-- Dynamic 3-Column Pricing Grid -->
            @php
                $packages = \App\Models\Package::where('is_active', true)->orderBy('price_monthly')->get();
            @endphp

            @if($packages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    @foreach($packages as $package)
                        @php
                            $specs = is_string($package->specs) ? json_decode($package->specs, true) : (is_array($package->specs) ? $package->specs : []);
                            $isPopular = ($packages->count() == 1) || ($packages->count() >= 3 ? $loop->iteration == 2 : $loop->iteration == 2);
                            
                            $coresText = !empty($specs['cores']) 
                                ? (str_contains(strtolower((string)$specs['cores']), 'core') || str_contains(strtolower((string)$specs['cores']), 'vcpu') 
                                    ? $specs['cores'] 
                                    : $specs['cores'] . ' vCPU ' . ($specs['cores'] == 1 ? 'Core' : 'Cores'))
                                : '1 vCPU Core';

                            $ramText = !empty($specs['memory']) 
                                ? (str_contains(strtolower((string)$specs['memory']), 'ram') || str_contains(strtolower((string)$specs['memory']), 'ddr') 
                                    ? $specs['memory'] 
                                    : $specs['memory'] . ' DDR5 RAM')
                                : '2 GB DDR5 RAM';

                            $storageText = !empty($specs['storage']) 
                                ? (str_contains(strtolower((string)$specs['storage']), 'nvme') || str_contains(strtolower((string)$specs['storage']), 'ssd') || str_contains(strtolower((string)$specs['storage']), 'storage') 
                                    ? $specs['storage'] 
                                    : $specs['storage'] . ' Gen4 NVMe')
                                : '40 GB Gen4 NVMe';

                            $portText = !empty($specs['port']) 
                                ? $specs['port'] 
                                : (!empty($specs['bandwidth']) ? $specs['bandwidth'] : '1 Gbps Port');

                            $defaultDesc = $isPopular 
                                ? 'Optimized for production databases, high-traffic websites, and API backends.'
                                : ($loop->first ? 'Ideal for lightweight applications, staging environments, and personal projects.' : 'Built for heavy compute workloads, corporate systems, and resource-intensive deployments.');
                        @endphp

                        <!-- Dynamic Card -->
                        <div class="bg-white rounded-3xl p-8 border {{ $isPopular ? 'border-t-2 border-t-[#673DE6] border-x border-b border-slate-200 shadow-soft-xl ring-1 ring-[#673DE6]/20 md:-translate-y-2 relative' : 'border-slate-200 shadow-soft-md hover:shadow-soft-lg' }} flex flex-col justify-between transition-all duration-200">
                            
                            @if($isPopular)
                                <!-- Absolute Pill Badge -->
                                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#673DE6] text-white text-[11px] font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-md shadow-[#673DE6]/30">
                                    Most Popular
                                </div>
                            @endif

                            <div>
                                <div class="mb-6 {{ $isPopular ? 'pt-1' : '' }}">
                                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $package->name }}</h3>
                                    <p class="text-sm text-slate-600 min-h-[40px] leading-relaxed">
                                        {{ $package->description ?: $defaultDesc }}
                                    </p>
                                </div>

                                <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b border-slate-100">
                                    <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">${{ number_format($package->price_monthly, 2) }}</span>
                                    <span class="text-sm font-medium text-slate-500">/mo</span>
                                </div>

                                <!-- Technical Specs Micro-List -->
                                <div class="space-y-3.5 mb-8">
                                    <div class="text-xs font-bold uppercase tracking-wider {{ $isPopular ? 'text-[#673DE6]' : 'text-slate-400' }}">Included Specifications</div>
                                    <ul class="space-y-3 text-sm {{ $isPopular ? 'text-slate-800' : 'text-slate-700' }} font-medium">
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span><strong>{{ $coresText }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span><strong>{{ $ramText }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span><strong>{{ $storageText }}</strong></span>
                                        </li>
                                        <li class="flex items-center gap-3">
                                            <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span><strong>{{ $portText }}</strong></span>
                                        </li>
                                        @if(strtolower($package->category) === 'rdp')
                                            <li class="flex items-center gap-3 text-purple-900 font-semibold">
                                                <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>Windows Server OS (RDP)</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <a href="{{ route('checkout.show', $package->id) }}" class="w-full text-center {{ $isPopular ? 'bg-[#673DE6] hover:bg-[#5428D8] text-white shadow-lg shadow-[#673DE6]/25 hover:-translate-y-0.5' : 'bg-white hover:bg-slate-50 text-slate-800 hover:text-slate-900 border border-slate-200 hover:border-slate-300 shadow-soft-sm hover:-translate-y-0.5' }} font-semibold py-3.5 rounded-xl transition-all duration-200">
                                Deploy {{ $package->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback 3-Tier Grid if database is empty -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- Fallback Card 1: Starter VPS -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-soft-md hover:shadow-soft-lg transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-slate-900 mb-2">Starter VPS</h3>
                                <p class="text-sm text-slate-600 min-h-[40px] leading-relaxed">
                                    Ideal for lightweight applications, staging environments, and personal projects.
                                </p>
                            </div>

                            <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b border-slate-100">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">$4.99</span>
                                <span class="text-sm font-medium text-slate-500">/mo</span>
                            </div>

                            <div class="space-y-3.5 mb-8">
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Included Specifications</div>
                                <ul class="space-y-3 text-sm text-slate-700 font-medium">
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>1 vCPU</strong> Core</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>2 GB</strong> DDR5 RAM</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>40 GB</strong> Gen4 NVMe</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>1 Gbps</strong> Port</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a href="{{ url('/plans') }}" class="w-full text-center bg-white hover:bg-slate-50 text-slate-800 hover:text-slate-900 border border-slate-200 hover:border-slate-300 font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-soft-sm">
                            Deploy Starter
                        </a>
                    </div>

                    <!-- Fallback Card 2: Professional VPS -->
                    <div class="bg-white rounded-3xl p-8 border-t-2 border-t-[#673DE6] border-x border-b border-slate-200 shadow-soft-xl ring-1 ring-[#673DE6]/20 relative flex flex-col justify-between md:-translate-y-2">
                        <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[#673DE6] text-white text-[11px] font-bold uppercase tracking-wider py-1 px-4 rounded-full shadow-md shadow-[#673DE6]/30">
                            Most Popular
                        </div>

                        <div>
                            <div class="mb-6 pt-1">
                                <h3 class="text-2xl font-bold text-slate-900 mb-2">Professional VPS</h3>
                                <p class="text-sm text-slate-600 min-h-[40px] leading-relaxed">
                                    Optimized for production databases, high-traffic websites, and API backends.
                                </p>
                            </div>

                            <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b border-slate-100">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">$14.99</span>
                                <span class="text-sm font-medium text-slate-500">/mo</span>
                            </div>

                            <div class="space-y-3.5 mb-8">
                                <div class="text-xs font-bold uppercase tracking-wider text-[#673DE6]">Included Specifications</div>
                                <ul class="space-y-3 text-sm text-slate-800 font-medium">
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>2 vCPU</strong> Cores</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>4 GB</strong> DDR5 RAM</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>80 GB</strong> Gen4 NVMe</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>1 Gbps</strong> Port</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a href="{{ url('/plans') }}" class="w-full text-center bg-[#673DE6] hover:bg-[#5428D8] text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-[#673DE6]/25 hover:-translate-y-0.5 transition-all duration-200">
                            Deploy Professional
                        </a>
                    </div>

                    <!-- Fallback Card 3: Enterprise VPS -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-soft-md hover:shadow-soft-lg transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-slate-900 mb-2">Enterprise VPS</h3>
                                <p class="text-sm text-slate-600 min-h-[40px] leading-relaxed">
                                    Built for heavy compute workloads, corporate systems, and resource-intensive deployments.
                                </p>
                            </div>

                            <div class="flex items-baseline gap-1.5 pb-6 mb-6 border-b border-slate-100">
                                <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">$29.99</span>
                                <span class="text-sm font-medium text-slate-500">/mo</span>
                            </div>

                            <div class="space-y-3.5 mb-8">
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Included Specifications</div>
                                <ul class="space-y-3 text-sm text-slate-700 font-medium">
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>4 vCPU</strong> Cores</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>8 GB</strong> DDR5 RAM</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>160 GB</strong> Gen4 NVMe</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-[#673DE6] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span><strong>2 Gbps</strong> Port</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <a href="{{ url('/plans') }}" class="w-full text-center bg-white hover:bg-slate-50 text-slate-800 hover:text-slate-900 border border-slate-200 hover:border-slate-300 font-semibold py-3.5 rounded-xl transition-all duration-200 shadow-soft-sm">
                            Deploy Enterprise
                        </a>
                    </div>

                </div>
            @endif

            <!-- Underneath the Table: Supported OS Platforms -->
            <div class="mt-14 pt-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-center gap-3 text-center">
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
    </section>


    <!-- SECTION 4: WHY CHOOSE US SECTION -->
    <section id="features" class="py-16 md:py-24 bg-slate-50 border-y border-slate-200/80">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1 rounded-full mb-3 border border-purple-100">
                    High-Reliability Architecture
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Engineered for Reliable Cloud Infrastructure.
                </h2>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    Built from the ground up to support modern devops workflows, production backends, and low-latency client applications.
                </p>
            </div>

            <!-- 3-Column Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Pillar 1: 99.99% Uptime Guarantee (with green ping dot) -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 tracking-tight">99.99% Uptime Guarantee</h3>
                    </div>
                    
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Our redundant network architecture ensures your applications stay online 24/7/365 with zero unexpected interruptions.
                    </p>
                </div>

                <!-- Pillar 2: Enterprise DDoS Protection -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 text-[#673DE6] flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3">Enterprise DDoS Protection</h3>
                    
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Advanced Layer 4 and Layer 7 traffic scrubbing filters out malicious attacks instantly before they ever reach your virtual server.
                    </p>
                </div>

                <!-- Pillar 3: 24/7 Expert Support -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 text-[#673DE6] flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            <circle cx="9" cy="10" r="1"/>
                            <circle cx="12" cy="10" r="1"/>
                            <circle cx="15" cy="10" r="1"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3">24/7 Expert Support</h3>
                    
                    <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                        Skip the front-line general support. Get direct assistance from experienced system administrators who speak your language.
                    </p>
                </div>

            </div>

        </div>
    </section>


    <!-- SECTION 5: CUSTOMER REVIEWS / TESTIMONIALS SECTION -->
    <section id="reviews" class="py-16 md:py-24 bg-white">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1 rounded-full mb-3 border border-purple-100">
                    Developer Approved
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Trusted by Developers and System Administrators.
                </h2>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    See why engineering teams and digital agencies rely on VortexCloud for mission-critical hosting.
                </p>
            </div>

            <!-- 3-Column Reviews Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Review 1: Alex M. -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <!-- 5-Star Rating Graphic -->
                        <div class="flex items-center space-x-1 text-amber-400 mb-6">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Copy -->
                        <blockquote class="text-slate-700 italic text-base leading-relaxed mb-6 font-normal">
                            "The NVMe read/write speeds on these servers are absolutely incredible. Migrated my database here and cut loading times in half."
                        </blockquote>
                    </div>

                    <!-- User Label -->
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-[#673DE6] font-bold flex items-center justify-center text-sm">
                            AM
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Alex M.</div>
                            <div class="text-xs text-slate-500">Full-Stack Developer</div>
                        </div>
                    </div>
                </div>

                <!-- Review 2: Sarah K. -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <!-- 5-Star Rating Graphic -->
                        <div class="flex items-center space-x-1 text-amber-400 mb-6">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Copy -->
                        <blockquote class="text-slate-700 italic text-base leading-relaxed mb-6 font-normal">
                            "I needed a reliable VPS reseller for my client websites. The uptime has been absolutely flawless, and deployment takes under a minute."
                        </blockquote>
                    </div>

                    <!-- User Label -->
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-[#673DE6] font-bold flex items-center justify-center text-sm">
                            SK
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">Sarah K.</div>
                            <div class="text-xs text-slate-500">Agency Founder</div>
                        </div>
                    </div>
                </div>

                <!-- Review 3: David L. -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-soft-sm hover:shadow-soft-md transition-all duration-200 flex flex-col justify-between">
                    <div>
                        <!-- 5-Star Rating Graphic -->
                        <div class="flex items-center space-x-1 text-amber-400 mb-6">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <!-- Quote Copy -->
                        <blockquote class="text-slate-700 italic text-base leading-relaxed mb-6 font-normal">
                            "Excellent network latency and ping speeds across all global locations. Best price-to-performance ratio in the hosting market."
                        </blockquote>
                    </div>

                    <!-- User Label -->
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-[#673DE6] font-bold flex items-center justify-center text-sm">
                            DL
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 text-sm">David L.</div>
                            <div class="text-xs text-slate-500">DevOps Engineer</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- SECTION 6: FAQ SECTION -->
    <section id="faq" class="py-16 md:py-24 bg-slate-50 border-y border-slate-200/80">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center mb-14">
                <div class="inline-block text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1 rounded-full mb-3 border border-purple-100">
                    Got Questions?
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Frequently Asked Questions About Our VPS Hosting.
                </h2>
                <p class="text-base sm:text-lg text-slate-600">
                    Everything you need to know about our cloud provisioning, scaling, and network limits.
                </p>
            </div>

            <!-- FAQ Stacked Vertical Accordions -->
            <div class="space-y-4">
                
                <!-- Q1 -->
                <details class="group bg-white rounded-2xl border border-slate-200 shadow-soft-sm p-6 [&_summary::-webkit-details-marker]:hidden open:border-purple-200 transition-all duration-200" open>
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-lg gap-4">
                        <span>How long does it take to deploy a virtual private server?</span>
                        <span class="w-8 h-8 rounded-xl bg-slate-50 group-open:bg-purple-50 text-slate-500 group-open:text-[#673DE6] flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-sm sm:text-base">
                        Deployment is completely automated. Once your payment is confirmed, your server dashboard configuration initiates, and your operating system spins up in under 60 seconds.
                    </div>
                </details>

                <!-- Q2 -->
                <details class="group bg-white rounded-2xl border border-slate-200 shadow-soft-sm p-6 [&_summary::-webkit-details-marker]:hidden open:border-purple-200 transition-all duration-200">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-lg gap-4">
                        <span>Can I upgrade my VPS resources later without losing my data?</span>
                        <span class="w-8 h-8 rounded-xl bg-slate-50 group-open:bg-purple-50 text-slate-500 group-open:text-[#673DE6] flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-sm sm:text-base">
                        Yes. You can instantly scale your CPU, RAM, and storage directly from your billing dashboard. The upgrade requires a simple automated reboot with zero data loss or structural configuration changes.
                    </div>
                </details>

                <!-- Q3 -->
                <details class="group bg-white rounded-2xl border border-slate-200 shadow-soft-sm p-6 [&_summary::-webkit-details-marker]:hidden open:border-purple-200 transition-all duration-200">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-lg gap-4">
                        <span>What happens if I exceed my monthly bandwidth limit?</span>
                        <span class="w-8 h-8 rounded-xl bg-slate-50 group-open:bg-purple-50 text-slate-500 group-open:text-[#673DE6] flex items-center justify-center shrink-0 transition-transform duration-200 group-open:rotate-180">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <div class="mt-4 pt-4 border-t border-slate-100 text-slate-600 leading-relaxed text-sm sm:text-base">
                        We do not charge hidden overage fees. If you hit your monthly traffic cap, your network speed is gently throttled to 10Mbps until the next billing cycle, or you can instantly upgrade your bandwidth allotment via your account panel.
                    </div>
                </details>

            </div>

        </div>
    </section>


    <!-- SECTION 7: FINAL CALL-TO-ACTION (CTA) SECTION (HERO-MATCHED COSMIC VIOLET) -->
    <section class="py-16 md:py-24 bg-white">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            
            <div class="relative rounded-3xl bg-gradient-to-b from-[#1A0038] via-[#120024] to-[#220044] p-10 md:p-16 text-center border border-white/15 shadow-2xl shadow-purple-950/70 overflow-hidden">
                <!-- Ambient Cosmic Violet & Magenta Radial Glow (Hero-Matched Lighting) -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-purple-600/30 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-fuchsia-600/25 rounded-full blur-3xl pointer-events-none animate-pulse" style="animation-delay: 1.5s;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[350px] bg-indigo-600/15 rounded-full blur-[100px] pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                    
                    <!-- Top Announcement Pill -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-purple-200 shadow-sm">
                        <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>60-Second Instant Cloud Provisioning</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Ready to Deploy Your Next Application?
                    </h2>
                    
                    <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto font-normal">
                        Join thousands of developers and businesses running their mission-critical workloads on our high-speed virtual cloud infrastructure.
                    </p>

                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#pricing" class="w-full sm:w-auto bg-white hover:bg-slate-100 text-[#120024] text-base sm:text-lg font-extrabold px-9 py-4 rounded-xl shadow-2xl hover:scale-105 transition-all duration-200 inline-flex items-center justify-center gap-3">
                            <span>Get Started Instantly</span>
                            <svg class="w-5 h-5 text-[#673DE6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                    <div class="pt-4 flex items-center justify-center gap-6 text-xs sm:text-sm text-slate-300 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Instant automated setup
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Cancel anytime
                        </span>
                        <span class="hidden sm:flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            24/7 Expert support
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </section>

</x-app-layout>
