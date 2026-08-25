<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\ActionGroup;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                \Filament\Actions\Action::make('cancel_invoice')
                    ->label('Cancel Invoice')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancel Invoice')
                    ->modalDescription('Are you sure you want to cancel this invoice? This action cannot be undone.')
                    ->visible(fn () => $this->record->status !== 'cancelled')
                    ->action(function () {
                        $this->record->update(['status' => 'cancelled']);
                        \Filament\Notifications\Notification::make()->title('Invoice Cancelled')->success()->send();
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
