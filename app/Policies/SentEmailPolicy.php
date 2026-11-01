<?php

namespace App\Policies;

use App\Models\SentEmail;
use App\Models\User;

/**
 * Policy de autorización para el modelo SentEmail.
 * Solo administradores pueden ver los emails enviados.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class SentEmailPolicy
{
    /**
     * Determina si el usuario puede ver el listado de sentemails.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un sentemail específico.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  SentEmail  $model  El registro a visualizar
     * @return bool True si el usuario es administrador
     */
    public function view(User $user, SentEmail $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo sentemail.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un sentemail existente.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  SentEmail  $model  El registro a actualizar
     * @return bool True si el usuario es administrador
     */
    public function update(User $user, SentEmail $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un sentemail.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  SentEmail  $model  El registro a eliminar
     * @return bool True si el usuario es superadministrador
     */
    public function delete(User $user, SentEmail $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un sentemail eliminado.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  SentEmail  $model  El registro a restaurar
     * @return bool True si el usuario es administrador
     */
    public function restore(User $user, SentEmail $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un sentemail.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  SentEmail  $model  El registro a eliminar definitivamente
     * @return bool True si el usuario es superadministrador
     */
    public function forceDelete(User $user, SentEmail $model): bool
    {
        return $user->isSuperAdmin();
    }
}
