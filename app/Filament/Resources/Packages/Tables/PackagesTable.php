<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vps' => 'info',
                        'rdp' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('specs.cores')
                    ->label('Cores')
                    ->placeholder('N/A'),
                TextColumn::make('specs.memory')
                    ->label('RAM')
                    ->placeholder('N/A'),
                TextColumn::make('specs.storage')
                    ->label('Storage')
                    ->placeholder('N/A'),
                TextColumn::make('price_monthly')
                    ->label('Monthly')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('setup_fee')
                    ->label('Setup Fee')
                    ->money('USD')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('contabo_product_id')
                    ->label('Contabo ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
