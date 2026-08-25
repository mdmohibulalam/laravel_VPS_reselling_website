<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Premium Cloud & RDP Services</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts/Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            900: '#1e3a8a',
                        },
                        dark: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass {
                @apply bg-white/10 backdrop-blur-lg border border-white/20;
            }
            .glass-dark {
                @apply bg-slate-900/50 backdrop-blur-xl border border-slate-700/50;
            }
        }
    </style>
</head>
<body class="bg-dark-900 text-slate-300 font-sans antialiased selection:bg-primary-500 selection:text-white">

    <nav class="fixed w-full z-50 glass-dark border-b-0 border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white font-display font-bold text-xl shadow-lg shadow-primary-500/30">
                        V
                    </div>
                    <span class="font-display font-bold text-2xl text-white tracking-tight">VortexCloud</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-slate-300 hover:text-white transition-colors font-medium">Home</a>
                    <a href="/plans" class="text-slate-300 hover:text-white transition-colors font-medium">VPS & RDP</a>
                    <a href="#" class="text-slate-300 hover:text-white transition-colors font-medium">Features</a>
                    <a href="/customer" class="text-slate-300 hover:text-white transition-colors font-medium">Support</a>
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="/customer" class="text-slate-300 hover:text-white transition-colors font-medium">Client Area</a>
                    @else
                        <a href="/customer/login" class="text-slate-300 hover:text-white transition-colors font-medium">Login</a>
                        <a href="/customer/register" class="bg-primary-500 hover:bg-primary-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all shadow-lg shadow-primary-500/30">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pt-20">
        {{ $slot }}
    </main>

    <footer class="bg-dark-900 border-t border-white/10 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500">
            <p>&copy; {{ date('Y') }} VortexCloud. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
