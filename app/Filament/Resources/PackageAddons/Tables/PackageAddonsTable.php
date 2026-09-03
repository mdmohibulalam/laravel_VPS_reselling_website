<?php

namespace App\Filament\Resources\PackageAddons\Tables;

use App\Models\PackageAddon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class PackageAddonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->colors([
                        'primary' => 'os',
                        'success' => 'region',
                        'warning' => 'storage',
                        'info' => 'backup',
                        'danger' => 'network',
                    ])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Addon Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('package.name')
                    ->label('Scope / Target Tier')
                    ->placeholder('All Packages (Global Base)')
                    ->badge()
                    ->color(fn($state) => $state ? 'purple' : 'gray')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('api_identifier')
                    ->label('Contabo API Slug')
                    ->fontFamily('mono')
                    ->copyable()
                    ->placeholder('None')
                    ->toggleable(),
                TextColumn::make('price')
                    ->label('Retail Price')
                    ->money('USD')
                    ->sortable(),
                IconColumn::make('is_enabled')
                    ->label('Enabled')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                IconColumn::make('is_out_of_stock')
                    ->label('Sold Out')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray'),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'os' => 'Operating System (OS)',
                        'region' => 'Datacenter Region',
                        'storage' => 'NVMe Storage',
                        'backup' => 'Backups',
                        'network' => 'Private Networking',
                    ]),
                SelectFilter::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name'),
                TernaryFilter::make('is_global')
                    ->label('Global Base vs Override'),
                TernaryFilter::make('is_out_of_stock')
                    ->label('Out of Stock Status'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup('type')
            ->groups([
                Group::make('type')
                    ->label('Category')
                    ->getTitleFromRecordUsing(fn (PackageAddon $record): string => match ($record->type) {
                        'os' => '🐧 Operating Systems (OS)',
                        'region' => '🌐 Datacenter Regions',
                        'storage' => '💾 Primary NVMe Storage Tiers',
                        'backup' => '🛡️ Data Protection & Backups',
                        'network' => '🔒 Private Networking VPC',
                        default => '⚡ Additional Features & Addons',
                    })
                    ->collapsible(),
            ]);
    }
}
