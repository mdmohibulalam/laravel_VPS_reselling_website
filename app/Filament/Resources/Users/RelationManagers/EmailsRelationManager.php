<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Models\User;
use App\Models\UserEmailLog;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class EmailsRelationManager extends RelationManager
{
    protected static string $relationship = 'emailLogs';

    protected static ?string $title = 'Emails';

    protected static string | \BackedEnum | null $icon = 'heroicon-o-envelope';

    public static function getBadge(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): ?string
    {
        $count = $ownerRecord->emailLogs()->count();
        return $count > 0 ? (string) $count : null;
    }

    public function table(Table $table): Table
    {
        /** @var User $user */
        $user = $this->getOwnerRecord();

        return $table
            ->heading(null)
            ->recordTitleAttribute('subject')
            ->defaultSort('sent_at', 'desc')
            ->columns([
                TextColumn::make('subject')
                    ->label('Email Subject')
                    ->weight('bold')
                    ->searchable(),
                TextColumn::make('recipient')
                    ->label('Recipient')
                    ->searchable(),
                TextColumn::make('sent_at')
                    ->label('Sent Date & Time')
                    ->dateTime('M d, Y H:i:s')
                    ->sortable(),
            ])
            ->headerActions([
                Action::make('send_email')
                    ->label('Send Email')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->modalHeading("Send Direct Email to {$user->name}")
                    ->modalDescription("This will dispatch an official email to {$user->email} and log it in the customer's communication history.")
                    ->form([
                        TextInput::make('recipient')
                            ->label('To')
                            ->default($user->email)
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->placeholder('e.g. Important Notice Regarding Your VPS Service'),
                        Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(6)
                            ->placeholder('Write your message here...'),
                    ])
                    ->action(function (array $data) use ($user) {
                        try {
                            Mail::raw($data['message'], function ($message) use ($user, $data) {
                                $message->to($user->email)
                                    ->subject($data['subject']);
                            });
                        } catch (\Throwable $e) {
                            // Log and continue if mail server is offline in local dev
                        }

                        UserEmailLog::create([
                            'user_id' => $user->id,
                            'subject' => $data['subject'],
                            'recipient' => $user->email,
                            'body' => $data['message'],
                            'sent_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Email Sent & Logged')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (UserEmailLog $record) => $record->subject)
                    ->infolist([
                        TextEntry::make('subject')->label('Subject')->weight('bold'),
                        TextEntry::make('recipient')->label('Recipient'),
                        TextEntry::make('sent_at')->label('Sent At')->dateTime('M d, Y H:i:s'),
                        TextEntry::make('body')->label('Message Body')->columnSpanFull()->prose(),
                    ]),
            ]);
    }
}
