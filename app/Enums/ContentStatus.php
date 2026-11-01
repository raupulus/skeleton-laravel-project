<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum que define los estados posibles de contenido (posts, páginas).
 */
enum ContentStatus: string implements HasColor, HasLabel
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

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
        };
    }

    public function getColor(): string|array|null
    {
        return $this->color();
    }
}
