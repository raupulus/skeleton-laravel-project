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
            Stat::make('Usuarios activos', User::active()->count())
                ->description('Total de usuarios con cuenta activa')
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Posts publicados', Post::published()->count())
                ->description('Artículos en estado publicado')
                ->icon('heroicon-o-newspaper')
                ->color('success'),
            Stat::make('Páginas publicadas', Page::published()->count())
                ->description('Páginas en estado publicado')
                ->icon('heroicon-o-document-text')
                ->color('info'),
            Stat::make('Emails enviados', SentEmail::count())
                ->description('Total de emails registrados')
                ->icon('heroicon-o-envelope')
                ->color('warning'),
        ];
    }
}
