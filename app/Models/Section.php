<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de sección dinámica del frontend.
 * Las secciones se usan para rellenar contenido en zonas específicas del sitio
 * (home, about, contact...) sin necesidad de editar el código fuente.
 *
 * @property int $id
 * @property string $slug Slug único de la sección
 * @property string $zone Zona del frontend donde aparece (home, about...)
 * @property array|null $title Título opcional traducible (es, en)
 * @property array|null $description Descripción corta traducible (es, en)
 * @property array|null $content Contenido HTML rico traducible (es, en)
 * @property string|null $image Imagen asociada a la sección
 * @property int $order Orden de aparición dentro de la zona
 */
class Section extends Model
{
    use HasFactory, HasSlug, HasTranslations, SoftDeletes;

    /** @var array<string> Campos traducibles usando spatie/laravel-translatable */
    public array $translatable = ['title', 'description', 'content'];

    /** @var array<string> Campos asignables en masa */
    protected $fillable = ['slug', 'zone', 'title', 'description', 'content', 'image', 'order'];

    /**
     * Eventos del modelo para invalidar caché de zona al guardar o eliminar.
     */
    protected static function booted(): void
    {
        $clearCache = function (self $model): void {
            Cache::forget("sections_{$model->zone}_ids");
        };
        static::saved($clearCache);
        static::deleted($clearCache);
    }

    /**
     * Definición de casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['order' => 'integer'];
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para obtener secciones de una zona específica, ordenadas por el campo order.
     *
     * @param  Builder  $query
     * @param  string  $zone  La zona del frontend
     * @return Builder
     */
    public function scopeForZone($query, string $zone)
    {
        return $query->where('zone', $zone)->orderBy('order');
    }
}
