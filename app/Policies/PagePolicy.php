<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Page;

/**
 * Policy de autorización para el modelo Page.
 * Solo administradores pueden gestionar páginas.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class PagePolicy
{
    /**
     * Determina si el usuario puede ver el listado de pages.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un page específico.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Page  $model  El registro a visualizar
     * @return bool                True si el usuario es administrador
     */
    public function view(User $user, Page $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo page.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un page existente.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Page  $model  El registro a actualizar
     * @return bool                True si el usuario es administrador
     */
    public function update(User $user, Page $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un page.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Page  $model  El registro a eliminar
     * @return bool                True si el usuario es superadministrador
     */
    public function delete(User $user, Page $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un page eliminado.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Page  $model  El registro a restaurar
     * @return bool                True si el usuario es administrador
     */
    public function restore(User $user, Page $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un page.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Page  $model  El registro a eliminar definitivamente
     * @return bool                True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Page $model): bool
    {
        return $user->isSuperAdmin();
    }
}
