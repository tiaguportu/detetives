<?php

namespace App\Filament\Resources\IntroStories\Pages;

use App\Filament\Resources\IntroStories\IntroStoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIntroStory extends ViewRecord
{
    protected static string $resource = IntroStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
