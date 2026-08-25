<x-app-layout>
<div class="relative">
    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl sm:text-7xl font-display font-extrabold tracking-tight text-white mb-8">
                Next-Gen Cloud <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">Infrastructure</span>
            </h1>
            <p class="mt-4 text-xl sm:text-2xl text-slate-400 max-w-3xl mx-auto mb-10 font-light">
                High-performance VPS and RDP instances powered by NVMe SSDs and AMD EPYC processors. Instant provisioning, 99.99% uptime.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/plans" class="bg-primary-600 hover:bg-primary-500 text-white px-8 py-4 rounded-xl font-medium text-lg transition-all shadow-lg shadow-primary-500/25">
                    View Pricing
                </a>
                <a href="#features" class="glass-dark hover:bg-white/5 text-white px-8 py-4 rounded-xl font-medium text-lg transition-all">
                    Explore Features
                </a>
            </div>
        </div>
        
        <!-- Abstract Background -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -z-10 w-[800px] h-[800px] opacity-30 pointer-events-none">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-500 to-indigo-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
        </div>
    </div>

    <!-- Features -->
    <div id="features" class="py-24 bg-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-dark p-8 rounded-3xl border border-white/5">
                    <div class="w-14 h-14 bg-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Instant Setup</h3>
                    <p class="text-slate-400">Your VPS is provisioned and ready to use in less than 60 seconds after payment confirmation.</p>
                </div>
                
                <div class="glass-dark p-8 rounded-3xl border border-white/5">
                    <div class="w-14 h-14 bg-indigo-500/20 text-indigo-400 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">DDoS Protection</h3>
                    <p class="text-slate-400">Enterprise-grade DDoS mitigation included free with all plans to keep your services online.</p>
                </div>

                <div class="glass-dark p-8 rounded-3xl border border-white/5">
                    <div class="w-14 h-14 bg-purple-500/20 text-purple-400 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">NVMe Storage</h3>
                    <p class="text-slate-400">Lightning fast NVMe SSD storage in RAID 10 configuration for maximum I/O performance.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
