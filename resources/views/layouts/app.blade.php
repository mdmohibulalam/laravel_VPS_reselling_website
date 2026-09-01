@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'robots' => 'index, follow',
    'canonical' => null,
    'ogImage' => null,
    'schema' => null,
    'headerVariant' => 'hero', // 'hero', 'solid', or 'minimal'
    'hideHeader' => false,
    'hideFooter' => false,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <!-- Modular SEO & OpenGraph Meta Component -->
    <x-seo-meta 
        :title="$title" 
        :description="$description" 
        :keywords="$keywords" 
        :robots="$robots" 
        :canonical="$canonical" 
        :ogImage="$ogImage" 
        :schema="$schema ?? null" 
    />
    
    <!-- Environment-Safe Analytics Tracking -->
    <x-analytics />

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles & Asset Bundling -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Global Rich Animation & Transition Styles -->
    <style>
        /* Smooth Entrance Keyframes */
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: pageFadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Scroll-Reveal Base & Stagger Classes */
        .reveal-init {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }

        /* Button Light Shimmer Effect */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }
        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
            transform: translateX(-100%);
            transition: transform 0.75s ease;
            pointer-events: none;
        }
        .btn-shimmer:hover::after {
            transform: translateX(100%);
        }

        /* Interactive Card Elevation & Glow Transition */
        .card-interactive {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
        }
        .card-interactive:hover {
            transform: translateY(-4px);
        }

        /* Smooth FAQ Accordion Expansion */
        details summary {
            transition: color 0.2s ease;
        }
        details[open] summary svg {
            transform: rotate(180deg);
        }
    </style>

    <!-- Page-Specific Styles Stack -->
    @stack('styles')
</head>
<body class="bg-white text-slate-600 font-sans antialiased selection:bg-[#673DE6] selection:text-white flex flex-col min-h-screen">

    <!-- Global Toast & Flash Message Notification System -->
    <x-flash-messages />

    <!-- Modular Navigation Header -->
    @if(!$hideHeader)
        <x-header :variant="$headerVariant" />
    @endif

    <!-- Main Content Area with Adaptive Top Offset for Non-Hero Pages -->
    <main class="{{ $headerVariant !== 'hero' && !$hideHeader ? 'pt-20 sm:pt-22' : '' }} flex-grow">
        {{ $slot }}
    </main>

    <!-- Modular Global Footer -->
    @if(!$hideFooter)
        <x-footer />
    @endif

    <!-- Global Navigation Scroll Controller & Scroll-Reveal IntersectionObserver -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Navigation Frosted Glass Transition
            const header = document.getElementById('main-nav-header');
            const glassHighlight = document.getElementById('header-glass-highlight');

            if (header) {
                const variant = header.getAttribute('data-variant') || 'hero';

                if (variant === 'hero') {
                    const checkGlassBarState = () => {
                        if (window.scrollY > 50) {
                            header.classList.remove('bg-transparent', 'border-transparent', 'shadow-none');
                            header.classList.add('backdrop-blur-2xl', 'bg-[#0F0024]/90', 'border-white/[0.12]', 'shadow-2xl', 'shadow-purple-950/40');
                            if (glassHighlight) glassHighlight.classList.remove('opacity-0');
                        } else {
                            header.classList.add('bg-transparent', 'border-transparent', 'shadow-none');
                            header.classList.remove('backdrop-blur-2xl', 'bg-[#0F0024]/90', 'border-white/[0.12]', 'shadow-2xl', 'shadow-purple-950/40');
                            if (glassHighlight) glassHighlight.classList.add('opacity-0');
                        }
                    };

                    window.addEventListener('scroll', checkGlassBarState, { passive: true });
                    checkGlassBarState();
                }
            }

            // 2. Mobile Menu Toggle
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-icon-open');
            const closeIcon = document.getElementById('menu-icon-close');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    if (openIcon) openIcon.classList.toggle('hidden');
                    if (closeIcon) closeIcon.classList.toggle('hidden');
                });

                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        if (openIcon) openIcon.classList.remove('hidden');
                        if (closeIcon) closeIcon.classList.add('hidden');
                    });
                });
            }

            // 3. High-Performance GPU Scroll Reveal Observer
            if ('IntersectionObserver' in window) {
                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('reveal-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -40px 0px'
                });

                document.querySelectorAll('.reveal-init').forEach(el => {
                    revealObserver.observe(el);
                });
            } else {
                // Fallback for older browsers
                document.querySelectorAll('.reveal-init').forEach(el => {
                    el.classList.add('reveal-visible');
                });
            }
        });
    </script>

    <!-- Page-Specific Scripts Stack -->
    @stack('scripts')
</body>
</html>
