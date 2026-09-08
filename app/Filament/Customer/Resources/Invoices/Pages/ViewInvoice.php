<?php

namespace App\Filament\Customer\Resources\Invoices\Pages;

use App\Filament\Customer\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected string $view = 'filament.customer.pages.view-invoice';

    public function getTitle(): string
    {
        return 'Invoice #' . ($this->record->invoice_number ?? $this->record->id);
    }

    public function getHeading(): string
    {
        return 'Invoice #' . ($this->record->invoice_number ?? $this->record->id);
    }

    public function getBreadcrumbs(): array
    {
        return [
            url('/customer/invoices') => 'My Invoices',
            '' => '#' . ($this->record->invoice_number ?? $this->record->id),
        ];
    }

    protected function getHeaderActions(): array
    {
        $actions = [];

        if (in_array($this->record->status, ['pending', 'unpaid'])) {
            $actions[] = Action::make('pay_now')
                ->label('Pay Invoice Now')
                ->icon('heroicon-m-credit-card')
                ->color('primary')
                ->url(fn () => route('checkout.crypto-pay', $this->record->id));
        }

        $actions[] = Action::make('print')
            ->label('Print / Save PDF')
            ->icon('heroicon-o-printer')
            ->color('gray')
            ->url(fn () => route('customer.invoices.print', $this->record->id))
            ->openUrlInNewTab();

        return $actions;
    }
}
