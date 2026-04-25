<?php

namespace App\Filament\Resources\CountryCuriosities;

use App\Filament\Resources\CountryCuriosities\Pages\ManageCountryCuriosities;
use App\Models\CountryCuriosity;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryCuriosityResource extends Resource
{
    protected static ?string $model = CountryCuriosity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'type';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
                Select::make('type')
                    ->options([
                        'history' => 'História',
                        'culture' => 'Cultura',
                        'geography' => 'Geografia',
                        'fauna' => 'Fauna',
                        'flora' => 'Flora',
                    ])
                    ->required(),
                Textarea::make('content')
                    ->label('Conteúdo')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('country.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'history' => 'História',
                        'culture' => 'Cultura',
                        'geography' => 'Geografia',
                        'fauna' => 'Fauna',
                        'flora' => 'Flora',
                    ]),
                \Filament\Tables\Filters\SelectFilter::make('country')
                    ->relationship('country', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCountryCuriosities::route('/'),
        ];
    }
}
