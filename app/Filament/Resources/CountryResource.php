<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages\CreateCountry;
use App\Filament\Resources\CountryResource\Pages\EditCountry;
use App\Filament\Resources\CountryResource\Pages\ListCountries;
use App\Filament\Resources\CountryResource\RelationManagers\CuriositiesRelationManager;
use App\Models\Country;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAmericas;

    protected static string|\UnitEnum|null $navigationGroup = 'Inteligência Global';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('flag_path')
                    ->label('Bandeira')
                    ->image()
                    ->directory('flags')
                    ->imageEditor(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('history')
                    ->columnSpanFull(),
                Textarea::make('culture')
                    ->columnSpanFull(),
                Textarea::make('geography')
                    ->columnSpanFull(),
                Textarea::make('fauna')
                    ->columnSpanFull(),
                Textarea::make('flora')
                    ->columnSpanFull(),
                Section::make('Galeria Geográfica (16:9)')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->label('Foto do País')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                    ])
                                    ->imageCropAspectRatio('16:9')
                                    ->directory('countries')
                                    ->required(),
                            ])
                            ->orderColumn('sort_order')
                            ->defaultItems(0)
                            ->grid(2)
                            ->label('Galeria de Fotos')
                            ->reorderable(),
                    ])
                    ->columnSpanFull(),
                Section::make('Informantes Locais')
                    ->schema([
                        Select::make('informants')
                            ->label('Informantes deste País')
                            ->relationship('informants', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                FileUpload::make('image_path')
                                    ->label('Foto')
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('16:9')
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                    ])
                                    ->directory('informants'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Coordenadas Geográficas Realísticas (Mapa Satélite)')
                    ->description('Use estas coordenadas para posicionar o ponto exatamente onde o país está no mapaLeaflet.')
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('Ex: -15.793889'),
                        TextInput::make('longitude')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('Ex: -47.882778'),
                    ])
                    ->columns(2),
            ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                ImageColumn::make('flag_path')
                    ->label('Bandeira')
                    ->circular(),
                ImageColumn::make('images.image_path')
                    ->label('Capa')
                    ->stacked()
                    ->limit(1),
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
                //
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

    public static function getRelations(): array
    {
        return [
            CuriositiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
