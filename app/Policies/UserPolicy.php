<?php

namespace App\Policies;

use App\Models\User;

/**
 * Policy de autorización para el modelo User.
 * Solo administradores pueden gestionar usuarios.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class UserPolicy
{
    /**
     * Determina si el usuario puede ver el listado de users.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un user específico.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  User  $model  El registro a visualizar
     * @return bool True si el usuario es administrador
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo user.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un user existente.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  User  $model  El registro a actualizar
     * @return bool True si el usuario es administrador
     */
    public function update(User $user, User $model): bool
    {
        if ($model->isSuperAdmin()) {
            return $user->isSuperAdmin();
        }

        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un user.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  User  $model  El registro a eliminar
     * @return bool True si el usuario es superadministrador y no se elimina a sí mismo
     */
    public function delete(User $user, User $model): bool
    {
        // Solo el superadmin puede eliminar registros y nunca su propia cuenta
        return $user->isSuperAdmin() && $user->id !== $model->id;
    }

    /**
     * Determina si el usuario puede restaurar un user eliminado.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  User  $model  El registro a restaurar
     * @return bool True si el usuario es administrador (o superadmin para cuentas superadmin)
     */
    public function restore(User $user, User $model): bool
    {
        if ($model->isSuperAdmin()) {
            return $user->isSuperAdmin();
        }

        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un user.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  User  $model  El registro a eliminar definitivamente
     * @return bool True si el usuario es superadministrador
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isSuperAdmin() && $user->id !== $model->id;
    }

    /**
     * Determina si el usuario puede eliminar múltiples usuarios en lote.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar múltiples usuarios en lote.
     */
    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente múltiples usuarios en lote.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
