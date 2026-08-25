<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\ActionGroup;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                \Filament\Actions\Action::make('suspend')
                    ->label('Suspend User')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Suspend User')
                    ->modalDescription('Are you sure you want to suspend this user? They will instantly lose access to their customer dashboard.')
                    ->visible(fn () => !$this->record->is_suspended)
                    ->action(function () {
                        $this->record->update(['is_suspended' => true]);
                        \Filament\Notifications\Notification::make()->title('User Suspended')->danger()->send();
                    }),
                \Filament\Actions\Action::make('unsuspend')
                    ->label('Unsuspend User')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Unsuspend User')
                    ->modalDescription('Are you sure you want to restore this user\'s access to their dashboard?')
                    ->visible(fn () => $this->record->is_suspended)
                    ->action(function () {
                        $this->record->update(['is_suspended' => false]);
                        \Filament\Notifications\Notification::make()->title('User Restored')->success()->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->label('More Actions')
            ->icon('heroicon-m-ellipsis-vertical')
            ->color('gray'),
        ];
    }
}
