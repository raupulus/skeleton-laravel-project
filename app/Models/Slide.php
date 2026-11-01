<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de slide para carruseles y galerías del frontend.
 * Los slides se agrupan por 'zone', permitiendo múltiples carruseles en el sitio.
 * Soporta imagen principal (16:9) e imagen vertical (8:12) con recorte desde el backend.
 *
 * @property int $id
 * @property array|null $title Título opcional traducible (es, en)
 * @property array|null $content Texto descriptivo opcional traducible (es, en)
 * @property string $image Imagen principal obligatoria (recortada a 16:9)
 * @property string|null $image_vertical Imagen vertical opcional (recortada a 8:12)
 * @property string|null $url URL de destino al hacer clic en el slide
 * @property string $zone Agrupa slides del mismo carrusel
 * @property int $order Orden de aparición dentro de la zona
 * @property bool $is_active Si el slide está visible en el frontend
 */
class Slide extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    /** @var array<string> Campos traducibles usando spatie/laravel-translatable */
    public array $translatable = ['title', 'content'];

    /** @var array<string> Campos asignables en masa */
    protected $fillable = [
        'title', 'content', 'image', 'image_vertical',
        'url', 'zone', 'order', 'is_active',
    ];

    /**
     * Eventos del modelo para invalidar caché de zona al guardar o eliminar.
     */
    protected static function booted(): void
    {
        $clearCache = function (self $model): void {
            Cache::forget("slides_{$model->zone}_ids");
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
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para obtener slides de una zona específica, ordenados y solo activos.
     *
     * @param  Builder  $query
     * @param  string  $zone  La zona del carrusel
     * @return Builder
     */
    public function scopeForZone($query, string $zone)
    {
        return $query->where('zone', $zone)->where('is_active', true)->orderBy('order');
    }
}
