<?php

namespace App\Filament\Resources\Investigators\Pages;

use App\Filament\Resources\InvestigatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestigators extends ListRecords
{
    protected static string $resource = InvestigatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
