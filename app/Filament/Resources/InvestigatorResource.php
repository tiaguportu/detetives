<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Investigators\Pages\CreateInvestigator;
use App\Filament\Resources\Investigators\Pages\EditInvestigator;
use App\Filament\Resources\Investigators\Pages\ListInvestigators;
use App\Filament\Resources\Investigators\Schemas\InvestigatorForm;
use App\Filament\Resources\Investigators\Tables\InvestigatorsTable;
use App\Models\Investigator;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvestigatorResource extends Resource
{
    protected static ?string $model = Investigator::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Agência';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return InvestigatorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InvestigatorsTable::configure($table);
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
            'index' => ListInvestigators::route('/'),
            'create' => CreateInvestigator::route('/create'),
            'edit' => EditInvestigator::route('/{record}/edit'),
        ];
    }
}
