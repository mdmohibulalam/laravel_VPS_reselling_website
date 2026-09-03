<x-filament-panels::page>
    @php
        $service = $this->record;
        $package = $service->package;
        $specs = $service->specs_snapshot ?? (is_string($package->specs ?? null) ? json_decode($package->specs, true) : ($package->specs ?? []));
        $activeAddons = $service->active_addons ?? [];
        $password = $service->decrypted_password ?? 'Not Available';
        $user = $service->default_user ?? 'root';
        $status = strtolower($this->liveStatus ?? $service->status ?? 'unknown');
        $isRdp = strtolower($package->category ?? '') === 'rdp';
        $port = $isRdp ? 3389 : 22;
        $recurringPrice = (float)($service->recurring_amount > 0 ? $service->recurring_amount : ($package->price_monthly ?? 0));
    @endphp

    <div class="space-y-6" x-data="{ showPassword: false, copied: false, copyText(text) { navigator.clipboard.writeText(text); this.copied = true; setTimeout(() => this.copied = false, 2000); } }">
        
        <!-- Live Status Hero Banner -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border border-slate-700/60 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-inner {{ in_array($status, ['running', 'active', 'ok']) ? 'bg-emerald-500/20 border border-emerald-500/40 text-emerald-400' : (in_array($status, ['stopped', 'suspended']) ? 'bg-red-500/20 border border-red-500/40 text-red-400' : 'bg-amber-500/20 border border-amber-500/40 text-amber-400') }}">
                    @if(in_array($status, ['running', 'active', 'ok']))
                        <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    @elseif(in_array($status, ['stopped', 'suspended']))
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @else
                        <svg class="w-8 h-8 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-white tracking-tight">{{ $service->server_name ?? ($package->name ?? 'Virtual Private Server') }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ in_array($status, ['running', 'active', 'ok']) ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : (in_array($status, ['stopped', 'suspended']) ? 'bg-red-500/10 text-red-400 border border-red-500/30' : 'bg-amber-500/10 text-amber-400 border border-amber-500/30') }}">
                            <span class="w-2 h-2 mr-1.5 rounded-full {{ in_array($status, ['running', 'active', 'ok']) ? 'bg-emerald-400 animate-ping' : (in_array($status, ['stopped', 'suspended']) ? 'bg-red-400' : 'bg-amber-400 animate-pulse') }}"></span>
                            {{ strtoupper($this->liveStatus ?? $service->status) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-400 mt-1">
                        Contabo Instance ID: <span class="font-mono text-slate-300 font-semibold">{{ $service->contabo_instance_id ?? 'Pending Provisioning' }}</span> &bull; Region: <span class="text-slate-300 font-semibold">{{ $service->region ?? 'EU' }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="bg-slate-950/80 px-4 py-2.5 rounded-xl border border-slate-700/70 flex items-center gap-3">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Primary IPv4:</span>
                    <span class="font-mono text-base font-bold text-sky-400">{{ $service->ip_address ?? 'Pending Assignment' }}</span>
                    @if(!empty($service->ip_address) && $service->ip_address !== 'Pending Assignment')
                        <button @click="copyText('{{ $service->ip_address }}')" type="button" class="text-slate-400 hover:text-white transition-colors" title="Copy IP">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2-Column Grid: Connection Details & Hardware Specs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card 1: Connection & Credentials (WHMCS Standard) -->
            <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Access & Login Credentials</h3>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded bg-slate-800 text-slate-300 border border-slate-700">
                            {{ $isRdp ? 'RDP Access' : 'SSH Access' }}
                        </span>
                    </div>

                    <div class="space-y-3.5">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/60 border border-slate-800">
                            <span class="text-sm text-slate-400 font-medium">Server IP Address</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm font-bold text-white">{{ $service->ip_address ?? 'N/A' }}</span>
                                <button @click="copyText('{{ $service->ip_address }}')" type="button" class="p-1 text-slate-400 hover:text-white" title="Copy">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/60 border border-slate-800">
                            <span class="text-sm text-slate-400 font-medium">Username</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm font-bold text-white">{{ $user }}</span>
                                <button @click="copyText('{{ $user }}')" type="button" class="p-1 text-slate-400 hover:text-white" title="Copy">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/60 border border-slate-800">
                            <span class="text-sm text-slate-400 font-medium">Root / Admin Password</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm font-bold text-amber-400" x-text="showPassword ? '{{ $password }}' : '••••••••••••••••'"></span>
                                <button @click="showPassword = !showPassword" type="button" class="p-1 text-slate-400 hover:text-white" title="Toggle Visibility">
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                </button>
                                <button @click="copyText('{{ $password }}')" type="button" class="p-1 text-slate-400 hover:text-white" title="Copy Password">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-950/60 border border-slate-800">
                            <span class="text-sm text-slate-400 font-medium">Default Port</span>
                            <span class="font-mono text-sm font-bold text-white">{{ $port }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Connect Shell Snippet -->
                <div class="mt-4 pt-3 border-t border-slate-800">
                    <p class="text-xs font-semibold text-slate-400 mb-1.5 uppercase tracking-wider">Quick Terminal Connect:</p>
                    <div class="flex items-center justify-between p-2.5 rounded-lg bg-slate-950 border border-slate-800 font-mono text-xs text-emerald-400">
                        <span>ssh {{ $user }}@{{ $service->ip_address ?? '127.0.0.1' }}</span>
                        <button @click="copyText('ssh {{ $user }}@{{ $service->ip_address }}')" type="button" class="text-slate-400 hover:text-white ml-2" title="Copy Command">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2: Server Hardware Specifications -->
            <div class="p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-800">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-indigo-500/10 text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Hardware Resources</h3>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded bg-indigo-500/10 text-indigo-300 border border-indigo-500/30">
                            {{ $package->name ?? 'VPS Plan' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5">
                        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
                            <div class="text-xs text-slate-400 font-medium mb-1">CPU Cores</div>
                            <div class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                {{ $specs['cores'] ?? '4' }} vCPU
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
                            <div class="text-xs text-slate-400 font-medium mb-1">RAM Memory</div>
                            <div class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                {{ $specs['memory'] ?? '8 GB' }}
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
                            <div class="text-xs text-slate-400 font-medium mb-1">NVMe / SSD Disk</div>
                            <div class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3z"></path></svg>
                                {{ $specs['storage'] ?? '100 GB SSD' }}
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800">
                            <div class="text-xs text-slate-400 font-medium mb-1">Network Port</div>
                            <div class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                                {{ $specs['bandwidth'] ?? '200 Mbit/s' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating System & Datacenter Bar -->
                <div class="mt-4 pt-3 border-t border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between text-xs gap-2">
                    <div>
                        <span class="text-slate-400">Operating System:</span>
                        <span class="font-bold text-slate-200 ml-1">{{ $specs['os'] ?? ($service->os_image ?? 'Ubuntu 24.04 LTS') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Datacenter:</span>
                        <span class="font-bold text-slate-200 ml-1">{{ $specs['datacenter'] ?? ($service->region ?? 'EU Central') }}</span>
                    </div>
                </div>

                @if(!empty($activeAddons) && count($activeAddons) > 0)
                <!-- Active Cloud Add-Ons Section -->
                <div class="mt-3 pt-3 border-t border-slate-800">
                    <div class="text-xs text-slate-400 font-medium mb-2 uppercase tracking-wider">Active Cloud Add-Ons:</div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($activeAddons as $addon)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-300 border border-purple-500/30 shadow-sm">
                                <span class="text-purple-400 mr-1.5">✓</span> {{ $addon['name'] ?? 'Addon' }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Billing & Subscription Footer Row -->
        <div class="p-5 rounded-xl bg-slate-900/80 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <div class="flex flex-wrap items-center gap-6">
                <div>
                    <span class="text-slate-400">Billing Cycle:</span>
                    <span class="font-semibold text-white ml-1">{{ ucfirst($service->billing_cycle) }}</span>
                </div>
                <div>
                    <span class="text-slate-400">Renewal Rate:</span>
                    <span class="font-bold text-emerald-400 ml-1">${{ number_format($recurringPrice, 2) }}</span>
                </div>
                @if($service->next_due_date)
                    <div>
                        <span class="text-slate-400">Next Due Date:</span>
                        <span class="font-semibold text-white ml-1">{{ \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ url('/customer/invoices') }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition-colors">
                    View Invoices
                </a>
                <a href="{{ url('/customer/support-tickets/create') }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white transition-colors">
                    Open Support Ticket
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>
