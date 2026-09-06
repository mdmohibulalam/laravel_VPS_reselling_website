@props([
    'packages' => null,
])

@php
    if (!$packages) {
        $packages = \App\Models\Package::where('is_active', true)->orderBy('price_monthly')->get();
    }
    $vps4 = $packages->firstWhere('slug', 'cloud-vps-4') ?? $packages->first();
    $vps6 = $packages->firstWhere('slug', 'cloud-vps-6') ?? ($packages->count() > 1 ? $packages->skip(1)->first() : $vps4);
@endphp

<!-- COMPETITOR COMPARISON MATRIX SECTION -->
<section id="comparison" class="py-16 md:py-24 bg-slate-50 border-y border-slate-200/80">
    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
        
        <!-- Section Header -->
        <div class="reveal-init text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#673DE6] bg-purple-50 px-3.5 py-1.5 rounded-full mb-3.5 border border-purple-100 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#673DE6] animate-pulse"></span>
                <span>Unmatched Price-to-Performance</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                Why Pay Up to 10x More for Cloud VPS?
            </h2>
            <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                See how VortexCloud stacks up against legacy cloud giants and shared hosting providers on real compute specs, bandwidth allotments, and true renewal costs.
            </p>

            <!-- Tier Switcher Capsule -->
            <div class="mt-8 inline-flex items-center p-1.5 rounded-2xl bg-slate-200/80 border border-slate-300/80 shadow-inner gap-1">
                <button type="button" 
                    id="tierBtn1" 
                    onclick="switchComparisonTier(1)" 
                    class="transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-[#673DE6] text-white shadow-md shadow-[#673DE6]/25">
                    Tier 1: 4 vCPU / 8 GB RAM
                </button>
                <button type="button" 
                    id="tierBtn2" 
                    onclick="switchComparisonTier(2)" 
                    class="transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-white/60">
                    Tier 2: 6 vCPU / 16 GB RAM
                </button>
            </div>
        </div>

        <!-- Matrix Table Card Container -->
        <div class="reveal-init delay-100 relative rounded-3xl border border-slate-200/90 shadow-soft-md bg-white overflow-hidden">
            
            <!-- Mobile Horizontal Swipe Tip -->
            <div class="lg:hidden bg-purple-50/80 border-b border-purple-100 px-4 py-2 text-center text-xs font-medium text-[#673DE6] flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                <span>Swipe horizontally to view all cloud providers</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[780px]">
                    <thead>
                        <tr>
                            <!-- Feature Header Cell (Sticky on Horizontal Scroll) -->
                            <th scope="col" class="sticky left-0 z-20 bg-white/95 backdrop-blur-md p-5 sm:p-6 text-sm font-bold text-slate-900 border-b border-r border-slate-200 w-1/4 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span class="text-xs uppercase tracking-wider text-slate-500 font-bold block mb-1">Architecture Features</span>
                                Server Specifications
                            </th>

                            <!-- VortexCloud (Winner Column) -->
                            <th scope="col" class="relative p-5 sm:p-6 text-center bg-gradient-to-b from-purple-50/70 via-white to-white border-b-2 border-r-2 border-l-2 border-[#673DE6] w-[28%]">
                                <div class="absolute -top-px left-0 right-0 h-1.5 bg-[#673DE6]"></div>
                                <div class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full bg-[#673DE6] text-white text-[11px] font-bold uppercase tracking-wider shadow-sm mb-2">
                                    ★ Top Performance
                                </div>
                                <div class="text-xl font-extrabold text-slate-900">VortexCloud</div>
                                <div class="text-xs font-semibold text-[#673DE6] mt-0.5">Enterprise Cloud KVM</div>
                                
                                <div class="mt-4 pt-3 border-t border-purple-100/80">
                                    <div class="flex items-baseline justify-center gap-0.5">
                                        <span class="text-lg font-bold text-[#673DE6]">$</span>
                                        <span id="vcPrice" class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight transition-all duration-300">4.99</span>
                                        <span class="text-xs font-semibold text-slate-500">/month</span>
                                    </div>
                                    <div class="text-[11px] font-semibold text-emerald-600 mt-1">Guaranteed Fixed Renewal</div>
                                </div>
                            </th>

                            <!-- Competitor 1: DigitalOcean -->
                            <th scope="col" class="p-5 sm:p-6 text-center border-b border-r border-slate-200 w-[24%] bg-slate-50/40">
                                <div class="text-lg font-bold text-slate-800">DigitalOcean</div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">Basic Droplet</div>
                                
                                <div class="mt-4 pt-3 border-t border-slate-200/80">
                                    <div class="flex items-baseline justify-center gap-0.5">
                                        <span class="text-lg font-bold text-slate-600">$</span>
                                        <span id="doPrice" class="text-2xl sm:text-3xl font-extrabold text-slate-700 tracking-tight transition-all duration-300">48.00</span>
                                        <span class="text-xs font-semibold text-slate-500">/month</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-1">9.6x higher cost</div>
                                </div>
                            </th>

                            <!-- Competitor 2: AWS Lightsail -->
                            <th scope="col" class="p-5 sm:p-6 text-center border-b border-r border-slate-200 w-[24%] bg-slate-50/40">
                                <div class="text-lg font-bold text-slate-800">AWS Lightsail</div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">Standard Instance</div>
                                
                                <div class="mt-4 pt-3 border-t border-slate-200/80">
                                    <div class="flex items-baseline justify-center gap-0.5">
                                        <span class="text-lg font-bold text-slate-600">$</span>
                                        <span id="awsPrice" class="text-2xl sm:text-3xl font-extrabold text-slate-700 tracking-tight transition-all duration-300">44.00</span>
                                        <span class="text-xs font-semibold text-slate-500">/month</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-1">8.8x higher cost</div>
                                </div>
                            </th>

                            <!-- Competitor 3: Hostinger -->
                            <th scope="col" class="p-5 sm:p-6 text-center border-b border-slate-200 w-[24%] bg-slate-50/40">
                                <div class="text-lg font-bold text-slate-800">Hostinger</div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">KVM VPS Plan</div>
                                
                                <div class="mt-4 pt-3 border-t border-slate-200/80">
                                    <div class="flex items-baseline justify-center gap-0.5">
                                        <span class="text-lg font-bold text-slate-600">$</span>
                                        <span id="hostingerPrice" class="text-2xl sm:text-3xl font-extrabold text-slate-700 tracking-tight transition-all duration-300">11.99</span>
                                        <span class="text-xs font-semibold text-slate-500">/month</span>
                                    </div>
                                    <div class="text-[11px] text-amber-600 font-semibold mt-1">Renews at $19.99/mo (+67%)</div>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-sm">
                        
                        <!-- Row 1: vCPU Cores & Hardware -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <div class="flex items-center gap-2">
                                    <span>Processor & Cores</span>
                                </div>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">Hardware clock speed</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <span id="vcCores" class="font-extrabold text-slate-900 text-base">4 Cores</span>
                                <div class="text-[11px] font-semibold text-[#673DE6]">AMD EPYC™ 3.7 GHz (Dedicated)</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="doCores" class="font-bold text-slate-800">4 Cores</span>
                                <div class="text-[11px] text-slate-500">Standard Shared vCPU</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="awsCores" class="font-bold text-slate-800">4 Cores</span>
                                <div class="text-[11px] text-slate-500">Burstable Baseline</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span id="hostingerCores" class="font-bold text-slate-800">4 Cores</span>
                                <div class="text-[11px] text-slate-500">Shared Host Node</div>
                            </td>
                        </tr>

                        <!-- Row 2: Dedicated RAM -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>Dedicated RAM</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">ECC Memory Standard</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <span id="vcRam" class="font-extrabold text-slate-900 text-base">8 GB</span>
                                <div class="text-[11px] font-semibold text-emerald-600">DDR5 ECC High-Speed</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="doRam" class="font-bold text-slate-800">8 GB</span>
                                <div class="text-[11px] text-slate-500">Standard DDR4</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="awsRam" class="font-bold text-slate-800">8 GB</span>
                                <div class="text-[11px] text-slate-500">Standard DDR4</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span id="hostingerRam" class="font-bold text-slate-800">8 GB</span>
                                <div class="text-[11px] text-slate-500">Standard RAM</div>
                            </td>
                        </tr>

                        <!-- Row 3: Fast NVMe Storage -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>High-Speed Storage</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">PCIe Gen4 Flash Throughput</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <span id="vcStorage" class="font-extrabold text-slate-900 text-base">100 GB NVMe</span>
                                <div class="text-[11px] font-semibold text-[#673DE6]">Samsung® Gen4 RAID-10 (7,200 MB/s)</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="doStorage" class="font-bold text-slate-800">160 GB SSD</span>
                                <div class="text-[11px] text-slate-500">Standard SATA/SaaS SSD</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span id="awsStorage" class="font-bold text-slate-800">160 GB SSD</span>
                                <div class="text-[11px] text-slate-500">Standard EBS Volumes</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span id="hostingerStorage" class="font-bold text-slate-800">100 GB NVMe</span>
                                <div class="text-[11px] text-slate-500">Shared SSD Pool</div>
                            </td>
                        </tr>

                        <!-- Row 4: Monthly Bandwidth Allotment -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>Monthly Bandwidth</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">Port speed & traffic cap</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <span class="font-extrabold text-slate-900 text-base">32 TB Traffic</span>
                                <div class="text-[11px] font-semibold text-emerald-600">10 Gbps Tier-1 Redundant Port</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-bold text-slate-800">5 TB Traffic</span>
                                <div class="text-[11px] text-rose-500 font-medium">$0.01/GB Overage fee</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-bold text-slate-800">5 TB Traffic</span>
                                <div class="text-[11px] text-rose-500 font-medium">$0.09/GB Outbound fee</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span class="font-bold text-slate-800">8 TB Traffic</span>
                                <div class="text-[11px] text-slate-500">Speed throttled at cap</div>
                            </td>
                        </tr>

                        <!-- Row 5: DDoS Scrubbing Protection -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>DDoS Defense</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">Automated traffic filtering</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <div class="inline-flex items-center gap-1.5 font-extrabold text-emerald-600">
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Included Free</span>
                                </div>
                                <div class="text-[11px] font-medium text-slate-600">Layer 4 & Layer 7 Scrubbing</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-semibold text-slate-700">Basic Layer 3/4</span>
                                <div class="text-[11px] text-slate-400">Limited attack mitigation</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-semibold text-slate-700">AWS Shield Standard</span>
                                <div class="text-[11px] text-slate-400">Basic network protection</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <div class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                    <span>Standard Firewall</span>
                                </div>
                                <div class="text-[11px] text-slate-400">Basic filtering</div>
                            </td>
                        </tr>

                        <!-- Row 6: Renewal Price Hikes -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>Renewal Price Lock</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">Long-term billing stability</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <div class="inline-flex items-center gap-1.5 font-extrabold text-emerald-600">
                                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Fixed For Life</span>
                                </div>
                                <div class="text-[11px] text-slate-600 font-medium">Zero surprise price hikes</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="text-slate-700 font-semibold">Standard Flat Rate</span>
                                <div class="text-[11px] text-slate-400">Consistently expensive</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="text-slate-700 font-semibold">Variable AWS Billing</span>
                                <div class="text-[11px] text-slate-400">Snapshot & traffic extras</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span class="text-rose-600 font-bold">Increases to $19.99/mo</span>
                                <div class="text-[11px] text-rose-500">67% price surge on renewal</div>
                            </td>
                        </tr>

                        <!-- Row 7: Full Root & OS Choices -->
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white/95 backdrop-blur-md p-4 sm:p-5 font-semibold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span>Full Root & OS Variety</span>
                                <span class="text-[11px] text-slate-500 font-normal block mt-0.5">Linux distros & Windows RDP</span>
                            </td>
                            <td class="p-4 sm:p-5 text-center bg-purple-50/20 border-r-2 border-l-2 border-[#673DE6]">
                                <div class="font-extrabold text-slate-900">100% Root Access</div>
                                <div class="text-[11px] font-semibold text-[#673DE6]">Ubuntu, Debian, AlmaLinux, Windows</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-semibold text-slate-800">Root Access</span>
                                <div class="text-[11px] text-slate-500">Linux only (No native Windows)</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center border-r border-slate-200">
                                <span class="font-semibold text-slate-800">Root / Admin</span>
                                <div class="text-[11px] text-slate-500">Windows incurs heavy fee</div>
                            </td>
                            <td class="p-4 sm:p-5 text-center">
                                <span class="font-semibold text-slate-800">Root Access</span>
                                <div class="text-[11px] text-slate-500">Limited custom ISO support</div>
                            </td>
                        </tr>

                        <!-- Bottom Action Row -->
                        <tr class="bg-slate-50/80">
                            <td class="sticky left-0 z-10 bg-slate-50/95 backdrop-blur-md p-5 sm:p-6 font-bold text-slate-900 border-r border-slate-200 shadow-[4px_0_12px_-4px_rgba(0,0,0,0.05)]">
                                <span class="text-xs text-slate-500 block mb-1">Instant Deployment</span>
                                Select Configuration
                            </td>
                            
                            <!-- VortexCloud CTA -->
                            <td class="p-5 sm:p-6 text-center bg-purple-50/40 border-r-2 border-l-2 border-b-2 border-[#673DE6]">
                                <a id="vcDeployBtn" 
                                   href="{{ route('checkout.show', $vps4) }}" 
                                   class="btn-shimmer inline-flex items-center justify-center gap-2 w-full py-3 px-5 rounded-xl bg-[#673DE6] hover:bg-[#5428D8] text-white text-sm font-extrabold shadow-lg shadow-[#673DE6]/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                    <span>Deploy With VortexCloud</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                                <div class="text-[11px] text-slate-500 mt-2 font-medium">60-second automated provisioning</div>
                            </td>

                            <!-- DigitalOcean -->
                            <td class="p-5 sm:p-6 text-center border-r border-slate-200">
                                <span class="inline-block py-2.5 px-4 rounded-xl bg-slate-200/60 text-slate-600 text-xs font-bold cursor-not-allowed">
                                    Overpriced ($48.00)
                                </span>
                            </td>

                            <!-- AWS -->
                            <td class="p-5 sm:p-6 text-center border-r border-slate-200">
                                <span class="inline-block py-2.5 px-4 rounded-xl bg-slate-200/60 text-slate-600 text-xs font-bold cursor-not-allowed">
                                    Overpriced ($44.00)
                                </span>
                            </td>

                            <!-- Hostinger -->
                            <td class="p-5 sm:p-6 text-center">
                                <span class="inline-block py-2.5 px-4 rounded-xl bg-slate-200/60 text-slate-600 text-xs font-bold cursor-not-allowed">
                                    High Renewal ($19.99)
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>

        <!-- Trust Highlights Strip Below Matrix -->
        <div class="reveal-init delay-200 mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-soft-sm flex items-center justify-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-[#673DE6] flex items-center justify-center font-bold shrink-0">
                    ⚡
                </div>
                <div class="text-left">
                    <div class="text-xs font-bold text-slate-900">Zero Setup Fees</div>
                    <div class="text-[11px] text-slate-500">Deploy without hidden charges</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-soft-sm flex items-center justify-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                    ✓
                </div>
                <div class="text-left">
                    <div class="text-xs font-bold text-slate-900">Free Migration Help</div>
                    <div class="text-[11px] text-slate-500">Assisted transfer from any host</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-soft-sm flex items-center justify-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-[#673DE6] flex items-center justify-center font-bold shrink-0">
                    🛡
                </div>
                <div class="text-left">
                    <div class="text-xs font-bold text-slate-900">30-Day Money Back</div>
                    <div class="text-[11px] text-slate-500">100% risk-free testing guarantee</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-soft-sm flex items-center justify-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold shrink-0">
                    99.9%
                </div>
                <div class="text-left">
                    <div class="text-xs font-bold text-slate-900">Tier-3+ Datacenters</div>
                    <div class="text-[11px] text-slate-500">9 global low-latency regions</div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Vanilla JS Comparison Switcher Controller -->
<script>
    (function () {
        const tierData = {
            1: {
                name: 'Cloud VPS 4',
                checkoutUrl: '{{ route("checkout.show", $vps4) }}',
                vc: { price: '4.99', cores: '4 Cores', ram: '8 GB', storage: '100 GB NVMe' },
                do: { price: '48.00', cores: '4 Cores', ram: '8 GB', storage: '160 GB SSD' },
                aws: { price: '44.00', cores: '4 Cores', ram: '8 GB', storage: '160 GB SSD' },
                hostinger: { price: '11.99', cores: '4 Cores', ram: '8 GB', storage: '100 GB NVMe' }
            },
            2: {
                name: 'Cloud VPS 6',
                checkoutUrl: '{{ route("checkout.show", $vps6) }}',
                vc: { price: '8.99', cores: '6 Cores', ram: '16 GB', storage: '200 GB NVMe' },
                do: { price: '96.00', cores: '6 Cores', ram: '16 GB', storage: '320 GB SSD' },
                aws: { price: '88.00', cores: '6 Cores', ram: '16 GB', storage: '320 GB SSD' },
                hostinger: { price: '19.99', cores: '6 Cores', ram: '16 GB', storage: '200 GB NVMe' }
            }
        };

        window.switchComparisonTier = function (tier) {
            const data = tierData[tier];
            if (!data) return;

            const btn1 = document.getElementById('tierBtn1');
            const btn2 = document.getElementById('tierBtn2');

            if (btn1 && btn2) {
                if (tier === 1) {
                    btn1.className = 'transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-[#673DE6] text-white shadow-md shadow-[#673DE6]/25';
                    btn2.className = 'transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-white/60';
                } else {
                    btn2.className = 'transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-[#673DE6] text-white shadow-md shadow-[#673DE6]/25';
                    btn1.className = 'transition-all duration-200 px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 hover:text-slate-900 hover:bg-white/60';
                }
            }

            // Update Elements safely
            const updateText = (id, text) => {
                const el = document.getElementById(id);
                if (el) el.textContent = text;
            };

            updateText('vcPrice', data.vc.price);
            updateText('doPrice', data.do.price);
            updateText('awsPrice', data.aws.price);
            updateText('hostingerPrice', data.hostinger.price);

            updateText('vcCores', data.vc.cores);
            updateText('doCores', data.do.cores);
            updateText('awsCores', data.aws.cores);
            updateText('hostingerCores', data.hostinger.cores);

            updateText('vcRam', data.vc.ram);
            updateText('doRam', data.do.ram);
            updateText('awsRam', data.aws.ram);
            updateText('hostingerRam', data.hostinger.ram);

            updateText('vcStorage', data.vc.storage);
            updateText('doStorage', data.do.storage);
            updateText('awsStorage', data.aws.storage);
            updateText('hostingerStorage', data.hostinger.storage);

            const deployBtn = document.getElementById('vcDeployBtn');
            if (deployBtn) {
                deployBtn.href = data.checkoutUrl;
            }
        };
    })();
</script>
