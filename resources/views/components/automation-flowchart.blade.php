<!-- SECTION: DEVOPS AUTOMATION & SELF-HOSTED ECOSYSTEM FLOWCHART -->
<section id="automation" class="py-20 md:py-28 bg-[#0B0014] text-white relative overflow-hidden border-t border-white/[0.08] scroll-mt-20">
    
    <!-- Ambient Cosmic Violet & Indigo Lighting -->
    <div class="absolute top-1/4 -left-20 w-[600px] h-[600px] bg-gradient-to-br from-purple-600/20 to-fuchsia-600/15 rounded-full blur-[150px] pointer-events-none animate-float-slow"></div>
    <div class="absolute bottom-10 right-10 w-[550px] h-[550px] bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none animate-float-reverse"></div>

    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16 relative z-10">
        
        <!-- Section Header -->
        <div class="reveal-init text-center max-w-3xl mx-auto mb-14 sm:mb-20">
            <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-purple-300 bg-white/[0.06] px-4 py-1.5 rounded-full mb-4 border border-white/10 backdrop-blur-md shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>DevOps & Automation Freedom</span>
            </div>
            <h2 class="text-3xl sm:text-4xl lg:text-[44px] font-extrabold text-white tracking-tight leading-tight mb-4">
                Self-Host Anything. Automate Everything.
            </h2>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Run Docker microservices, background worker queues, and automated workflows on dedicated KVM hardware with 100% root privileges. Zero hyperscaler metering.
            </p>
        </div>

        <!-- 2-Column Split Stage: Interactive Node Diagram (Left) + Liberty Features (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left: Connected Node-Based Workflow Diagram (7 Cols) -->
            <div class="lg:col-span-7 reveal-init delay-100 rounded-3xl bg-[#120024]/90 border border-white/[0.12] p-6 sm:p-8 lg:p-10 backdrop-blur-2xl shadow-2xl shadow-purple-950/70 relative overflow-hidden">
                
                <!-- Subtle Background Grid Matrix -->
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none"></div>

                <div class="relative z-10 flex flex-col gap-6 sm:gap-8">
                    
                    <!-- Row 1: Trigger Node -->
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-white/[0.07] border border-white/15 backdrop-blur-md shadow-lg shadow-black/40">
                            <div class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center border border-purple-400/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <div class="text-[10px] uppercase font-mono font-bold text-slate-400">Trigger Node</div>
                                <div class="text-xs font-bold text-white flex items-center gap-1.5">
                                    <span>Git Push / Webhook Event</span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-center gap-1 text-[11px] font-mono text-purple-300/80 bg-purple-950/40 px-3 py-1 rounded-full border border-purple-500/20">
                            <span>Payload: 200 OK</span>
                        </div>
                    </div>

                    <!-- Animated SVG Flow Connector Line 1 -->
                    <div class="w-full flex justify-center py-1">
                        <svg class="w-full h-8 max-w-[280px]" viewBox="0 0 280 32" fill="none">
                            <path d="M140 0 L140 32" stroke="rgba(168, 85, 247, 0.4)" stroke-width="2" stroke-dasharray="4 4" />
                            <circle cx="140" cy="16" r="3" fill="#A855F7">
                                <animate attributeName="cy" values="0;32;0" dur="2s" repeatCount="indefinite" />
                            </circle>
                        </svg>
                    </div>

                    <!-- Row 2: The Core Engine (VortexCloud KVM Node) -->
                    <div class="p-6 rounded-2xl bg-gradient-to-br from-[#1C0038] via-[#2A0054] to-[#16002C] border border-purple-400/40 shadow-xl shadow-purple-900/30 relative group hover:border-purple-400/70 transition-all">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#673DE6] text-white flex items-center justify-center shadow-lg shadow-[#673DE6]/40">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-black text-white tracking-wide">VortexCloud KVM Engine</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">ONLINE</span>
                                    </div>
                                    <span class="font-mono text-xs text-purple-200">root@vortex-prod:~#</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-xs font-mono text-slate-300 bg-black/30 px-3 py-1.5 rounded-lg border border-white/10">
                                <span class="text-emerald-400">●</span>
                                <span>100% Dedicated KVM Virtualization</span>
                            </div>
                        </div>

                        <!-- Live Metrics Strip inside Core Node -->
                        <div class="grid grid-cols-3 gap-2 pt-3 border-t border-white/10 text-center font-mono">
                            <div class="p-2 rounded-lg bg-black/20">
                                <div class="text-[10px] text-slate-400 uppercase">Compute Cores</div>
                                <div class="text-xs font-bold text-white">Dedicated Burst</div>
                            </div>
                            <div class="p-2 rounded-lg bg-black/20">
                                <div class="text-[10px] text-slate-400 uppercase">Memory Allocation</div>
                                <div class="text-xs font-bold text-white">ECC Unshared</div>
                            </div>
                            <div class="p-2 rounded-lg bg-black/20">
                                <div class="text-[10px] text-slate-400 uppercase">I/O Throughput</div>
                                <div class="text-xs font-bold text-emerald-400">7,200 MB/s</div>
                            </div>
                        </div>
                    </div>

                    <!-- Animated SVG Branching Connector Lines -->
                    <div class="w-full flex justify-center py-1">
                        <svg class="w-full h-12" viewBox="0 0 500 48" fill="none">
                            <path d="M250 0 L250 16 M250 16 L80 48 M250 16 L250 48 M250 16 L420 48" stroke="rgba(168, 85, 247, 0.4)" stroke-width="2" stroke-dasharray="4 4" />
                            <circle cx="80" cy="48" r="3" fill="#A855F7" />
                            <circle cx="250" cy="48" r="3" fill="#A855F7" />
                            <circle cx="420" cy="48" r="3" fill="#A855F7" />
                        </svg>
                    </div>

                    <!-- Row 3: 3 Connected Ecosystem Target Nodes -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        
                        <!-- Target 1: Docker Containers -->
                        <div class="p-4 rounded-2xl bg-white/[0.06] border border-white/15 hover:border-purple-400/50 hover:bg-white/[0.09] transition-all">
                            <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center mb-2 text-sm">
                                🐳
                            </div>
                            <div class="text-xs font-bold text-white mb-1">Docker & Compose</div>
                            <div class="text-[11px] text-slate-400 leading-tight">Zero kernel restrictions, isolated stacks & microservices.</div>
                        </div>

                        <!-- Target 2: n8n Automation -->
                        <div class="p-4 rounded-2xl bg-white/[0.06] border border-white/15 hover:border-purple-400/50 hover:bg-white/[0.09] transition-all">
                            <div class="w-7 h-7 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center mb-2 text-sm">
                                ⚡
                            </div>
                            <div class="text-xs font-bold text-white mb-1">Self-Hosted n8n</div>
                            <div class="text-[11px] text-slate-400 leading-tight">Unlimited workflows & background jobs without per-task fees.</div>
                        </div>

                        <!-- Target 3: High-IOPS Databases -->
                        <div class="p-4 rounded-2xl bg-white/[0.06] border border-white/15 hover:border-purple-400/50 hover:bg-white/[0.09] transition-all">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-2 text-sm">
                                🗄️
                            </div>
                            <div class="text-xs font-bold text-white mb-1">Postgres & Redis</div>
                            <div class="text-[11px] text-slate-400 leading-tight">Persistent high-IOPS storage on PCIe 4.0 NVMe arrays.</div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Right: Developer Liberty Feature Points (5 Cols) -->
            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                
                <!-- Feature 1 -->
                <div class="reveal-init delay-100 p-6 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-purple-400/40 hover:bg-white/[0.06] transition-all">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-purple-500/20 text-[#673DE6] flex items-center justify-center font-mono font-bold text-sm">#</span>
                        <h3 class="text-lg font-bold text-white">100% Unrestricted Root Access</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed pl-11">
                        Full Linux kernel authority. Configure custom sysctl networking parameters, install proprietary kernel modules, and tune iptables/nftables without host hypervisor blocks.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="reveal-init delay-200 p-6 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-purple-400/40 hover:bg-white/[0.06] transition-all">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-purple-500/20 text-[#673DE6] flex items-center justify-center font-mono font-bold text-sm">📦</span>
                        <h3 class="text-lg font-bold text-white">Pre-Baked Docker & Compose Stacks</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed pl-11">
                        Deploy production environments in seconds. Install Portainer, Caddy reverse proxy, or Git CI/CD runners with automated 1-click bash installation scripts.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="reveal-init delay-300 p-6 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-purple-400/40 hover:bg-white/[0.06] transition-all">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-8 h-8 rounded-xl bg-purple-500/20 text-[#673DE6] flex items-center justify-center font-mono font-bold text-sm">💰</span>
                        <h3 class="text-lg font-bold text-white">Zero Cloud Hyperscaler Tax</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed pl-11">
                        Stop paying metered per-API billing for internal background tasks. Run long-running cron jobs, crawler workers, and automation webhooks with fixed, locked-in monthly pricing.
                    </p>
                </div>

                <!-- Action Strip -->
                <div class="reveal-init delay-400 pt-2">
                    <a href="#pricing" class="btn-shimmer inline-flex items-center justify-center gap-2 w-full sm:w-auto px-7 py-4 rounded-xl bg-[#673DE6] hover:bg-[#5428D8] text-white font-bold text-sm shadow-xl shadow-[#673DE6]/30 hover:scale-[1.02] transition-all">
                        <span>Deploy an Automation VPS</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <div class="text-xs text-slate-400 mt-2.5 flex items-center gap-2">
                        <span class="text-emerald-400">✓</span>
                        <span>Instant 60s provisioning • Clean Dedicated IPv4 included</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
