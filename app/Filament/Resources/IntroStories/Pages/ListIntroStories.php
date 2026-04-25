<?php

namespace App\Filament\Resources\IntroStories\Pages;

use App\Filament\Resources\IntroStories\IntroStoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntroStories extends ListRecords
{
    protected static string $resource = IntroStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
