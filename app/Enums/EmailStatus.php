<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum que define los estados posibles de un email enviado.
 */
enum EmailStatus: string implements HasColor, HasLabel
{
    case Sent = 'sent';
    case Failed = 'failed';

    /**
     * Obtener la etiqueta traducida del estado del email.
     */
    public function label(): string
    {
        return match ($this) {
            self::Sent => __('filament.email_status_sent'),
            self::Failed => __('filament.email_status_failed'),
        };
    }

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function color(): string
    {
        return match ($this) {
            self::Sent => 'success',
            self::Failed => 'danger',
        };
    }

    public function getColor(): string|array|null
    {
        return $this->color();
    }
}
