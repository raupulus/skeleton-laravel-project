<?php

namespace App\Filament\Admin\Resources\SentEmailResource\Pages;

use App\Filament\Admin\Resources\SentEmailResource;
use Filament\Resources\Pages\ListRecords;

class ListSentEmails extends ListRecords
{
    protected static string $resource = SentEmailResource::class;
}
