<x-filament-widgets::widget class="fi-customer-quick-actions-widget">
    <x-filament::section>
        <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; min-height: 48px;">
            {{-- Left Info Block --}}
            <div style="display: flex; align-items: center; gap: 0.875rem;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #673DE6, #4f46e5); display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; box-shadow: 0 4px 12px rgba(103, 61, 230, 0.3);">
                    <x-filament::icon
                        icon="heroicon-o-server-stack"
                        style="width: 22px; height: 22px; color: white;"
                    />
                </div>
                <div>
                    <h3 style="font-size: 0.875rem; font-weight: 700; margin: 0; line-height: 1.25;" class="text-gray-950 dark:text-white">
                        VortexCloud Infrastructure
                    </h3>
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                        <span style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.75rem; font-weight: 600; color: #10b981;">
                            <span style="display: inline-block; width: 7px; height: 7px; border-radius: 50%; background-color: #10b981;"></span>
                            99.99% Operational
                        </span>
                        <span style="font-size: 0.75rem;" class="text-gray-400 dark:text-gray-500">•</span>
                        <span style="font-size: 0.75rem;" class="text-gray-500 dark:text-gray-400">
                            US, EU, UK, SG Online
                        </span>
                    </div>
                </div>
            </div>

            {{-- Right Quick Triggers --}}
            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                <x-filament::button
                    tag="a"
                    href="{{ url('/plans') }}"
                    target="_blank"
                    icon="heroicon-m-plus"
                    size="sm"
                    color="primary"
                >
                    Deploy Cloud VPS
                </x-filament::button>

                <x-filament::button
                    tag="a"
                    href="{{ \App\Filament\Customer\Resources\SupportTickets\SupportTicketResource::getUrl('create') }}"
                    icon="heroicon-m-chat-bubble-left-right"
                    size="sm"
                    color="gray"
                >
                    Get Help
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
