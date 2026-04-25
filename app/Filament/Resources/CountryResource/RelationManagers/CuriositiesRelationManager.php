<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use App\Filament\Resources\CountryCuriosities\CountryCuriosityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CuriositiesRelationManager extends RelationManager
{
    protected static string $relationship = 'curiosities';

    protected static ?string $relatedResource = CountryCuriosityResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
