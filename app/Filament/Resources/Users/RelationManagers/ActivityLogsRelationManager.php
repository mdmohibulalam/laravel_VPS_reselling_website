<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ->weight('bold'),
                TextColumn::make('action')
                    ->label('Event / Action')
                    ->badge()
                    ->color('primary')
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->placeholder('-'),
                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->placeholder('-')
                    ->copyable()
                    ->icon('heroicon-o-globe-alt'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('Activity Log Details')
                    ->infolist([
                        TextEntry::make('created_at')->label('Timestamp')->dateTime('M d, Y H:i:s'),
                        TextEntry::make('action')->label('Event / Action')->badge()->color('primary'),
                        TextEntry::make('ip_address')->label('IP Address')->placeholder('-'),
                        TextEntry::make('description')->label('Description')->columnSpanFull()->prose(),
                    ]),
            ]);
    }
}
