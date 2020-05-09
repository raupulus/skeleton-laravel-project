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
class UserHelper
{
    public static function oldForm($name, $model)
    {
        $old = old($name);

        if ($old) {
            return $old;
        } else if ($model) {
            return $model->{$name};
        }

        return '';
    }
}
