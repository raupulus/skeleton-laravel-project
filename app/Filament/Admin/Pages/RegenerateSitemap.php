<?php

namespace App\Filament\Admin\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

/**
 * Página de acción para regenerar el sitemap.xml desde el panel admin.
 */
class RegenerateSitemap extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?int $navigationSort = 1;
    protected string $view = 'filament.admin.pages.regenerate-sitemap';

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
        return __('filament.regenerate_sitemap');
    }

    /**
     * Devuelve el título de la página traducido.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('filament.regenerate_sitemap');
    }

    /**
     * Acción principal del header con modal de confirmación.
     *
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('regenerate')
                ->label(__('filament.regenerate_sitemap'))
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading(__('filament.regenerate_sitemap'))
                ->modalDescription(__('filament.regenerate_sitemap_confirm'))
                ->modalSubmitActionLabel(__('filament.confirm'))
                ->action(function () {
                    Artisan::call('sitemap:generate');
                    Notification::make()
                        ->title(__('filament.regenerate_sitemap_success'))
                        ->body(__('filament.regenerate_sitemap_success_body'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
