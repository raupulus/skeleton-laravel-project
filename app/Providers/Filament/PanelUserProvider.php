<?php

namespace App\Providers\Filament;

use App\Filament\Auth\Login;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\SetLocale;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PanelUserProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('panel')
            ->path('panel')
            ->login(Login::class)
            ->emailVerification()
            ->unsavedChangesAlerts()
            ->colors(['primary' => Color::Blue])
            ->discoverResources(in: app_path('Filament/Panel/Resources'), for: 'App\\Filament\\Panel\\Resources')
            ->discoverPages(in: app_path('Filament/Panel/Pages'), for: 'App\\Filament\\Panel\\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Panel/Widgets'), for: 'App\\Filament\\Panel\\Widgets')
            ->widgets([AccountWidget::class])
            ->middleware([
                EncryptCookies::class, AddQueuedCookiesToResponse::class, StartSession::class,
                AuthenticateSession::class, ShareErrorsFromSession::class, PreventRequestForgery::class,
                SubstituteBindings::class, DisableBladeIconComponents::class, DispatchServingFilamentEvent::class,
                SetLocale::class, EnsureUserIsActive::class,
            ])
            ->authMiddleware([Authenticate::class])
            ->userMenuItems([
                Action::make('go_website')
                    ->label(fn () => __('filament.go_to_website'))
                    ->icon('heroicon-o-globe-alt')
                    ->url(fn () => url('/'))
                    ->sort(PHP_INT_MAX - 5),
                Action::make('go_admin_panel')
                    ->label(fn () => __('filament.admin_panel'))
                    ->icon('heroicon-o-shield-check')
                    ->url(fn () => url('/admin'))
                    ->visible(fn () => auth()->user()?->isAdmin() ?? false)
                    ->sort(PHP_INT_MAX - 4),
                Action::make('lang_es')
                    ->label('Español')
                    ->icon('heroicon-o-check-circle')
                    ->url(fn () => route('language.switch', 'es'))
                    ->color(fn () => app()->getLocale() === 'es' ? 'primary' : 'gray')
                    ->visible(fn () => app()->getLocale() !== 'es')
                    ->sort(PHP_INT_MAX - 2),
                Action::make('lang_en')
                    ->label('English')
                    ->icon('heroicon-o-check-circle')
                    ->url(fn () => route('language.switch', 'en'))
                    ->color(fn () => app()->getLocale() === 'en' ? 'primary' : 'gray')
                    ->visible(fn () => app()->getLocale() !== 'en')
                    ->sort(PHP_INT_MAX - 2),
            ]);
    }
}
