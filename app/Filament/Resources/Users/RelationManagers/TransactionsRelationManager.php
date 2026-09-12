<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    protected static ?string $title = 'Transactions';

    protected static string | \BackedEnum | null $icon = 'heroicon-o-credit-card';

    public static function getBadge(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): ?string
    {
        $count = $ownerRecord->invoices()
            ->where(fn (Builder $q) => $q->whereNotNull('crypto_txid')->orWhereNotNull('stripe_payment_intent_id')->orWhere('status', 'paid'))
            ->count();
        return $count > 0 ? (string) $count : null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->modifyQueryUsing(fn (Builder $query) => $query->where(fn (Builder $q) => $q->whereNotNull('crypto_txid')->orWhereNotNull('stripe_payment_intent_id')->orWhere('status', 'paid')))
            ->recordTitleAttribute('invoice_number')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('transaction_ref')
                    ->label('Transaction ID / Hash')
                    ->state(fn (Invoice $record) => $record->crypto_txid ?: ($record->stripe_payment_intent_id ?: "INV-PAY-{$record->id}"))
                    ->copyable()
                    ->limit(20)
                    ->weight('bold')
                    ->tooltip(fn (Invoice $record) => $record->crypto_txid ?: $record->stripe_payment_intent_id)
                    ->suffixAction(
                        Action::make('explorer')
                            ->icon('heroicon-m-arrow-top-right-on-square')
                            ->tooltip('Verify on Blockchain Explorer')
                            ->visible(fn (Invoice $record) => !empty($record->crypto_txid))
                            ->url(fn (Invoice $record) => (str_starts_with($record->crypto_txid ?? '', '0x') || str_contains($record->crypto_network ?? '', 'polygon'))
                                ? "https://polygonscan.com/tx/{$record->crypto_txid}"
                                : "https://tronscan.org/#/transaction/{$record->crypto_txid}", true)
                    ),
                TextColumn::make('paid_at')
                    ->label('Date & Time')
                    ->dateTime('M d, Y H:i:s')
                    ->placeholder(fn (Invoice $record) => $record->created_at?->format('M d, Y H:i:s') ?? '-'),
                TextColumn::make('invoice_number')
                    ->label('Invoice #')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('payment_method')
                    ->label('Gateway')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'crypto' => 'info',
                        'stripe' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(function (Invoice $record): string {
                        $method = strtoupper($record->payment_method ?? 'PAYMENT');
                        if ($record->crypto_network) {
                            $net = match ($record->crypto_network) {
                                'usdt_trc20' => 'USDT (Tron)',
                                'usdc_polygon' => 'USDC (Polygon)',
                                'usdt_polygon' => 'USDT (Polygon)',
                                default => strtoupper($record->crypto_network),
                            };
                            return "{$method} - {$net}";
                        }
                        return $method;
                    }),
                TextColumn::make('total')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending', 'unpaid' => 'warning',
                        'refunded' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
