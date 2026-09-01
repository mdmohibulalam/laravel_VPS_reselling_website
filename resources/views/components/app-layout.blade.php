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

    <!-- SaaS Clean Sticky Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 transition-all">
        <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="/" class="flex items-center gap-3 group focus:outline-none">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                            <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                            <line x1="6" y1="6" x2="6.01" y2="6"></line>
                            <line x1="6" y1="18" x2="6.01" y2="18"></line>
                            <line x1="18" y1="6" x2="14" y2="6"></line>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl text-slate-900 tracking-tight leading-none group-hover:text-indigo-600 transition-colors">VortexCloud</span>
                        <span class="text-[11px] font-medium text-slate-500 uppercase tracking-wider mt-0.5">Enterprise Cloud VPS</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-1 text-sm font-medium text-slate-600">
                    <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors {{ request()->is('/') ? 'text-indigo-600 font-semibold bg-indigo-50/50' : '' }}">Home</a>
                    <a href="{{ url('/plans') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors {{ request()->is('plans*') ? 'text-indigo-600 font-semibold bg-indigo-50/50' : '' }}">VPS & RDP</a>
                    <a href="{{ url('/#features') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors">Features</a>
                    <a href="{{ url('/#hardware') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors">Hardware</a>
                    <a href="{{ url('/#reviews') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors">Reviews</a>
                    <a href="{{ url('/#faq') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors">FAQ</a>
                    <a href="{{ url('/customer/support-tickets') }}" class="px-3 py-2 rounded-lg hover:text-slate-900 hover:bg-slate-50 transition-colors">Support</a>
                </nav>

                <!-- Action Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/customer') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 border border-slate-200 transition-all">
                            Client Area
                        </a>
                    @else
                        <a href="{{ url('/customer/login') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 border border-slate-200 transition-all">
                            Login
                        </a>
                        <a href="{{ url('/customer/register') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 border border-slate-200 transition-all">
                            Register
                        </a>
                    @endauth
                    <a href="{{ url('/plans') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4.5 py-2.5 rounded-xl shadow-lg shadow-indigo-500/25 hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                        <span>Deploy VPS</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" id="mobile-menu-btn" class="p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 focus:outline-none" aria-label="Toggle Navigation Menu">
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

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <div class="flex flex-col space-y-1 text-base font-medium text-slate-700">
                <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 {{ request()->is('/') ? 'text-indigo-600 font-semibold bg-indigo-50/50' : '' }}">Home</a>
                <a href="{{ url('/plans') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900 {{ request()->is('plans*') ? 'text-indigo-600 font-semibold bg-indigo-50/50' : '' }}">VPS & RDP Packages</a>
                <a href="{{ url('/#features') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900">Features</a>
                <a href="{{ url('/#hardware') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900">Enterprise Hardware</a>
                <a href="{{ url('/#reviews') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900">Customer Reviews</a>
                <a href="{{ url('/#faq') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900">FAQ</a>
                <a href="{{ url('/customer/support-tickets') }}" class="px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-slate-900">Support Desk</a>
            </div>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/customer') }}" class="w-full text-center text-sm font-semibold text-slate-700 py-3 rounded-xl border border-slate-200 bg-slate-50">Client Area</a>
                @else
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ url('/customer/login') }}" class="w-full text-center text-sm font-semibold text-slate-700 py-3 rounded-xl border border-slate-200 bg-slate-50">Login</a>
                        <a href="{{ url('/customer/register') }}" class="w-full text-center text-sm font-semibold text-slate-700 py-3 rounded-xl border border-slate-200 bg-slate-50">Register</a>
                    </div>
                @endauth
                <a href="{{ url('/plans') }}" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-3 rounded-xl shadow-md">Deploy VPS Now</a>
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

    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
