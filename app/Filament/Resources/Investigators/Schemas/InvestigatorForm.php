<?php

namespace App\Filament\Resources\Investigators\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvestigatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('countries_count')
                    ->required()
                    ->numeric()
                    ->label('Nível da Perseguição'),
                FileUpload::make('avatar_path')
                    ->image()
                    ->directory('investigators')
                    ->disk('public')
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth('400')
                    ->imageResizeTargetHeight('400')
                    ->downloadable()
                    ->openable()
                    ->label('Avatar do Investigador'),
            ]);
    }
}
