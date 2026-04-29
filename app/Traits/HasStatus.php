<?php

namespace App\Traits;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait para gestionar el estado de los modelos de contenido (posts, páginas).
 * Proporciona scopes para filtrar por estado y métodos helper para verificaciones.
 */
trait HasStatus
{
    /**
     * Scope para obtener únicamente contenido con estado 'published'.
     *
     * @param  Builder  $query  El constructor de consultas Eloquent
     * @return Builder          Consulta filtrada por estado publicado
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published);
    }

    /**
     * Scope para obtener únicamente contenido con estado 'draft' (borrador).
     *
     * @param  Builder  $query  El constructor de consultas Eloquent
     * @return Builder          Consulta filtrada por estado borrador
     */
    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Draft);
    }

    /**
     * Scope para obtener contenido publicado Y activo simultáneamente.
     * Usado en el frontend para mostrar solo contenido visible.
     *
     * @param  Builder  $query  El constructor de consultas Eloquent
     * @return Builder          Consulta filtrada por publicado y activo
     */
    public function scopePublishedAndActive(Builder $query): Builder
    {
        return $query
            ->where('status', ContentStatus::Published)
            ->where('is_active', true);
    }

    /**
     * Comprueba si el contenido tiene estado publicado.
     *
     * @return bool  True si el estado es Published
     */
    public function isPublished(): bool
    {
        return $this->status === ContentStatus::Published;
    }

    /**
     * Comprueba si el contenido tiene estado borrador.
     *
     * @return bool  True si el estado es Draft
     */
    public function isDraft(): bool
    {
        return $this->status === ContentStatus::Draft;
    }
}
