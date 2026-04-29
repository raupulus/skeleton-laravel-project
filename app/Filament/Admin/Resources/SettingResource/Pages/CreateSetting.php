<?php
namespace App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource;
use Filament\Resources\Pages\CreateRecord;
class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
    protected function afterSave(): void { app(\App\Services\SettingService::class)->clearCache(); }
}
