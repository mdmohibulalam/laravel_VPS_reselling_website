<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('category')
                    ->options(['vps' => 'Vps', 'rdp' => 'Rdp'])
                    ->required(),
                TextInput::make('specs'),
                TextInput::make('price_monthly')
                    ->numeric(),
                TextInput::make('price_quarterly')
                    ->numeric(),
                TextInput::make('price_semi_annually')
                    ->numeric(),
                TextInput::make('price_annually')
                    ->numeric(),
                TextInput::make('setup_fee')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('contabo_product_id'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
