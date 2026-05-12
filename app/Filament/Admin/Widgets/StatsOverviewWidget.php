<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Page;
use App\Models\Post;
use App\Models\SentEmail;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Widget de estadísticas generales del Dashboard Admin.
 * Muestra tarjetas con métricas: usuarios activos, posts publicados,
 * páginas publicadas y emails enviados.
 */
class StatsOverviewWidget extends BaseWidget
{
    /** @var int Orden del widget en el dashboard */
    protected static ?int $sort = 1;

    /**
     * Define las tarjetas de estadísticas a mostrar.
     *
     * @return array<Stat>  Array de tarjetas con métricas
     */
    protected function getStats(): array
    {
        return [
            Stat::make(__('filament.active_users'), User::active()->count())
                ->description(__('filament.active_users_desc'))
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make(__('filament.published_posts'), Post::published()->count())
                ->description(__('filament.published_posts_desc'))
                ->icon('heroicon-o-newspaper')
                ->color('success'),
            Stat::make(__('filament.published_pages'), Page::published()->count())
                ->description(__('filament.published_pages_desc'))
                ->icon('heroicon-o-document-text')
                ->color('info'),
            Stat::make(__('filament.sent_emails_count'), SentEmail::count())
                ->description(__('filament.sent_emails_desc'))
                ->icon('heroicon-o-envelope')
                ->color('warning'),
        ];
    }
}
