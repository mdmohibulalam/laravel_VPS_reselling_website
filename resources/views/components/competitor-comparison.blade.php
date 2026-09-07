@props([
    'packages' => null,
])

<!-- TRANSPARENT RESOURCE ECONOMICS & VALUE SHOWCASE -->
<section id="comparison" class="py-20 md:py-28 bg-gradient-to-b from-slate-50 via-white to-slate-50 border-y border-slate-200/90 relative overflow-hidden scroll-mt-20">
    <div id="features" class="sr-only"></div>
    
    <!-- Subtle Ambient Stage Lighting -->
    <div class="absolute top-0 right-1/4 w-[600px] h-[350px] bg-purple-500/5 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-[500px] h-[300px] bg-indigo-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16 relative z-10">
        
        <!-- Section Header -->
        <div class="reveal-init text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-4 py-1.5 rounded-full mb-4 border border-purple-200/80 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#673DE6]"></span>
                <span>Resource Economics & Transparency</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-[44px] font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                Maximum Compute Per Dollar. Zero Billing Surprises.
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Stop paying for hyperscaler markups and unpredictable egress fees. Get dedicated KVM hardware performance with predictable, fixed monthly pricing.
            </p>
        </div>

        <!-- 4-Pillar Architectural & Billing Comparison -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-8">
            
            <!-- Pillar 1: Egress & Bandwidth -->
            <div class="reveal-init delay-100 card-interactive rounded-3xl p-7 bg-white border border-slate-200/90 shadow-soft-sm hover:shadow-xl hover:border-purple-300 transition-all flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute right-5 top-3 text-6xl sm:text-7xl font-mono font-black text-slate-900/[0.04] select-none pointer-events-none group-hover:text-[#673DE6]/[0.08] transition-colors">01</div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#673DE6] flex items-center justify-center mb-5 border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Zero Egress Traps</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Hyperscalers charge up to $0.09/GB on outbound traffic—a modest 10 TB month easily adds $900 in surprise fees.
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/80 text-xs font-semibold text-emerald-800">
                    ✓ VortexCloud: 32 TB High-Speed Traffic included free on all plans.
                </div>
            </div>

            <!-- Pillar 2: Transparent Billing -->
            <div class="reveal-init delay-200 card-interactive rounded-3xl p-7 bg-white border border-slate-200/90 shadow-soft-sm hover:shadow-xl hover:border-purple-300 transition-all flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute right-5 top-3 text-6xl sm:text-7xl font-mono font-black text-slate-900/[0.04] select-none pointer-events-none group-hover:text-[#673DE6]/[0.08] transition-colors">02</div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#673DE6] flex items-center justify-center mb-5 border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Predictable Invoicing</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        No 30-page invoices fluctuating based on disk IOPS, API gateway hits, or internal network transfers.
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/80 text-xs font-semibold text-emerald-800">
                    ✓ VortexCloud: 100% fixed monthly rate with zero hidden line items.
                </div>
            </div>

            <!-- Pillar 3: Renewal Integrity -->
            <div class="reveal-init delay-300 card-interactive rounded-3xl p-7 bg-white border border-slate-200/90 shadow-soft-sm hover:shadow-xl hover:border-purple-300 transition-all flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute right-5 top-3 text-6xl sm:text-7xl font-mono font-black text-slate-900/[0.04] select-none pointer-events-none group-hover:text-[#673DE6]/[0.08] transition-colors">03</div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#673DE6] flex items-center justify-center mb-5 border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Guaranteed Fixed Rates</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Legacy budget hosts use low initial teaser prices, then jack up renewal bills by 300% to 500% in month 2.
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/80 text-xs font-semibold text-emerald-800">
                    ✓ VortexCloud: Locked-in renewal pricing for the entire life of your plan.
                </div>
            </div>

            <!-- Pillar 4: True KVM Virtualization -->
            <div class="reveal-init delay-400 card-interactive rounded-3xl p-7 bg-white border border-slate-200/90 shadow-soft-sm hover:shadow-xl hover:border-purple-300 transition-all flex flex-col justify-between relative overflow-hidden group">
                <div class="absolute right-5 top-3 text-6xl sm:text-7xl font-mono font-black text-slate-900/[0.04] select-none pointer-events-none group-hover:text-[#673DE6]/[0.08] transition-colors">04</div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#673DE6] flex items-center justify-center mb-5 border border-purple-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Dedicated KVM Compute</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        No "burstable CPU credits" or artificial throttling that slows down your production apps during traffic peaks.
                    </p>
                </div>
                <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/80 text-xs font-semibold text-emerald-800">
                    ✓ VortexCloud: 100% KVM hardware isolation with custom ISOs & full root.
                </div>
            </div>

        </div>

        <!-- Editorial Minimalist Standards & SLA Matrix (Lighter Inspired) -->
        <div class="mt-16 sm:mt-20 max-w-5xl mx-auto">
            <div class="reveal-init text-center mb-10">
                <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-4 py-1.5 rounded-full mb-3 border border-purple-200/80 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-[#673DE6]"></span>
                    <span>Infrastructure Architecture Standards</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Recognized Compliance & Network SLA
                </h3>
            </div>

            <div class="reveal-init delay-100 bg-white rounded-3xl border border-slate-200/90 shadow-soft-sm overflow-hidden divide-y divide-slate-100">
                
                <!-- Row 1 -->
                <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/70 transition-colors group">
                    <div class="w-full sm:w-1/3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Datacenter Security</span>
                        <h4 class="text-base font-bold text-slate-900 group-hover:text-[#673DE6] transition-colors">Tier-3+ Facilities</h4>
                    </div>
                    <div class="w-full sm:w-1/2 text-xs sm:text-sm text-slate-600">
                        ISO 27001 & SOC 2 Type II Aligned • Dual N+1 Diesel Generators
                    </div>
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-mono font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            99.99% SLA
                        </span>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/70 transition-colors group">
                    <div class="w-full sm:w-1/3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">DDoS Mitigation Core</span>
                        <h4 class="text-base font-bold text-slate-900 group-hover:text-[#673DE6] transition-colors">Automated Inline Scrubbing</h4>
                    </div>
                    <div class="w-full sm:w-1/2 text-xs sm:text-sm text-slate-600">
                        Multi-Terabit 2.4 Tbps Real-Time Edge Filtering (Volumetric L3/L4 & L7)
                    </div>
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-[#673DE6] border border-purple-200/80 text-xs font-mono font-bold">
                            0.00 ms Added
                        </span>
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/70 transition-colors group">
                    <div class="w-full sm:w-1/3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Fiber Connectivity</span>
                        <h4 class="text-base font-bold text-slate-900 group-hover:text-[#673DE6] transition-colors">Tier-1 Direct Peering</h4>
                    </div>
                    <div class="w-full sm:w-1/2 text-xs sm:text-sm text-slate-600">
                        Redundant Low-Latency Carrier Transit via Lumen, Telia, Cogent & DE-CIX
                    </div>
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-800 border border-slate-200 text-xs font-mono font-bold">
                            &lt; 15ms Regional
                        </span>
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/70 transition-colors group">
                    <div class="w-full sm:w-1/3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Hypervisor Layer</span>
                        <h4 class="text-base font-bold text-slate-900 group-hover:text-[#673DE6] transition-colors">Dedicated Type-1 KVM</h4>
                    </div>
                    <div class="w-full sm:w-1/2 text-xs sm:text-sm text-slate-600">
                        100% Kernel Isolation • Custom ISO Booting • Zero CPU Overcommit
                    </div>
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-[#673DE6] border border-purple-200/80 text-xs font-mono font-bold">
                            Dedicated Threads
                        </span>
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-50/70 transition-colors group">
                    <div class="w-full sm:w-1/3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Storage Subsystem</span>
                        <h4 class="text-base font-bold text-slate-900 group-hover:text-[#673DE6] transition-colors">Enterprise PCIe 4.0 NVMe</h4>
                    </div>
                    <div class="w-full sm:w-1/2 text-xs sm:text-sm text-slate-600">
                        Zero-Wait Solid-State Flash Arrays in Mirrored RAID-10 Resiliency
                    </div>
                    <div class="w-full sm:w-auto text-left sm:text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200/80 text-xs font-mono font-bold">
                            7,200 MB/s Peak
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Trust Badges Strip -->
        <div class="mt-12 pt-8 border-t border-slate-200/80 flex flex-wrap items-center justify-center gap-6 sm:gap-12 text-xs font-semibold text-slate-500">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Instant 60-Second Setup</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>14-Day Money-Back Guarantee</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>99.99% Hardware Uptime SLA</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Dedicated IPv4 + /64 IPv6</span>
            </div>
        </div>
    </div>
</section>


