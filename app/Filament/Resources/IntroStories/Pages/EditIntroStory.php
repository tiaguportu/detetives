<?php

namespace App\Filament\Resources\IntroStories\Pages;

use App\Filament\Resources\IntroStories\IntroStoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIntroStory extends EditRecord
{
    protected static string $resource = IntroStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
