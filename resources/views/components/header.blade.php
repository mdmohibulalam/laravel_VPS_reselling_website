@props([
    'variant' => 'hero', // 'hero', 'solid', or 'minimal'
])

@php
    $isHero = $variant === 'hero';
    $isMinimal = $variant === 'minimal';
    $isSolid = $variant === 'solid' || $variant === 'inner';
@endphp

<!-- Hostinger-Style Floating Glass Navigation Bar -->
<header 
    id="main-nav-header" 
    data-variant="{{ $variant }}"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-in-out {{ $isHero ? 'bg-transparent border-b border-transparent shadow-none' : 'backdrop-blur-2xl bg-[#0F0024]/90 border-b border-white/[0.12] shadow-2xl shadow-purple-950/40' }}"
>
    <!-- Subtle Top Glass Highlight Line -->
    <div 
        id="header-glass-highlight" 
        class="h-[1px] w-full bg-gradient-to-r from-transparent via-purple-500/40 to-transparent {{ $isHero ? 'opacity-0' : 'opacity-100' }} transition-opacity duration-300"
    ></div>

    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
        <!-- Standard Format Taller Height (80px - 88px) -->
        <div class="flex items-center justify-between h-20 sm:h-22">
            
            <!-- Left: Brand Logo & Navigation -->
            <div class="flex items-center gap-8 lg:gap-12">
                <!-- Brand Logo -->
                <a href="/" class="flex items-center gap-3 group focus:outline-none shrink-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-purple-600/30 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                            <line x1="6" y1="6" x2="6.01" y2="6"></line>
                            <line x1="6" y1="18" x2="6.01" y2="18"></line>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl tracking-wider text-white uppercase group-hover:text-purple-300 transition-colors">VORTEXCLOUD</span>
                </a>

                @if(!$isMinimal)
                    <!-- Left-Aligned Navigation Links -->
                    <nav class="hidden lg:flex items-center space-x-1.5 text-sm font-medium text-slate-300">
                        <!-- 1. Pricing Direct Link -->
                        <a href="{{ url('/plans') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors {{ request()->is('plans*') ? 'text-white bg-white/[0.10]' : '' }}">
                            Pricing
                        </a>

                        <!-- 2. Products ▾ (Multi-Column Mega Dropdown) -->
                        <div class="relative group">
                            <button type="button" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors inline-flex items-center gap-1.5 focus:outline-none">
                                <span>Products</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute left-0 top-full pt-3 w-[780px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="bg-[#16042E]/98 border border-white/15 rounded-3xl p-6 shadow-2xl shadow-black/90 grid grid-cols-12 gap-6 backdrop-blur-3xl ring-1 ring-white/10">
                                    
                                    <!-- Column 1: Compute & Virtual Servers (5 cols) -->
                                    <div class="col-span-4 space-y-1">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-purple-300 px-3 pb-1">VPS & Compute</div>
                                        
                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">⚡</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-purple-300 transition-colors flex items-center gap-1.5">
                                                    <span>Cloud KVM VPS</span>
                                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">Popular</span>
                                                </div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">AMD EPYC™ with Gen4 NVMe</div>
                                            </div>
                                        </a>

                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">🪟</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-indigo-300 transition-colors">Windows RDP VPS</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">Pre-activated Windows Server</div>
                                            </div>
                                        </a>

                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">💾</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-emerald-300 transition-colors">Storage NVMe VPS</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">RAID-10 arrays for backups</div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Column 2: Operating Systems & Panels (4 cols) -->
                                    <div class="col-span-4 space-y-1 border-l border-white/10 pl-4">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-300 px-3 pb-1">OS & Platforms</div>
                                        
                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">🐧</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-blue-300">Linux Distributions</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">Ubuntu, Debian, Rocky, Alma</div>
                                            </div>
                                        </a>

                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-cyan-500/20 text-cyan-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">🐳</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-cyan-300">Docker & Stacks</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">Container-ready droplets</div>
                                            </div>
                                        </a>

                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-all group/item">
                                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform">🌐</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-amber-300">Web Hosting Panels</div>
                                                <div class="text-[11px] text-slate-400 mt-0.5">cPanel, Plesk, CyberPanel</div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Column 3: Featured Promo Showcase Card (4 cols) -->
                                    <div class="col-span-4 bg-gradient-to-br from-purple-900/40 via-indigo-900/30 to-[#2A0054]/60 border border-purple-500/30 rounded-2xl p-4 flex flex-col justify-between text-left relative overflow-hidden shadow-inner">
                                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>
                                        <div>
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold uppercase tracking-wider mb-2 border border-emerald-400/30">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                                60s Fast Deploy
                                            </div>
                                            <h4 class="font-extrabold text-white text-sm leading-tight">High-Frequency NVMe VPS</h4>
                                            <p class="text-[11px] text-slate-300 mt-1 leading-relaxed">
                                                Dedicated AMD EPYC™ cores with unmetered 10 Gbps gigabit network.
                                            </p>
                                        </div>
                                        <div class="pt-3 border-t border-white/10 mt-2">
                                            <div class="text-[11px] text-purple-200">Starting from <strong class="text-base text-white font-extrabold">$4.99</strong>/mo</div>
                                            <a href="{{ url('/plans') }}" class="mt-2 w-full text-center bg-white hover:bg-slate-100 text-[#120024] font-extrabold text-xs py-2 rounded-xl transition-all shadow-md inline-block">
                                                View All Plans →
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- 3. Solutions ▾ (2-Column Dropdown) -->
                        <div class="relative group">
                            <button type="button" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors inline-flex items-center gap-1.5 focus:outline-none">
                                <span>Solutions</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute left-0 top-full pt-3 w-[560px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="bg-[#16042E]/98 border border-white/15 rounded-3xl p-5 shadow-2xl shadow-black/90 grid grid-cols-2 gap-4 backdrop-blur-3xl ring-1 ring-white/10">
                                    <div class="space-y-1">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-purple-300 px-3 pb-1">Security & Network</div>
                                        <a href="{{ url('/#features') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🛡️</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-purple-300">2.4 Tbps DDoS Shield</div>
                                                <div class="text-[11px] text-slate-400">Always-on L3-L7 traffic scrubbing</div>
                                            </div>
                                        </a>
                                        <a href="{{ url('/#hardware') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🌐</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-blue-300">Tier-1 Direct Fiber</div>
                                                <div class="text-[11px] text-slate-400">14 global low-latency regions</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="space-y-1 border-l border-white/10 pl-4">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-300 px-3 pb-1">Workloads & Reselling</div>
                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🚀</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-emerald-300">High-Traffic Web Apps</div>
                                                <div class="text-[11px] text-slate-400">Ultra-fast API and database compute</div>
                                            </div>
                                        </a>
                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🏢</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-amber-300">Reseller Infrastructure</div>
                                                <div class="text-[11px] text-slate-400">Custom dedicated server nodes</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Developers ▾ (2-Column Dropdown) -->
                        <div class="relative group">
                            <button type="button" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors inline-flex items-center gap-1.5 focus:outline-none">
                                <span>Developers</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute left-0 top-full pt-3 w-[560px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="bg-[#16042E]/98 border border-white/15 rounded-3xl p-5 shadow-2xl shadow-black/90 grid grid-cols-2 gap-4 backdrop-blur-3xl ring-1 ring-white/10">
                                    <div class="space-y-1">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-purple-300 px-3 pb-1">Hardware Infrastructure</div>
                                        <a href="{{ url('/#hardware') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">⚙️</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-purple-300">AMD EPYC™ 9654</div>
                                                <div class="text-[11px] text-slate-400">3.7 GHz boost dedicated cores</div>
                                            </div>
                                        </a>
                                        <a href="{{ url('/#hardware') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">⚡</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-indigo-300">Samsung® Gen4 NVMe</div>
                                                <div class="text-[11px] text-slate-400">7,200 MB/s PCIe 4.0 RAID-10</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="space-y-1 border-l border-white/10 pl-4">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-300 px-3 pb-1">Control & CLI</div>
                                        <a href="{{ url('/plans') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">💻</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-emerald-300">Root & SSH Access</div>
                                                <div class="text-[11px] text-slate-400">Complete sysadmin control</div>
                                            </div>
                                        </a>
                                        <a href="{{ url('/#hardware') }}" class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🔒</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-amber-300">KVM Isolation</div>
                                                <div class="text-[11px] text-slate-400">100% isolated dedicated kernel</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Resources ▾ (2-Column Dropdown) -->
                        <div class="relative group">
                            <button type="button" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors inline-flex items-center gap-1.5 focus:outline-none">
                                <span>Resources</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute left-0 top-full pt-3 w-[520px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="bg-[#16042E]/98 border border-white/15 rounded-3xl p-5 shadow-2xl shadow-black/90 grid grid-cols-2 gap-4 backdrop-blur-3xl ring-1 ring-white/10">
                                    <div class="space-y-1">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-purple-300 px-3 pb-1">Support & Help</div>
                                        <a href="{{ url('/customer/support-tickets') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">🎫</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-indigo-300">Support Ticket Desk</div>
                                                <div class="text-[11px] text-slate-400">24/7 dedicated sysadmins</div>
                                            </div>
                                        </a>
                                        <a href="{{ url('/#faq') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">📖</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-emerald-300">Technical FAQ</div>
                                                <div class="text-[11px] text-slate-400">Guides & documentation</div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="space-y-1 border-l border-white/10 pl-4">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-300 px-3 pb-1">Trust & Proof</div>
                                        <a href="{{ url('/#reviews') }}" class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-white/10 transition-colors group/item">
                                            <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-300 flex items-center justify-center text-sm font-bold shrink-0 mt-0.5">⭐</div>
                                            <div>
                                                <div class="text-white text-xs font-bold group-hover/item:text-amber-300">Customer Reviews</div>
                                                <div class="text-[11px] text-slate-400">4.9/5 verified ratings</div>
                                            </div>
                                        </a>
                                        <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 mt-1">
                                            <div class="flex items-center justify-between text-[11px]">
                                                <span class="text-slate-300 flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                    <span>Uptime SLA</span>
                                                </span>
                                                <span class="text-emerald-300 font-bold font-mono">99.99%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </nav>
                @endif
            </div>

            <!-- Right: Action Center -->
            <div class="flex items-center space-x-3.5">
                
                @if($isMinimal)
                    <!-- Minimal Checkout Security Indicator -->
                    <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/30 text-emerald-300 text-xs font-semibold">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>256-Bit SSL Encrypted</span>
                    </div>
                    <a href="{{ url('/plans') }}" class="text-xs font-semibold text-slate-300 hover:text-white transition-colors">
                        ← Back to Plans
                    </a>
                @else
                    <!-- Action Pill: Deploy VPS -->
                    <a href="{{ url('/plans') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/[0.08] hover:bg-white/[0.16] border border-white/20 text-xs font-bold text-white transition-all hover:scale-105 shadow-md">
                        <span class="text-sm">✨</span>
                        <span>Deploy VPS</span>
                    </a>

                    <!-- Language & Currency Pill -->
                    <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl hover:bg-white/[0.08] text-xs font-semibold text-slate-300 cursor-pointer transition-colors">
                        <span>🇺🇸</span>
                        <span>EN</span>
                    </div>

                    <!-- User Account Icon / Login -->
                    @auth
                        <a href="{{ url('/customer') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 transition-all">
                            <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="hidden sm:inline">Client Area</span>
                        </a>
                    @else
                        <a href="{{ url('/customer/login') }}" class="p-2.5 rounded-xl hover:bg-white/10 text-slate-300 hover:text-white transition-colors focus:outline-none" title="Log in to customer portal">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                        <a href="{{ url('/customer/register') }}" class="hidden sm:inline-flex text-xs font-bold text-white px-3.5 py-2 rounded-xl border border-white/20 hover:bg-white/10 transition-all">
                            Register
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center lg:hidden">
                        <button type="button" id="mobile-menu-btn" class="p-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 focus:outline-none" aria-label="Toggle Navigation Menu">
                            <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

            </div>

        </div>
    </div>

    @if(!$isMinimal)
        <!-- Mobile Navigation Menu Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-white/10 bg-[#120024]/95 backdrop-blur-2xl px-4 pt-3 pb-6 space-y-2 text-slate-200 shadow-2xl">
            <div class="flex flex-col space-y-1 text-sm font-medium">
                <a href="{{ url('/') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Home</a>
                <a href="{{ url('/plans') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Pricing & VPS Plans</a>
                <a href="{{ url('/#features') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Solutions & DDoS Protection</a>
                <a href="{{ url('/#hardware') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Developers & Hardware</a>
                <a href="{{ url('/customer/support-tickets') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Support Ticket Desk</a>
                <a href="{{ url('/#reviews') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Customer Reviews</a>
            </div>
            <div class="pt-3 border-t border-white/10 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/customer') }}" class="w-full text-center text-xs font-semibold text-white py-2.5 rounded-lg border border-white/20 bg-white/10">Client Area</a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ url('/customer/login') }}" class="w-full text-center text-xs font-semibold text-slate-200 py-2.5 rounded-lg border border-white/15 bg-white/5">Login</a>
                        <a href="{{ url('/customer/register') }}" class="w-full text-center text-xs font-semibold text-white py-2.5 rounded-lg border border-white/20 bg-white/10">Register</a>
                    </div>
                @endauth
                <a href="{{ url('/plans') }}" class="w-full text-center bg-white text-[#120024] text-xs font-extrabold py-2.5 rounded-lg shadow-lg">Deploy VPS Instantly</a>
            </div>
        </div>
    @endif
</header>
