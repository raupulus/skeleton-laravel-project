<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

/**
 * Policy de autorización para el modelo Post.
 * Solo administradores pueden gestionar posts.
 * Los usuarios con role admin o superadmin tienen acceso completo.
 */
class PostPolicy
{
    /**
     * Determina si el usuario puede ver el listado de posts.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede ver un post específico.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Post  $model  El registro a visualizar
     * @return bool                True si el usuario es administrador
     */
    public function view(User $user, Post $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede crear un nuevo post.
     *
     * @param  User  $user  El usuario que realiza la acción
     * @return bool         True si el usuario es administrador
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede actualizar un post existente.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Post  $model  El registro a actualizar
     * @return bool                True si el usuario es administrador
     */
    public function update(User $user, Post $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar un post.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Post  $model  El registro a eliminar
     * @return bool                True si el usuario es superadministrador
     */
    public function delete(User $user, Post $model): bool
    {
        // Solo el superadmin puede eliminar registros permanentemente
        return $user->isSuperAdmin();
    }

    /**
     * Determina si el usuario puede restaurar un post eliminado.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Post  $model  El registro a restaurar
     * @return bool                True si el usuario es administrador
     */
    public function restore(User $user, Post $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un post.
     *
     * @param  User       $user    El usuario que realiza la acción
     * @param  Post  $model  El registro a eliminar definitivamente
     * @return bool                True si el usuario es superadministrador
     */
    public function forceDelete(User $user, Post $model): bool
    {
        return $user->isSuperAdmin();
    }
}
