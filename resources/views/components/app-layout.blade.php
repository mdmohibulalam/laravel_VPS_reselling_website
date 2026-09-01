<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lightning-Fast NVMe VPS Hosting for Developers. Deploy high-performance virtual private servers in seconds with dedicated resources, root access, and unmetered bandwidth.">
    <title>{{ config('app.name', 'VortexCloud') }} - Lightning-Fast NVMe VPS Hosting for Developers</title>
    
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#EEF2FF',
                            100: '#E0E7FF',
                            200: '#C7D2FE',
                            300: '#A5B4FC',
                            400: '#818CF8',
                            500: '#6366F1', // Accent Purple/Indigo
                            600: '#4F46E5', // Rich Indigo Hover
                            700: '#4338CA',
                            800: '#3730A3',
                            900: '#312E81',
                        },
                        navy: {
                            900: '#0F172A',
                            800: '#1E293B',
                            700: '#334155',
                        },
                        surface: {
                            white: '#FFFFFF',
                            alt: '#F8FAFC',
                        }
                    },
                    boxShadow: {
                        'soft-sm': '0 1px 2px 0 rgba(15, 23, 42, 0.05)',
                        'soft-md': '0 4px 12px -2px rgba(15, 23, 42, 0.08), 0 2px 6px -2px rgba(15, 23, 42, 0.04)',
                        'soft-lg': '0 12px 24px -4px rgba(15, 23, 42, 0.08), 0 4px 8px -2px rgba(15, 23, 42, 0.04)',
                        'soft-xl': '0 20px 30px -6px rgba(15, 23, 42, 0.1), 0 8px 12px -4px rgba(15, 23, 42, 0.06)',
                        'accent': '0 10px 25px -3px rgba(99, 102, 241, 0.3), 0 4px 6px -4px rgba(99, 102, 241, 0.2)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-slate-600 font-sans antialiased selection:bg-indigo-500 selection:text-white flex flex-col min-h-screen">

    <!-- Hostinger-Style Floating Glass Navigation Bar -->
    <header 
        id="main-nav-header" 
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-in-out bg-transparent border-b border-transparent shadow-none"
    >
        <!-- Subtle Top Glass Highlight Line (Visible on Scroll) -->
        <div id="header-glass-highlight" class="h-[1px] w-full bg-gradient-to-r from-transparent via-purple-500/40 to-transparent opacity-0 transition-opacity duration-300"></div>

        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            <!-- Standard Format Taller Height (84px - 88px) -->
            <div class="flex items-center justify-between h-20 sm:h-22">
                
                <!-- Left: Brand Logo & Left-Aligned Navigation -->
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

                    <!-- Left-Aligned Navigation Links -->
                    <nav class="hidden lg:flex items-center space-x-1.5 text-sm font-medium text-slate-300">
                        <!-- 1. Pricing Direct Link -->
                        <a href="{{ url('/plans') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors">
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
                </div>

                <!-- Right: Action Center (Hostinger Exact Pills & Icons) -->
                <div class="flex items-center space-x-3.5">
                    
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

                </div>

            </div>
        </div>

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
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- SaaS Clean Light-Mode Footer -->
    <footer class="bg-white border-t border-slate-200">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16 py-16">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10">
                <!-- Brand Summary & Uptime -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                <line x1="6" y1="18" x2="6.01" y2="18"></line>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-slate-900 tracking-tight">VortexCloud</span>
                    </div>
                    <p class="text-sm text-slate-600 max-w-sm leading-relaxed">
                        High-performance B2B virtual private servers powered by AMD EPYC™, Intel® Xeon®, and enterprise Samsung® Gen4 NVMe arrays with instant automated provisioning.
                    </p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs font-medium text-slate-700">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                        <span>All Systems Operational (99.99% Uptime)</span>
                    </div>
                </div>

                <!-- Products -->
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">Compute & VPS</h3>
                    <ul class="space-y-2.5 text-sm text-slate-600">
                        <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Starter NVMe VPS</a></li>
                        <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Professional VPS</a></li>
                        <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Enterprise VPS</a></li>
                        <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Windows RDP Servers</a></li>
                        <li><a href="#pricing" class="hover:text-indigo-600 transition-colors">Custom Reseller Tiers</a></li>
                    </ul>
                </div>

                <!-- Infrastructure -->
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">Infrastructure</h3>
                    <ul class="space-y-2.5 text-sm text-slate-600">
                        <li><a href="#hardware" class="hover:text-indigo-600 transition-colors">AMD EPYC™ Nodes</a></li>
                        <li><a href="#hardware" class="hover:text-indigo-600 transition-colors">Samsung® Gen4 NVMe</a></li>
                        <li><a href="#features" class="hover:text-indigo-600 transition-colors">DDoS Scrubbing Core</a></li>
                        <li><a href="#features" class="hover:text-indigo-600 transition-colors">Global Tier-1 Network</a></li>
                        <li><a href="#hardware" class="hover:text-indigo-600 transition-colors">KVM Virtualization</a></li>
                    </ul>
                </div>

                <!-- Support & Legal -->
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4">Support & Portal</h3>
                    <ul class="space-y-2.5 text-sm text-slate-600">
                        <li><a href="/customer/login" class="hover:text-indigo-600 transition-colors">Customer Portal</a></li>
                        <li><a href="#faq" class="hover:text-indigo-600 transition-colors">Knowledge Base & FAQ</a></li>
                        <li><a href="/customer" class="hover:text-indigo-600 transition-colors">24/7 Expert Ticket Desk</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-indigo-600 transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} VortexCloud Technologies LLC. All rights reserved.</p>
                <div class="flex items-center space-x-6">
                    <span class="text-slate-400">SOC 2 Type II Certified Datacenters</span>
                    <span class="text-slate-400">1 Gbps - 10 Gbps Unmetered Uplinks</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Header Scroll Controller & Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const header = document.getElementById('main-nav-header');
            const glassHighlight = document.getElementById('header-glass-highlight');

            if (header) {
                const checkGlassBarState = () => {
                    // When scrolled down (> 50px), activate the frosted glass bar effect
                    if (window.scrollY > 50) {
                        header.classList.remove('bg-transparent', 'border-transparent', 'shadow-none');
                        header.classList.add('backdrop-blur-2xl', 'bg-[#0F0024]/85', 'border-white/[0.12]', 'shadow-2xl', 'shadow-purple-950/40');
                        if (glassHighlight) glassHighlight.classList.remove('opacity-0');
                    } else {
                        // In hero section / at top: Menu is visible, but the bar container is completely transparent
                        header.classList.add('bg-transparent', 'border-transparent', 'shadow-none');
                        header.classList.remove('backdrop-blur-2xl', 'bg-[#0F0024]/85', 'border-white/[0.12]', 'shadow-2xl', 'shadow-purple-950/40');
                        if (glassHighlight) glassHighlight.classList.add('opacity-0');
                    }
                };

                window.addEventListener('scroll', checkGlassBarState, { passive: true });
                checkGlassBarState();
            }

            // Mobile Menu Toggle
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-icon-open');
            const closeIcon = document.getElementById('menu-icon-close');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    openIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });

                // Close on link click
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        openIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    });
                });
            }
        });
    </script>
</body>
</html>
