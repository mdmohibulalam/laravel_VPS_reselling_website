<?php

namespace App\Filament\Customer\Resources\SupportTickets\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SupportTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('formatted_id')
                    ->label('Ticket ID')
                    ->weight('bold')
                    ->color('primary')
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('id', $direction);
                    }),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->weight('medium')
                    ->limit(45),

                TextColumn::make('service.server_name')
                    ->label('Server')
                    ->placeholder('General')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('department')
                    ->label('Department')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'technical' => 'Technical',
                        'billing' => 'Billing',
                        'sales' => 'Sales',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'technical' => 'info',
                        'billing' => 'primary',
                        'sales' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'warning',
                        'high' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'warning',
                        'in_progress' => 'info',
                        'answered' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'open' => 'OPEN',
                        'in_progress' => 'IN PROGRESS',
                        'answered' => 'ANSWERED',
                        'closed' => 'CLOSED',
                        default => strtoupper($state),
                    }),

                TextColumn::make('updated_at')
                    ->label('Last Activity')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
