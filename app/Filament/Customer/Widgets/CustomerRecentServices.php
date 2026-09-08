<?php

namespace App\Filament\Customer\Widgets;

use App\Filament\Customer\Resources\Services\ServiceResource;
use App\Models\Service;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CustomerRecentServices extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('My Cloud VPS Servers')
            ->description('Active cloud server instances provisioned on the high-speed NVMe infrastructure')
            ->query(
                Service::query()->where('user_id', auth()->id())->latest()
            )
            ->columns([
                TextColumn::make('package.name')
                    ->label('Cloud Plan')
                    ->badge()
                    ->color('primary')
                    ->weight('bold'),

                TextColumn::make('ip_address')
                    ->label('Dedicated IP')
                    ->copyable()
                    ->copyMessage('IP copied to clipboard')
                    ->placeholder('Pending Assignment')
                    ->weight('bold'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'contabo_ok' => 'info',
                        'awaiting_provisioning', 'provisioning' => 'warning',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Active',
                        'awaiting_provisioning' => 'Awaiting Provisioning',
                        'suspended' => 'Suspended',
                        default => ucfirst($state),
                    }),

                TextColumn::make('billing_cycle')
                    ->label('Billing Cycle')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('recurring_amount')
                    ->label('Renewal Rate')
                    ->money('USD'),

                TextColumn::make('next_due_date')
                    ->label('Next Renewal Date')
                    ->date()
                    ->placeholder('N/A'),
            ])
            ->recordActions([
                Action::make('manage')
                    ->label('Manage Server')
                    ->icon('heroicon-m-server')
                    ->button()
                    ->color('primary')
                    ->url(fn (Service $record): string => ServiceResource::getUrl('view', ['record' => $record])),
            ])
            ->paginated([5]);
    }
}
