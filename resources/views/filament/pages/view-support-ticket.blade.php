<x-filament-panels::page>
    @php
        $ticket = $this->record;
        $replies = $ticket->replies()->with(['user', 'admin'])->oldest()->get();
        $user = $ticket->user;
        $service = $ticket->service;
        $isAdmin = request()->is('admin*');
        $isClosed = $ticket->status === 'closed';
    @endphp

    <div class="space-y-6">
        <!-- 1. TICKET METADATA CARD -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 border-b border-slate-100 pb-6 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-purple-50 text-[#673DE6] border border-purple-200">
                            {{ $ticket->formatted_id }}
                        </span>
                        
                        @if($ticket->status === 'open')
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-50 text-amber-700 border border-amber-200">
                                🟡 Open
                            </span>
                        @elseif($ticket->status === 'in_progress')
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-blue-50 text-blue-700 border border-blue-200">
                                🔵 In Progress
                            </span>
                        @elseif($ticket->status === 'answered')
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">
                                🟢 Answered
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-100 text-slate-600 border border-slate-200">
                                ⚪ Closed
                            </span>
                        @endif

                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                            {{ $ticket->priority === 'high' ? 'bg-red-50 text-red-700 border border-red-200' : ($ticket->priority === 'medium' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-600 border border-slate-200') }}">
                            {{ strtoupper($ticket->priority) }} Priority
                        </span>
                    </div>

                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        {{ $ticket->subject }}
                    </h1>
                </div>

                <div class="text-xs sm:text-sm text-slate-500 space-y-1 lg:text-right">
                    <div><strong>Opened:</strong> {{ $ticket->created_at->format('M d, Y · H:i T') }}</div>
                    <div><strong>Last Activity:</strong> {{ $ticket->updated_at->diffForHumans() }}</div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <span class="text-xs text-slate-500 font-medium block mb-1">Department</span>
                    <span class="font-semibold text-slate-800 flex items-center gap-1.5">
                        @if($ticket->department === 'technical')
                            🛠️ Technical Support
                        @elseif($ticket->department === 'billing')
                            💳 Billing & Payments
                        @else
                            💼 Sales & Upgrades
                        @endif
                    </span>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <span class="text-xs text-slate-500 font-medium block mb-1">Associated Server</span>
                    @if($service)
                        <span class="font-semibold text-[#673DE6] block truncate">
                            {{ $service->server_name ?: ('VPS #' . $service->id) }}
                        </span>
                        <span class="text-xs text-slate-500 font-mono">{{ $service->ip_address ?: 'Pending IP' }}</span>
                    @else
                        <span class="font-semibold text-slate-600">General / None</span>
                    @endif
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <span class="text-xs text-slate-500 font-medium block mb-1">Client Account</span>
                    <span class="font-semibold text-slate-800 block truncate">{{ $user?->name ?? 'Customer' }}</span>
                    <span class="text-xs text-slate-500 block truncate">{{ $user?->email ?? '' }}</span>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <span class="text-xs text-slate-500 font-medium block mb-1">Total Replies</span>
                    <span class="font-extrabold text-slate-900 text-base">{{ $replies->count() }}</span>
                    <span class="text-xs text-slate-500 block">Messages in thread</span>
                </div>
            </div>
        </div>

        <!-- 2. CONVERSATION THREAD -->
        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>💬 Conversation History</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-200 text-slate-700">
                        {{ $replies->count() }}
                    </span>
                </h2>
            </div>

            @forelse($replies as $reply)
                @php
                    $isStaff = $reply->is_staff_reply;
                @endphp

                <div class="rounded-2xl border transition-all duration-200 overflow-hidden shadow-sm
                    {{ $isStaff 
                        ? 'bg-gradient-to-br from-purple-50/50 via-white to-white border-purple-200 border-l-[6px] border-l-[#673DE6]' 
                        : 'bg-white border-slate-200 border-l-[6px] border-l-slate-400' }}">
                    
                    <!-- Message Header -->
                    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-3 border-b {{ $isStaff ? 'border-purple-100/80 bg-purple-50/40' : 'border-slate-100 bg-slate-50/60' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm shadow-sm
                                {{ $isStaff ? 'bg-[#673DE6] text-white shadow-purple-200' : 'bg-slate-700 text-white shadow-slate-200' }}">
                                {{ strtoupper(substr($isStaff ? ($reply->admin?->name ?? 'Staff') : ($reply->user?->name ?? 'User'), 0, 1)) }}
                            </div>

                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900 text-sm">
                                        {{ $isStaff ? ($reply->admin?->name ?? 'Support Staff') : ($reply->user?->name ?? 'Customer') }}
                                    </span>

                                    @if($isStaff)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#673DE6] text-white shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd"/>
                                            </svg>
                                            Official Support
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-200 text-slate-700">
                                            Client
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-xs text-slate-500 font-mono">
                            {{ $reply->created_at->format('M d, Y · H:i T') }} ({{ $reply->created_at->diffForHumans() }})
                        </div>
                    </div>

                    <!-- Message Body -->
                    <div class="p-6 text-slate-800 text-sm sm:text-base leading-relaxed whitespace-pre-wrap font-normal">
                        {!! nl2br(e($reply->message)) !!}
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 text-slate-500">
                    <p class="text-sm">No messages in this ticket yet.</p>
                </div>
            @endforelse
        </div>

        <!-- 3. BOTTOM HELPER BANNER -->
        @if($isClosed)
            <div class="bg-slate-100 border border-slate-300 rounded-2xl p-6 text-center text-slate-600">
                <p class="text-sm font-semibold">
                    🔒 This support ticket is currently marked as <strong>Closed</strong>.
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    If you require further assistance on this issue, you can reopen it using the header action above.
                </p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
