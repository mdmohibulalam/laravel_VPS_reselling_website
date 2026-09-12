<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Services\ServiceResource;
use App\Models\Service;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'services';

    protected static ?string $title = 'VPS Services';

    protected static string | \BackedEnum | null $icon = 'heroicon-o-server-stack';

    public static function getBadge(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): ?string
    {
        $count = $ownerRecord->services()->count();
        return $count > 0 ? (string) $count : null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->recordTitleAttribute('server_name')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('formatted_hostname')
                    ->label('Server / Hostname')
                    ->weight('bold')
                    ->copyable()
                    ->searchable(['server_name']),
                TextColumn::make('package.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->placeholder('Pending Assignment')
                    ->copyable()
                    ->icon('heroicon-o-globe-alt')
                    ->color(fn ($state) => empty($state) || $state === 'Pending IP' ? 'warning' : 'success'),
                TextColumn::make('region')
                    ->label('Region')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (?string $state): string => strtoupper($state ?? 'EU')),
                TextColumn::make('billing_cycle')
                    ->label('Billing Cycle')
                    ->formatStateUsing(fn (?string $state): string => ucfirst($state ?? 'Monthly')),
                TextColumn::make('recurring_amount')
                    ->label('Price')
                    ->money('USD'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active', 'contabo_ok', 'provisioned' => 'success',
                        'provisioning', 'awaiting_provisioning', 'ready_for_provisioning' => 'warning',
                        'suspended', 'cancelled', 'terminated' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state))),
                TextColumn::make('next_due_date')
                    ->label('Next Due Date')
                    ->date('M d, Y')
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'provisioning' => 'Provisioning',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Service $record): string => ServiceResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
