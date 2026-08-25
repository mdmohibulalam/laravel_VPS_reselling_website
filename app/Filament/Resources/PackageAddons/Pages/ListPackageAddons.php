<?php

namespace App\Filament\Resources\PackageAddons\Pages;

use App\Filament\Resources\PackageAddons\PackageAddonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackageAddons extends ListRecords
{
    protected static string $resource = PackageAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
