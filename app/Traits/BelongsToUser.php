<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait para la asignación automática del usuario creador en modelos de contenido.
 * Asigna automáticamente user_id con el usuario autenticado en el evento 'creating'.
 * Este campo no se expone en los formularios de Filament (se asigna internamente).
 */
trait BelongsToUser
{
    /**
     * Hook de arranque del trait, registra el listener del evento 'creating'.
     */
    public static function bootBelongsToUser(): void
    {
        static::creating(function ($model): void {
            // Solo asignar user_id si no viene ya establecido y hay usuario autenticado
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    /**
     * Relación BelongsTo con el modelo User.
     * Permite acceder al creador del contenido mediante $model->user.
     *
     * @return BelongsTo<User, static>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar registros creados por un usuario específico.
     *
     * @param  Builder  $query  El constructor de consultas Eloquent
     * @param  int  $userId  El ID del usuario propietario
     * @return Builder Consulta filtrada por usuario
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
