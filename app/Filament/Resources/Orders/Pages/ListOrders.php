<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Orders')
                ->badge(Order::count()),
            'pending' => Tab::make('Pending Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(Order::where('status', 'pending')->count())
                ->badgeColor('warning'),
            'active' => Tab::make('Active / Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['active', 'completed', 'contabo_ok', 'provision']))
                ->badge(Order::whereIn('status', ['active', 'completed', 'contabo_ok', 'provision'])->count()),
            'inactive' => Tab::make('Inactive Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['inactive', 'suspended']))
                ->badge(Order::whereIn('status', ['inactive', 'suspended'])->count()),
            'cancelled' => Tab::make('Cancelled Orders')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['cancelled', 'failed']))
                ->badge(Order::whereIn('status', ['cancelled', 'failed'])->count()),
        ];
    }
}
