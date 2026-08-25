<?php

namespace App\Filament\Resources\ProvisioningLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProvisioningLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('service_id')
                    ->numeric(),
                TextInput::make('action')
                    ->required(),
                TextInput::make('request_payload'),
                TextInput::make('response_payload'),
                Toggle::make('is_success')
                    ->required(),
            ]);
    }
}
