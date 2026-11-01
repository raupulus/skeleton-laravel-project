<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

/**
 * Policy de autorización para el modelo Category.
 * Solo administradores pueden gestionar categorías.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class CategoryPolicy
{
    /**
     * Determina si el usuario puede ver el listado de categorys.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un category específico.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  Category  $model  El registro a visualizar
     * @return bool True si el usuario es administrador
     */
    public function view(User $user, Category $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo category.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un category existente.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  Category  $model  El registro a actualizar
     * @return bool True si el usuario es administrador
     */
    public function update(User $user, Category $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un category.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  Category  $model  El registro a eliminar
     * @return bool True si el usuario es superadministrador
     */
    public function delete(User $user, Category $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un category eliminado.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  Category  $model  El registro a restaurar
     * @return bool True si el usuario es administrador
     */
    public function restore(User $user, Category $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un category.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @param  Category  $model  El registro a eliminar definitivamente
     * @return bool True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Category $model): bool
    {
        return $user->isSuperAdmin();
    }
}
