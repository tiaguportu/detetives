<?php

namespace App\Filament\Resources\Investigators\Pages;

use App\Filament\Resources\InvestigatorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvestigator extends CreateRecord
{
    protected static string $resource = InvestigatorResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
