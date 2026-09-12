<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'Admin Notes';

    protected static string | \BackedEnum | null $icon = 'heroicon-o-pencil-square';

    public static function getBadge(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): ?string
    {
        $count = $ownerRecord->notes()->count();
        return $count > 0 ? (string) $count : null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->recordTitleAttribute('note')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('note')
                    ->label('Note Content')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('author_name')
                    ->label('Staff Author')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->label('Added At')
                    ->dateTime('M d, Y H:i:s')
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Staff Note')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Add Internal Staff Note')
                    ->form([
                        Textarea::make('note')
                            ->label('Internal Note')
                            ->required()
                            ->rows(4)
                            ->placeholder('Add operational notes, customer preferences, or special instructions...'),
                        TextInput::make('author_name')
                            ->label('Author')
                            ->default(fn () => Auth::user()?->name ?? 'Admin Staff')
                            ->required(),
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->modalHeading('Staff Note Details')
                    ->infolist([
                        \Filament\Infolists\Components\TextEntry::make('author_name')->label('Staff Author')->badge()->color('primary'),
                        \Filament\Infolists\Components\TextEntry::make('created_at')->label('Added At')->dateTime('M d, Y H:i:s'),
                        \Filament\Infolists\Components\TextEntry::make('note')->label('Note Content')->columnSpanFull()->prose(),
                    ])
                    ->extraModalActions([
                        EditAction::make()
                            ->form([
                                Textarea::make('note')->required()->rows(4),
                                TextInput::make('author_name')->required(),
                            ]),
                        DeleteAction::make(),
                    ]),
            ]);
    }
}
