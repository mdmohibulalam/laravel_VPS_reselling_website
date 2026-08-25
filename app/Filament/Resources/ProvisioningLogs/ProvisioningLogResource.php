<?php

namespace App\Filament\Resources\ProvisioningLogs;

use App\Filament\Resources\ProvisioningLogs\Pages\CreateProvisioningLog;
use App\Filament\Resources\ProvisioningLogs\Pages\EditProvisioningLog;
use App\Filament\Resources\ProvisioningLogs\Pages\ListProvisioningLogs;
use App\Filament\Resources\ProvisioningLogs\Schemas\ProvisioningLogForm;
use App\Filament\Resources\ProvisioningLogs\Tables\ProvisioningLogsTable;
use App\Models\ProvisioningLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProvisioningLogResource extends Resource
{
    protected static ?string $model = ProvisioningLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProvisioningLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProvisioningLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProvisioningLogs::route('/'),
            'create' => CreateProvisioningLog::route('/create'),
            'edit' => EditProvisioningLog::route('/{record}/edit'),
        ];
    }
}
