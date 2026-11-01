<?php

namespace App\Filament\Admin\Resources\SlideResource\Pages;

use App\Filament\Admin\Resources\SlideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSlides extends ListRecords
{
    protected static string $resource = SlideResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
