<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Slide;

/**
 * Policy de autorización para el modelo Slide.
 * Solo administradores pueden gestionar slides.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class SlidePolicy
{
    /**
     * Determina si el usuario puede ver el listado de slides.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un slide específico.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Slide  $model  El registro a visualizar
     * @return bool                True si el usuario es administrador
     */
    public function view(User $user, Slide $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo slide.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un slide existente.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Slide  $model  El registro a actualizar
     * @return bool                True si el usuario es administrador
     */
    public function update(User $user, Slide $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un slide.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Slide  $model  El registro a eliminar
     * @return bool                True si el usuario es superadministrador
     */
    public function delete(User $user, Slide $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un slide eliminado.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Slide  $model  El registro a restaurar
     * @return bool                True si el usuario es administrador
     */
    public function restore(User $user, Slide $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un slide.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Slide  $model  El registro a eliminar definitivamente
     * @return bool                True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Slide $model): bool
    {
        return $user->isSuperAdmin();
    }
}
