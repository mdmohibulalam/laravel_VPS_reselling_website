<?php

namespace App\Filament\Resources\SupportTickets\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SupportTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Ticket #')
                    ->sortable()
                    ->weight('bold')
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Guest / Unknown')
                    ->toggleable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('department')
                    ->label('Department')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'urgent' => 'danger',
                        'high' => 'warning',
                        'medium' => 'info',
                        'low' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'success',
                        'replied' => 'info',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Opened At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Last Activity')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->columnToggleFormColumns(2)
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'replied' => 'Replied',
                        'closed' => 'Closed',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'urgent' => 'Urgent',
                        'high' => 'High',
                        'medium' => 'Medium',
                        'low' => 'Low',
                    ]),
                SelectFilter::make('department')
                    ->options([
                        'support' => 'Technical Support',
                        'billing' => 'Billing & Payments',
                        'sales' => 'Sales',
                        'general' => 'General Inquiry',
                    ]),
            ])
            ->filtersFormColumns(3)
            ->headerActions([
                Action::make('export')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function ($livewire): StreamedResponse {
                        $records = $livewire->getFilteredTableQuery()->with(['user'])->get();
                        $filename = 'support-tickets-export-' . now()->format('Y-m-d_His') . '.csv';

                        return response()->streamDownload(function () use ($records) {
                            $file = fopen('php://output', 'w');
                            fputs($file, "\xEF\xBB\xBF");
                            fputcsv($file, [
                                'Ticket #',
                                'Customer Name',
                                'Customer Email',
                                'Subject',
                                'Department',
                                'Priority',
                                'Status',
                                'Opened At',
                                'Last Updated',
                            ]);

                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->id,
                                    $record->user?->name ?? 'N/A',
                                    $record->user?->email ?? 'N/A',
                                    $record->subject,
                                    ucfirst($record->department ?? 'General'),
                                    ucfirst($record->priority ?? 'Medium'),
                                    ucfirst($record->status ?? 'Open'),
                                    $record->created_at?->toIso8601String(),
                                    $record->updated_at?->toIso8601String(),
                                ]);
                            }
                            fclose($file);
                        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
