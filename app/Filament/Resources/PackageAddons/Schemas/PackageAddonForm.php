<?php

namespace App\Filament\Resources\PackageAddons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PackageAddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_global')
                    ->required(),
                Select::make('package_id')
                    ->relationship('package', 'name'),
                TextInput::make('type')
                    ->required()
                    ->default('feature'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('value'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('billing_cycle')
                    ->options(['monthly' => 'Monthly', 'one_time' => 'One time'])
                    ->required(),
            ]);
    }
}
