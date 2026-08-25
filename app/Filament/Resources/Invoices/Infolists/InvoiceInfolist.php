<?php

namespace App\Filament\Resources\Invoices\Infolists;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('invoice_number')
                                    ->label('Invoice #')
                                    ->weight('bold')
                                    ->copyable()
                                    ->icon('heroicon-o-document-text'),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'paid' => 'success',
                                        'pending', 'unpaid' => 'warning',
                                        'refunded' => 'info',
                                        'cancelled' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'pending', 'unpaid' => 'Pending (Unpaid)',
                                        'paid' => 'Paid',
                                        'refunded' => 'Refunded',
                                        'cancelled' => 'Cancelled',
                                        default => ucfirst($state),
                                    }),
                                TextEntry::make('created_at')
                                    ->label('Invoice Date')
                                    ->dateTime()
                                    ->icon('heroicon-o-calendar-days'),
                                TextEntry::make('due_date')
                                    ->label('Due Date')
                                    ->date()
                                    ->icon('heroicon-o-calendar'),
                                TextEntry::make('paid_at')
                                    ->label('Paid At')
                                    ->dateTime()
                                    ->placeholder('Not Paid')
                                    ->icon('heroicon-o-banknotes'),
                            ]),
                    ]),

                Section::make('Customer Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->label('Customer Name')
                                    ->icon('heroicon-o-user'),
                                TextEntry::make('user.email')
                                    ->label('Customer Email')
                                    ->icon('heroicon-o-envelope')
                                    ->copyable(),
                            ]),
                    ]),

                Section::make('Financial Summary')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('amount')
                                    ->label('Subtotal')
                                    ->money('USD'),
                                TextEntry::make('tax')
                                    ->label('Tax')
                                    ->money('USD'),
                                TextEntry::make('total')
                                    ->label('Total Amount')
                                    ->weight('bold')
                                    ->color('success')
                                    ->money('USD')
                                    ->icon('heroicon-o-currency-dollar'),
                                TextEntry::make('stripe_payment_intent_id')
                                    ->label('Stripe Payment ID')
                                    ->placeholder('N/A')
                                    ->copyable()
                                    ->icon('heroicon-o-credit-card'),
                            ]),
                    ]),
            ]);
    }
}
