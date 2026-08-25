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
                        TextInput::make('status')
                            ->label('Current Order Status')
                            ->disabled()
                            ->default('pending')
                            ->dehydrated()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'Pending (Unpaid)',
                                'provision' => 'Provision / Processing (Paid)',
                                'contabo_ok' => 'Contabo OK (Ready to Deliver)',
                                'active' => 'Active / Delivered',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                                default => ucfirst($state),
                            }),
                    ])
                    ->columns(2),
            ]);
    }
}
