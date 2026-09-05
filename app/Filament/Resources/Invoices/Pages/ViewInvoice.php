<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verify_explorer')
                ->label('Verify Explorer')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('info')
                ->visible(fn () => !empty($this->record->crypto_txid))
                ->url(fn () => (str_starts_with($this->record->crypto_txid ?? '', '0x') || str_contains($this->record->crypto_network ?? '', 'polygon'))
                    ? "https://polygonscan.com/tx/{$this->record->crypto_txid}"
                    : "https://tronscan.org/#/transaction/{$this->record->crypto_txid}", true)
                ->openUrlInNewTab(),

            Action::make('approve_crypto')
                ->label('Approve & Deploy')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Payment & Deploy Services')
                ->modalDescription('Confirm this invoice as PAID and activate all provisioned Cloud VPS services for this order?')
                ->modalSubmitActionLabel('Confirm & Deploy')
                ->visible(fn () => in_array($this->record->status, ['pending', 'unpaid']))
                ->action(function () {
                    $this->record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    if ($this->record->order) {
                        $this->record->order->update(['status' => 'completed']);
                    }

                    \App\Models\Service::where('order_id', $this->record->order_id)->update(['status' => 'active']);

                    Notification::make()
                        ->title('Invoice #' . $this->record->invoice_number . ' Approved')
                        ->body('Payment confirmed! Cloud VPS instance has been deployed and set to active.')
                        ->success()
                        ->send();
                }),

            ActionGroup::make([
                Action::make('cancel_invoice')
                    ->label('Cancel Invoice')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancel Invoice')
                    ->modalDescription('Are you sure you want to cancel this invoice? This action cannot be undone.')
                    ->visible(fn () => $this->record->status !== 'cancelled')
                    ->action(function () {
                        $this->record->update(['status' => 'cancelled']);
                        Notification::make()->title('Invoice Cancelled')->success()->send();
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
