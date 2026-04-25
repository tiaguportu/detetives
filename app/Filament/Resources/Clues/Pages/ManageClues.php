<?php

namespace App\Filament\Resources\Clues\Pages;

use App\Filament\Resources\ClueResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClues extends ManageRecords
{
    protected static string $resource = ClueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
