<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static string|\UnitEnum|null $navigationGroup = 'Orders';

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('All Orders')
                ->group('Orders')
                ->icon(Heroicon::OutlinedShoppingCart)
                ->sort(1)
                ->url(static::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.orders.index') && !request()->has('tab')),

            NavigationItem::make('Pending Orders')
                ->group('Orders')
                ->icon(Heroicon::OutlinedClock)
                ->sort(2)
                ->badge(fn () => Order::where('status', 'pending')->count() ?: null, color: 'warning')
                ->url(static::getUrl('index', ['tab' => 'pending']))
                ->isActiveWhen(fn (): bool => request()->get('tab') === 'pending'),

            NavigationItem::make('Inactive Orders')
                ->group('Orders')
                ->icon(Heroicon::OutlinedPauseCircle)
                ->sort(4)
                ->url(static::getUrl('index', ['tab' => 'inactive']))
                ->isActiveWhen(fn (): bool => request()->get('tab') === 'inactive'),

            NavigationItem::make('Cancelled Orders')
                ->group('Orders')
                ->icon(Heroicon::OutlinedXCircle)
                ->sort(5)
                ->url(static::getUrl('index', ['tab' => 'cancelled']))
                ->isActiveWhen(fn (): bool => request()->get('tab') === 'cancelled'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return \App\Filament\Resources\Orders\Infolists\OrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
