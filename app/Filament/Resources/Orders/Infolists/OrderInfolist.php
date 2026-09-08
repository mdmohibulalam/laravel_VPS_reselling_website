<?php

namespace App\Filament\Resources\Orders\Infolists;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Summary')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('order_number')
                                    ->label('Order Reference')
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('user.name')
                                    ->label('Customer Name')
                                    ->icon('heroicon-o-user'),
                                TextEntry::make('user.email')
                                    ->label('Customer Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),
                                TextEntry::make('created_at')
                                    ->label('Order Placed At')
                                    ->dateTime()
                                    ->icon('heroicon-o-calendar-days'),
                                TextEntry::make('total_amount')
                                    ->label('Total Amount')
                                    ->money('USD')
                                    ->color('success')
                                    ->weight('bold')
                                    ->icon('heroicon-o-currency-dollar'),
                                TextEntry::make('status')
                                    ->label('Order Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'contabo_ok' => 'info',
                                        'payment_confirmed' => 'warning',
                                        'provision' => 'warning',
                                        'pending' => 'gray',
                                        'failed', 'cancelled' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'pending' => 'Pending (Unpaid)',
                                        'payment_confirmed' => 'Payment Confirmed (Ready to Deploy)',
                                        'provision' => 'Provisioning (Paid)',
                                        'contabo_ok' => 'Contabo OK (Ready to Deliver)',
                                        'active' => 'Active / Delivered',
                                        'failed' => 'Provisioning Failed',
                                        'cancelled' => 'Cancelled',
                                        default => ucwords(str_replace('_', ' ', $state)),
                                    }),
                            ]),
                    ]),

                Section::make('Provisioned Service Details')
                    ->description('Associated server and instance information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('services.package.name')
                                    ->label('Package / Plan')
                                    ->placeholder('No Service Attached')
                                    ->badge()
                                    ->color('primary'),
                                TextEntry::make('services.ip_address')
                                    ->label('Primary IP Address')
                                    ->placeholder('Pending IP Assignment')
                                    ->copyable()
                                    ->icon('heroicon-o-globe-alt')
                                    ->color(fn ($state) => $state === 'Pending IP' ? 'warning' : 'success'),
                                TextEntry::make('services.contabo_instance_id')
                                    ->label('Contabo Instance ID')
                                    ->placeholder('Pending Provisioning')
                                    ->copyable()
                                    ->icon('heroicon-o-server')
                                    ->color(fn ($state) => empty($state) ? 'gray' : 'info'),
                            ]),
                    ])
                    ->collapsed(false),

                Section::make('Server Specifications & Credentials')
                    ->schema([
                        Grid::make(4)->schema([
                            TextEntry::make('specs_cpu')
                                ->label('CPU Cores')
                                ->icon('heroicon-o-cpu-chip')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->package->specs['cpu'] ?? 'N/A'),
                            TextEntry::make('specs_ram')
                                ->label('RAM')
                                ->icon('heroicon-o-server')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->package->specs['ram'] ?? 'N/A'),
                            TextEntry::make('specs_disk')
                                ->label('Storage')
                                ->icon('heroicon-o-circle-stack')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->package->specs['disk'] ?? 'N/A'),
                            TextEntry::make('specs_bandwidth')
                                ->label('Bandwidth')
                                ->icon('heroicon-o-arrows-right-left')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->package->specs['bandwidth'] ?? 'N/A'),
                        ]),
                        Grid::make(3)->schema([
                            TextEntry::make('root_user')
                                ->label('Root Username')
                                ->icon('heroicon-o-user')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->default_user ?? 'root')
                                ->copyable(),
                            TextEntry::make('root_pass')
                                ->label('Root Password')
                                ->icon('heroicon-o-key')
                                ->state(fn (\App\Models\Order $record) => $record->services->first()?->decrypted_password ?? 'N/A')
                                ->copyable()
                                ->formatStateUsing(fn ($state) => $state !== 'N/A' ? '******** (Click to Copy)' : 'Pending Provisioning'),
                        ]),
                    ]),

                Section::make('VPS Control Panel')
                    ->description('Manage your server power state directly via Contabo API')
                    ->visible(fn (\App\Models\Order $record) => $record->status === 'contabo_ok' || $record->status === 'active')
                    ->schema([
                        \Filament\Schemas\Components\Actions::make([
                            \Filament\Actions\Action::make('start')
                                ->label('Start Server')
                                ->icon('heroicon-o-play')
                                ->color('success')
                                ->requiresConfirmation()
                                ->action(function (\App\Models\Order $record, \App\Services\Provisioning\ProvisioningServiceInterface $provisioningService) {
                                    $service = $record->services->first();
                                    $result = $provisioningService->startInstance($service->contabo_instance_id);
                                    if ($result->success) {
                                        \Filament\Notifications\Notification::make()->title('Server Starting')->success()->send();
                                    } else {
                                        \Filament\Notifications\Notification::make()->title('Error')->body($result->message)->danger()->send();
                                    }
                                }),
                            
                            \Filament\Actions\Action::make('restart')
                                ->label('Restart')
                                ->icon('heroicon-o-arrow-path')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->action(function (\App\Models\Order $record, \App\Services\Provisioning\ProvisioningServiceInterface $provisioningService) {
                                    $service = $record->services->first();
                                    $result = $provisioningService->rebootInstance($service->contabo_instance_id);
                                    if ($result->success) {
                                        \Filament\Notifications\Notification::make()->title('Server Restarting')->success()->send();
                                    } else {
                                        \Filament\Notifications\Notification::make()->title('Error')->body($result->message)->danger()->send();
                                    }
                                }),
                                
                            \Filament\Actions\Action::make('stop')
                                ->label('Force Stop')
                                ->icon('heroicon-o-stop')
                                ->color('danger')
                                ->requiresConfirmation()
                                ->action(function (\App\Models\Order $record, \App\Services\Provisioning\ProvisioningServiceInterface $provisioningService) {
                                    $service = $record->services->first();
                                    $result = $provisioningService->stopInstance($service->contabo_instance_id);
                                    if ($result->success) {
                                        \Filament\Notifications\Notification::make()->title('Server Stopped')->success()->send();
                                    } else {
                                        \Filament\Notifications\Notification::make()->title('Error')->body($result->message)->danger()->send();
                                    }
                                }),
                        ])->fullWidth(),
                    ]),

                Section::make('Invoice & Billing Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('invoice.invoice_number')
                                    ->label('Invoice #')
                                    ->placeholder('No Invoice Attached')
                                    ->icon('heroicon-o-document-text')
                                    ->badge()
                                    ->color('primary')
                                    ->suffixAction(
                                        \Filament\Actions\Action::make('view_invoice')
                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                            ->tooltip('View Invoice Details')
                                            ->visible(fn ($record) => !empty($record->invoice))
                                            ->url(fn ($record) => \App\Filament\Resources\Invoices\InvoiceResource::getUrl('view', ['record' => $record->invoice->id]))
                                    ),
                                TextEntry::make('invoice.status')
                                    ->label('Invoice Status')
                                    ->badge()
                                    ->placeholder('N/A')
                                    ->color(fn (?string $state): string => match ($state) {
                                        'paid' => 'success',
                                        'pending', 'unpaid' => 'warning',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('invoice.paid_at')
                                    ->label('Paid At')
                                    ->dateTime()
                                    ->placeholder('Not Paid')
                                    ->icon('heroicon-o-banknotes'),
                                TextEntry::make('invoice.crypto_txid')
                                    ->label('Crypto TxID Proof')
                                    ->placeholder('N/A')
                                    ->copyable()
                                    ->limit(18)
                                    ->visible(fn ($record) => !empty($record->invoice?->crypto_txid))
                                    ->suffixAction(
                                        \Filament\Actions\Action::make('open_explorer_order')
                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                            ->tooltip('Open on Blockchain Explorer')
                                            ->visible(fn ($record) => !empty($record->invoice?->crypto_txid))
                                            ->url(fn ($record) => (str_starts_with($record->invoice->crypto_txid ?? '', '0x') || str_contains($record->invoice->crypto_network ?? '', 'polygon'))
                                                ? "https://polygonscan.com/tx/{$record->invoice->crypto_txid}"
                                                : "https://tronscan.org/#/transaction/{$record->invoice->crypto_txid}", true)
                                    ),
                            ]),
                    ])
                    ->collapsed(false),
            ]);
    }
}
