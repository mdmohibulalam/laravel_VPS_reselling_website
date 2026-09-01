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
                    <!-- Left-Aligned Clean Direct Navigation Links (No Mega Dropdowns) -->
                    <nav class="hidden lg:flex items-center space-x-1.5 text-sm font-medium text-slate-300">
                        <!-- 1. Pricing -->
                        <a href="{{ url('/plans') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors {{ request()->is('plans*') ? 'text-white bg-white/[0.10]' : '' }}">
                            Pricing
                        </a>

                        <!-- 2. Features -->
                        <a href="{{ url('/#features') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors">
                            Features
                        </a>

                        <!-- 3. Hardware -->
                        <a href="{{ url('/#hardware') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors">
                            Hardware
                        </a>

                        <!-- 4. Reviews -->
                        <a href="{{ url('/#reviews') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors">
                            Reviews
                        </a>

                        <!-- 5. FAQ -->
                        <a href="{{ url('/#faq') }}" class="px-3.5 py-2 rounded-xl hover:text-white hover:bg-white/[0.08] transition-colors">
                            FAQ
                        </a>
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
                    <!-- Language & Currency Pill -->
                    <div class="hidden md:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl hover:bg-white/[0.08] text-xs font-semibold text-slate-300 cursor-pointer transition-colors">
                        <span>🇺🇸</span>
                        <span>EN</span>
                    </div>

                    <!-- User Account / Single Auth Action -->
                    @auth
                        <a href="{{ url('/customer') }}" class="btn-shimmer inline-flex items-center gap-2 text-xs font-bold text-white px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 shadow-md transition-all">
                            <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Client Area</span>
                        </a>
                    @else
                        <a href="{{ url('/customer/login') }}" class="btn-shimmer inline-flex items-center gap-2 text-xs font-bold text-white px-4 py-2.5 rounded-xl bg-[#673DE6] hover:bg-[#5428D8] shadow-lg shadow-[#673DE6]/25 hover:scale-105 active:scale-95 transition-all">
                            <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Login / Register</span>
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
                <a href="{{ url('/plans') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Pricing & Plans</a>
                <a href="{{ url('/#features') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Features & Architecture</a>
                <a href="{{ url('/#hardware') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Hardware Specs</a>
                <a href="{{ url('/#reviews') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">Customer Reviews</a>
                <a href="{{ url('/#faq') }}" class="px-3 py-2.5 rounded-lg hover:bg-white/10 hover:text-white">FAQ</a>
            </div>
            <div class="pt-3 border-t border-white/10 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/customer') }}" class="w-full text-center text-xs font-semibold text-white py-2.5 rounded-lg border border-white/20 bg-white/10">Client Area</a>
                @else
                    <a href="{{ url('/customer/login') }}" class="btn-shimmer w-full text-center text-xs font-bold text-white py-2.5 rounded-lg bg-[#673DE6] hover:bg-[#5428D8] shadow-md">
                        Login / Register
                    </a>
                @endauth
                <a href="{{ url('/plans') }}" class="btn-shimmer w-full text-center bg-white text-[#120024] text-xs font-extrabold py-2.5 rounded-lg shadow-lg">Deploy VPS Instantly</a>
            </div>
        </div>
    @endif
</header>
