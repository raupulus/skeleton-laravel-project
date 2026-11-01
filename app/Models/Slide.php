<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de slide para carruseles y galerías del frontend.
 * Los slides se agrupan por 'zone', permitiendo múltiples carruseles en el sitio.
 * Soporta imagen principal (16:9) e imagen vertical (8:12) con recorte desde el backend.
 *
 * @property int $id Identificador único del slide
 * @property array<string, string>|null $title Título opcional traducible (es, en)
 * @property array<string, string>|null $content Texto descriptivo opcional traducible (es, en)
 * @property string $image Imagen principal obligatoria (recortada a 16:9)
 * @property string|null $image_vertical Imagen vertical opcional (recortada a 8:12)
 * @property string|null $url URL de destino al hacer clic en el slide
 * @property string $zone Agrupa slides del mismo carrusel
 * @property int $order Orden de aparición dentro de la zona
 * @property bool $is_active Si el slide está visible en el frontend
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de modificación
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $image_url URL pública dinámica de la imagen principal
 * @property-read string|null $image_vertical_url URL pública dinámica de la imagen vertical
 *
 * @method static Builder<Slide> forZone(string $zone) Obtiene slides activos ordenados para una zona
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
    // ACCESSORS
    // =========================================================

    /**
     * Devuelve la URL dinámica de la imagen principal.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * Devuelve la URL dinámica de la imagen vertical.
     */
    public function getImageVerticalUrlAttribute(): ?string
    {
        return $this->image_vertical ? Storage::disk('public')->url($this->image_vertical) : null;
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para obtener slides de una zona específica, ordenados y solo activos.
     *
     * @param  Builder<Slide>  $query
     * @param  string  $zone  La zona del carrusel
     * @return Builder<Slide>
     */
    public function scopeForZone(Builder $query, string $zone): Builder
    {
        return $query->where('zone', $zone)->where('is_active', true)->orderBy('order');
    }
}
