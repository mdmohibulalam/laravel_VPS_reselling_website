<?php

namespace App\Filament\Customer\Widgets;

use Filament\Widgets\Widget;

class CustomerQuickActions extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected string $view = 'filament.customer.widgets.customer-quick-actions';
}
