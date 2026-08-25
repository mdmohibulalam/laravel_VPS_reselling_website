<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->schema([
                        TextInput::make('order_number')
                            ->label('Order Number')
                            ->required()
                            ->disabled(),
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        TextInput::make('total_amount')
                            ->label('Total Amount ($)')
                            ->prefix('$')
                            ->required()
                            ->numeric(),
                        Select::make('status')
                            ->label('Order Status')
                            ->options([
                                'pending_approval' => 'Pending Review',
                                'provisioning' => 'Provisioning...',
                                'provisioned' => 'Provisioned (Ready to Deliver)',
                                'active' => 'Active / Delivered',
                                'failed' => 'Failed',
                                'rejected' => 'Rejected',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
