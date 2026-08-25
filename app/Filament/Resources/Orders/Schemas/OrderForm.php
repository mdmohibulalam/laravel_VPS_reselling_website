<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('order_number')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'pending_approval' => 'Pending approval',
            'provisioning' => 'Provisioning',
            'active' => 'Active',
            'failed' => 'Failed',
            'rejected' => 'Rejected',
            'cancelled' => 'Cancelled',
        ])
                    ->required(),
            ]);
    }
}
