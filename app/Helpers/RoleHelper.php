<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro
 * Date: 24/06/2019
 * Time: 09:20
 */

/**
 * Class RoleHelper
 *
 * Gestión de permisos y comprobaciones de roles para usuarios.
 *
 * Los roles principales existentes son los siguientes:
 * 1 - SuperAdmin → Administrador omnipotente con superpoderes.
 * 2 - Admin → Administrador del sitio sin superpoderes.
 * 3 - Usuario Normal → Permisos generales.
 */
class RoleHelper
{
    private const SUPERADMIN = [1];
    private const ADMIN = [1,3];
    private const USER = [1,2,3];

    /**
     * Comprueba si el usuario actual es superusuario.
     *
     * @return bool
     */
    public static function isSuperAdmin($role_id = null)
    {
        $role_id = $role_id ?: auth()->id();
        return in_array($role_id, self::SUPERADMIN, false);
    }

    /**
     * Comprueba si el usuario actual o el recibido tiene permisos de
     * administración.
     *
     * @return bool
     */
    public static function isAdmin($role_id = null)
    {
        $role_id = $role_id ?: auth()->id();
        return in_array($role_id, self::ADMIN, false);
    }

    /**
     * Comprueba si el usuario actual no es administrador
     *
     * @return bool
     */
    public static function notIsAdmin($role_id = null)
    {
        return !self::isAdmin($role_id);
    }

    /**
     * Comprueba si el usuario actual puede editar el usuario.
     *
     * @param null $user_id
     * @param null $role_id
     *
     * @return bool
     */
    public static function canUserEdit($user_id = null, $role_id = null)
    {
        // TODO → Controlar si soy usuario normal y edito mi propio perfil.
        return self::isAdmin($role_id);
    }
}
