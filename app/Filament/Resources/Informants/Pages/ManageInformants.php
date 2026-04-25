<?php

namespace App\Filament\Resources\Informants\Pages;

use App\Filament\Resources\Informants\InformantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageInformants extends ManageRecords
{
    protected static string $resource = InformantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
