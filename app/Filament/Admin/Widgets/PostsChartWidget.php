<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

/**
 * Widget de gráfico de barras que muestra los posts creados por mes
 * durante los últimos 6 meses en el Dashboard Admin.
 */
class PostsChartWidget extends ChartWidget
{
    /** @var int Orden del widget en el dashboard */
    protected static ?int $sort = 2;

    /**
     * Devuelve el heading traducido del gráfico.
     */
    public function getHeading(): ?string
    {
        return __('filament.posts_by_month');
    }

    /**
     * Devuelve los datos para el gráfico de barras.
     *
     * @return array<string, mixed> Datasets y labels del gráfico
     */
    protected function getData(): array
    {
        $months = collect();
        $counts = collect();

        // Recorrer los últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->translatedFormat('M Y'));
            $counts->push(
                Post::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );
        }

        return [
            'datasets' => [
                [
                    'label' => __('filament.posts'),
                    'data' => $counts->toArray(),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.5)',
                    'borderColor' => 'rgb(99, 102, 241)',
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    /**
     * Tipo de gráfico a renderizar.
     *
     * @return string Tipo de gráfico (bar, line, pie, etc.)
     */
    protected function getType(): string
    {
        return 'bar';
    }
}
