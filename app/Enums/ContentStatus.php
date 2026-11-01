<?php

namespace App\Enums;

/**
 * Enum que define los estados posibles de contenido (posts, páginas).
 */
enum ContentStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    /**
     * Obtener la etiqueta traducida del estado.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => __('filament.status_draft'),
            self::Published => __('filament.status_published'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
        };
    }
}
