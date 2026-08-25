<x-app-layout>
    <div class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl sm:text-5xl font-display font-bold text-white mb-6">VPS & RDP Packages</h1>
                <p class="text-xl text-slate-400">High-performance infrastructure tailored to your needs.</p>
            </div>

            @php
                $packages = \App\Models\Package::where('is_active', true)->orderBy('price_monthly')->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($packages as $package)
                    @php $specs = is_string($package->specs) ? json_decode($package->specs, true) : $package->specs; @endphp
                    <div class="glass-dark p-8 rounded-3xl border {{ $loop->iteration == 2 ? 'border-primary-500 shadow-xl shadow-primary-500/20 scale-105 transform z-10' : 'border-white/5' }} flex flex-col relative overflow-hidden">
                        @if($loop->iteration == 2)
                            <div class="absolute top-0 right-0 bg-gradient-to-r from-primary-500 to-indigo-600 text-white text-xs font-bold uppercase tracking-wider py-1 px-3 rounded-bl-lg">
                                Most Popular
                            </div>
                        @endif
                        
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $package->name }}</h3>
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-4xl font-extrabold text-white">${{ number_format($package->price_monthly, 2) }}</span>
                            <span class="text-slate-400">/mo</span>
                        </div>
                        
                        <div class="flex-grow">
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-center text-slate-300">
                                    <svg class="w-5 h-5 text-primary-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $specs['cores'] ?? 'N/A' }} vCPU Cores
                                </li>
                                <li class="flex items-center text-slate-300">
                                    <svg class="w-5 h-5 text-primary-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $specs['memory'] ?? 'N/A' }} RAM
                                </li>
                                <li class="flex items-center text-slate-300">
                                    <svg class="w-5 h-5 text-primary-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ $specs['storage'] ?? 'N/A' }} Storage
                                </li>
                                <li class="flex items-center text-slate-300">
                                    <svg class="w-5 h-5 text-primary-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    {{ strtolower($package->category) === 'rdp' ? 'Windows OS (RDP)' : 'Linux OS' }}
                                </li>
                            </ul>
                        </div>
                        
                        <a href="/checkout/{{ $package->id }}" class="block w-full text-center {{ $loop->iteration == 2 ? 'bg-primary-500 hover:bg-primary-600 text-white' : 'glass hover:bg-white/10 text-white' }} py-4 rounded-xl font-medium transition-all">
                            Configure & Order
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
