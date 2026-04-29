<?php

namespace App\Filament\Panel\Widgets;

use Filament\Widgets\Widget;

/**
 * Widget de bienvenida para el Dashboard del Panel de Usuario.
 * Muestra el nombre del usuario autenticado y la cantidad de tokens API activos.
 */
class WelcomeWidget extends Widget
{
    /** @var int Orden del widget en el dashboard */
    protected static ?int $sort = 1;

    /** @var string Vista Blade asociada al widget */
    protected static string $view = 'filament.panel.widgets.welcome-widget';

    /**
     * Datos que se pasan a la vista del widget.
     *
     * @return array<string, mixed>  Nombre del usuario y conteo de tokens
     */
    protected function getViewData(): array
    {
        $user = auth()->user();

        return [
            'userName'   => $user->name,
            'tokenCount' => $user->tokens()->count(),
        ];
    }
}
