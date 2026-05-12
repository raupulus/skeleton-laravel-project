<?php

namespace App\Filament\Admin\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

/**
 * Página de acción para limpiar toda la caché del sistema desde el panel admin.
 */
class ClearCache extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-trash';
    protected static ?int $navigationSort = 2;
    protected string $view = 'filament.admin.pages.clear-cache';

    /**
     * Devuelve el grupo de navegación traducido.
     *
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_actions');
    }

    /**
     * Devuelve el label de navegación traducido.
     *
     * @return string
     */
    public static function getNavigationLabel(): string
    {
        return __('filament.clear_cache');
    }

    /**
     * Devuelve el título de la página traducido.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('filament.clear_cache');
    }

    /**
     * Acción principal con modal de confirmación y advertencias.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('clear')
                ->label(__('filament.clear_cache'))
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(__('filament.clear_cache'))
                ->modalDescription(__('filament.clear_cache_confirm'))
                ->modalSubmitActionLabel(__('filament.confirm'))
                ->action(function () {
                    Artisan::call('project:clear');
                    Notification::make()
                        ->title(__('filament.clear_cache_success'))
                        ->body(__('filament.clear_cache_success_body'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
