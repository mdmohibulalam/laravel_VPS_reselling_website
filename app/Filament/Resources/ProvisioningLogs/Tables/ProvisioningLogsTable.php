<?php

namespace App\Filament\Resources\ProvisioningLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProvisioningLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('action')
                    ->label('API Action')
                    ->searchable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('service.server_name')
                    ->label('Service')
                    ->searchable()
                    ->placeholder('N/A'),
                IconColumn::make('is_success')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_success')
                    ->label('API Status')
                    ->placeholder('All Logs')
                    ->trueLabel('Successful Requests')
                    ->falseLabel('Failed Requests / Errors'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('View Details')
                    ->modalWidth('7xl'),
            ])
            ->bulkActions([
                // Read-only logs
            ]);
    }
}
