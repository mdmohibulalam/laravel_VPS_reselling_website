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
                            500: '#673DE6', // Electric Royal Purple
                            600: '#5428D8', // Rich Violet Hover
                            700: '#4338CA',
                            800: '#3730A3',
                            900: '#120024', // Cosmic Obsidian Base
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
                        'accent': '0 10px 25px -3px rgba(103, 61, 230, 0.3), 0 4px 6px -4px rgba(103, 61, 230, 0.2)',
                    }
                }
            }
        }
    </script>

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

    <!-- Global Navigation Scroll Controller & Mobile Menu Interaction -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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

            // Mobile Menu Toggle
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

                // Close drawer on link click
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        if (openIcon) openIcon.classList.remove('hidden');
                        if (closeIcon) closeIcon.classList.add('hidden');
                    });
                });
            }
        });
    </script>

    <!-- Page-Specific Scripts Stack -->
    @stack('scripts')
</body>
</html>
