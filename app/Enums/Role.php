<?php

namespace App\Enums;

/**
 * Enum que define los roles de usuario disponibles en la plataforma.
 */
enum Role: string
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

    /**
     * Comprobar si el rol tiene permisos de administración.
     */
    public function isAdmin(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin]);
    }
}
