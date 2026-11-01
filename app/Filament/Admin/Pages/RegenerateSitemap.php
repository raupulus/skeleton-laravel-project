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
     * Solo los administradores pueden acceder a esta acción del sistema.
     */
    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_actions');
    }

    /**
     * Devuelve el label de navegación traducido.
     */
    public static function getNavigationLabel(): string
    {
        return __('filament.regenerate_sitemap');
    }

    /**
     * Devuelve el título de la página traducido.
     */
    public function getTitle(): string
    {
        return __('filament.regenerate_sitemap');
    }

    /**
     * Acción principal del header con modal de confirmación.
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
                    try {
                        Artisan::call('sitemap:generate');
                        Notification::make()
                            ->title(__('filament.regenerate_sitemap_success'))
                            ->body(__('filament.regenerate_sitemap_success_body'))
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        report($e);
                        Notification::make()
                            ->title(__('filament.action_failed'))
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
