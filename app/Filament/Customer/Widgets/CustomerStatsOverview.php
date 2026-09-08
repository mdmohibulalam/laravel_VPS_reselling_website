<?php

namespace App\Filament\Customer\Widgets;

use App\Filament\Customer\Resources\Invoices\InvoiceResource;
use App\Filament\Customer\Resources\Services\ServiceResource;
use App\Filament\Customer\Resources\SupportTickets\SupportTicketResource;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\SupportTicket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = auth()->id();

        $activeServicesCount = Service::where('user_id', $userId)->where('status', 'active')->count();
        
        $unpaidInvoicesQuery = Invoice::where('user_id', $userId)->whereIn('status', ['pending', 'unpaid']);
        $unpaidCount = $unpaidInvoicesQuery->count();
        $unpaidSum = $unpaidInvoicesQuery->sum('total');

        $activeTicketsCount = SupportTicket::where('user_id', $userId)
            ->whereIn('status', ['open', 'answered', 'customer_reply', 'in_progress'])
            ->count();

        return [
            Stat::make('Active Cloud VPS', (string) $activeServicesCount)
                ->description($activeServicesCount > 0 ? 'Servers operational & active' : 'No running servers yet')
                ->descriptionIcon('heroicon-m-server-stack')
                ->color($activeServicesCount > 0 ? 'success' : 'gray')
                ->url(ServiceResource::getUrl('index')),

            Stat::make('Unpaid Invoices', '$' . number_format($unpaidSum, 2))
                ->description($unpaidCount > 0 ? "{$unpaidCount} invoice(s) awaiting payment" : 'All invoices are paid')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($unpaidCount > 0 ? 'danger' : 'success')
                ->url(InvoiceResource::getUrl('index')),

            Stat::make('Support Tickets', (string) $activeTicketsCount)
                ->description($activeTicketsCount > 0 ? "{$activeTicketsCount} active conversation(s)" : '24/7 Expert support ready')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color($activeTicketsCount > 0 ? 'warning' : 'primary')
                ->url(SupportTicketResource::getUrl('index')),
        ];
    }
}
