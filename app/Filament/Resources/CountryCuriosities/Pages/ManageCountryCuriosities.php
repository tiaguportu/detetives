<?php

namespace App\Filament\Resources\CountryCuriosities\Pages;

use App\Filament\Resources\CountryCuriosities\CountryCuriosityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCountryCuriosities extends ManageRecords
{
    protected static string $resource = CountryCuriosityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
