<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', '$' . number_format(Invoice::where('status', 'paid')->sum('total'), 2))
                ->description('From paid invoices')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
                
            Stat::make('Active Services', Service::where('status', 'active')->count())
                ->description('Running VPS/RDP instances')
                ->descriptionIcon('heroicon-m-server')
                ->color('primary'),
                
            Stat::make('Pending Orders', Order::where('status', 'pending_approval')->count())
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
