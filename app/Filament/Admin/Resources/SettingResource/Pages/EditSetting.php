<?php
namespace App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource;
use Filament\Resources\Pages\EditRecord;
class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;
    protected function afterSave(): void { app(\App\Services\SettingService::class)->clearCache(); }
}
