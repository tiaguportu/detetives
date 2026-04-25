<?php

namespace App\Filament\Resources\Investigators\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\TextInput;

class InvestigatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('avatar_path')
                    ->disk('public')
                    ->label('Avatar'),
                TextColumn::make('countries_count')
                    ->label('Nível (Países)')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
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
                    BulkAction::make('update_level')
                        ->label('Atualizar Nível')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            TextInput::make('countries_count')
                                ->label('Novo Nível (Países)')
                                ->numeric()
                                ->required(),
                        ])
                        ->action(fn (iterable $records, array $data) => $records->each(fn ($record) => $record->update([
                            'countries_count' => $data['countries_count'],
                        ])))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
