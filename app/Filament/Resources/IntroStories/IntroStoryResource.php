<?php

namespace App\Filament\Resources\IntroStories;

use App\Filament\Resources\IntroStories\Pages\CreateIntroStory;
use App\Filament\Resources\IntroStories\Pages\EditIntroStory;
use App\Filament\Resources\IntroStories\Pages\ListIntroStories;
use App\Filament\Resources\IntroStories\Pages\ViewIntroStory;
use App\Filament\Resources\IntroStories\Schemas\IntroStoryForm;
use App\Filament\Resources\IntroStories\Schemas\IntroStoryInfolist;
use App\Filament\Resources\IntroStories\Tables\IntroStoriesTable;
use App\Models\IntroStory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IntroStoryResource extends Resource
{
    protected static ?string $model = IntroStory::class;

    protected static ?string $navigationLabel = 'Histórias Iniciais';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'content';

    public static function form(Schema $schema): Schema
    {
        return IntroStoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return IntroStoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntroStoriesTable::configure($table);
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
            'index' => ListIntroStories::route('/'),
            'create' => CreateIntroStory::route('/create'),
            'view' => ViewIntroStory::route('/{record}'),
            'edit' => EditIntroStory::route('/{record}/edit'),
        ];
    }
}
