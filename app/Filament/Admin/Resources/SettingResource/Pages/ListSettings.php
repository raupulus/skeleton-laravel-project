<?php
namespace App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource;
use Filament\Resources\Pages\ListRecords;
class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;
    protected function getHeaderActions(): array { return [\Filament\Actions\CreateAction::make()]; }
}
