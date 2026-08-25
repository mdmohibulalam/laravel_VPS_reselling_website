<?php

namespace App\Filament\Customer\Resources\Services\Tables;

use App\Models\Service;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('package.name')
                    ->label('Product / Service')
                    ->badge()
                    ->color('primary')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('Primary IP Address')
                    ->searchable()
                    ->placeholder('Pending Provisioning')
                    ->copyable()
                    ->weight('semibold'),
                TextColumn::make('server_name')
                    ->label('Hostname / Server')
                    ->placeholder('VPS Server')
                    ->searchable(),
                TextColumn::make('region')
                    ->label('Region')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => strtoupper($state ?? 'EU')),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'provisioned' => 'info',
                        'awaiting_provisioning' => 'warning',
                        'suspended' => 'danger',
                        'terminated' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'awaiting_provisioning' => 'Awaiting Setup',
                        'provisioned' => 'Ready / Active',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'terminated' => 'Terminated',
                        default => ucfirst($state),
                    }),
                TextColumn::make('next_due_date')
                    ->label('Next Due Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Manage VPS')
                    ->icon('heroicon-o-computer-desktop')
                    ->color('primary')
                    ->button(),
            ]);
    }
}
