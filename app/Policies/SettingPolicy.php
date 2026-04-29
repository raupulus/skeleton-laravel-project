<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Setting;

/**
 * Policy de autorización para el modelo Setting.
 * Solo administradores pueden gestionar la configuración.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class SettingPolicy
{
    /**
     * Determina si el usuario puede ver el listado de settings.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un setting específico.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Setting  $model  El registro a visualizar
     * @return bool                True si el usuario es administrador
     */
    public function view(User $user, Setting $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo setting.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un setting existente.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Setting  $model  El registro a actualizar
     * @return bool                True si el usuario es administrador
     */
    public function update(User $user, Setting $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un setting.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Setting  $model  El registro a eliminar
     * @return bool                True si el usuario es superadministrador
     */
    public function delete(User $user, Setting $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un setting eliminado.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Setting  $model  El registro a restaurar
     * @return bool                True si el usuario es administrador
     */
    public function restore(User $user, Setting $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un setting.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Setting  $model  El registro a eliminar definitivamente
     * @return bool                True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Setting $model): bool
    {
        return $user->isSuperAdmin();
    }
}
