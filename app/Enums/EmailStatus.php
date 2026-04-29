<?php

namespace App\Enums;

/**
 * Enum que define los estados posibles de un email enviado.
 */
enum EmailStatus: string
{
    case Sent = 'sent';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Sent => 'Enviado',
            self::Failed => 'Fallido',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Sent => 'success',
            self::Failed => 'danger',
        };
    }
}
