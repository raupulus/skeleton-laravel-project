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
     * Obtener la etiqueta legible del rol en español.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrador',
            self::Admin => 'Administrador',
            self::User => 'Usuario',
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
