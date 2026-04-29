<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Section;

/**
 * Policy de autorización para el modelo Section.
 * Solo administradores pueden gestionar secciones.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class SectionPolicy
{
    /**
     * Determina si el usuario puede ver el listado de sections.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un section específico.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Section  $model  El registro a visualizar
     * @return bool                True si el usuario es administrador
     */
    public function view(User $user, Section $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo section.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un section existente.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Section  $model  El registro a actualizar
     * @return bool                True si el usuario es administrador
     */
    public function update(User $user, Section $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un section.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Section  $model  El registro a eliminar
     * @return bool                True si el usuario es superadministrador
     */
    public function delete(User $user, Section $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un section eliminado.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Section  $model  El registro a restaurar
     * @return bool                True si el usuario es administrador
     */
    public function restore(User $user, Section $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un section.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Section  $model  El registro a eliminar definitivamente
     * @return bool                True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Section $model): bool
    {
        return $user->isSuperAdmin();
    }
}
