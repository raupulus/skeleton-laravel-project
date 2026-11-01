<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum que define los roles de usuario disponibles en la plataforma.
 */
enum Role: string implements HasColor, HasLabel
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case User = 'user';

    /**
     * Obtener la etiqueta legible y traducida del rol.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => __('filament.role_superadmin'),
            self::Admin => __('filament.role_admin'),
            self::User => __('filament.role_user'),
        };
    }

    public function getLabel(): ?string
    {
        return $this->label();
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SuperAdmin => 'danger',
            self::Admin => 'warning',
            self::User => 'info',
        };
    }

    /**
     * Comprobar si el rol tiene permisos de administración.
     */
    public function isAdmin(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin]);
    }
}
