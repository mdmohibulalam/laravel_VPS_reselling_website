<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn (Order $record) => $record->user->email ?? ''),
                TextColumn::make('invoice.invoice_number')
                    ->label('Invoice #')
                    ->searchable()
                    ->placeholder('N/A')
                    ->sortable(),
                TextColumn::make('services.package.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('services.ip_address')
                    ->label('Server IP')
                    ->placeholder('Pending Provisioning')
                    ->copyable()
                    ->copyMessage('IP copied to clipboard'),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
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
                TextColumn::make('created_at')
                    ->label('Placed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
