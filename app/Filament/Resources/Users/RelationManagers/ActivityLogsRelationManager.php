<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'activityLogs';

    protected static ?string $title = 'Activity Log';

    protected static string | \BackedEnum | null $icon = 'heroicon-o-clock';

    public static function getBadge(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): ?string
    {
        $count = $ownerRecord->activityLogs()->count();
        return $count > 0 ? (string) $count : null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->recordTitleAttribute('action')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('M d, Y H:i:s')
                    ->sortable()
                    ->weight('bold')
                    ->toggleable(),
                TextColumn::make('action')
                    ->label('Event / Action')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->placeholder('-')
                    ->copyable()
                    ->icon('heroicon-o-globe-alt')
                    ->toggleable(),
            ])
            ->columnToggleFormColumns(2)
            ->filters([
                SelectFilter::make('action')
                    ->label('Event / Action')
                    ->options([
                        'LOGIN' => 'Login',
                        'LOGOUT' => 'Logout',
                        'ORDER_PLACED' => 'Order Placed',
                        'PAYMENT_SUBMITTED' => 'Payment Submitted',
                        'PORTAL_BLOCKED' => 'Portal Blocked',
                        'PORTAL_RESTORED' => 'Portal Restored',
                        'PASSWORD_RESET' => 'Password Reset',
                        'REGISTERED' => 'Registered',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('From Date'),
                        DatePicker::make('created_until')->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('Activity Log Details')
                    ->infolist([
                        TextEntry::make('created_at')->label('Timestamp')->dateTime('M d, Y H:i:s'),
                        TextEntry::make('action')->label('Event / Action')->badge()->color('primary'),
                        TextEntry::make('ip_address')->label('IP Address')->placeholder('-'),
                        TextEntry::make('description')->label('Description')->columnSpanFull()->prose(),
                    ]),
            ])
            ->toolbarActions([
                Action::make('export')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function ($livewire): StreamedResponse {
                        $records = $livewire->getFilteredTableQuery()->get();
                        $filename = 'customer-activity-logs-' . now()->format('Y-m-d_His') . '.csv';

                        return response()->streamDownload(function () use ($records) {
                            $file = fopen('php://output', 'w');
                            fputs($file, "\xEF\xBB\xBF");
                            fputcsv($file, ['Timestamp', 'Event / Action', 'Description', 'IP Address']);

                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->created_at?->format('Y-m-d H:i:s'),
                                    $record->action,
                                    $record->description,
                                    $record->ip_address ?: 'N/A',
                                ]);
                            }
                            fclose($file);
                        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
                    }),
            ]);
    }
}
