<?php

namespace App\Models;

use App\Traits\CleansUpStorageFiles;
use App\Traits\HasSlug;
use App\Traits\SanitizesHtmlContent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de sección dinámica del frontend.
 * Las secciones se usan para rellenar contenido en zonas específicas del sitio
 * (home, about, contact...) sin necesidad de editar el código fuente.
 *
 * @property int $id Identificador único
 * @property string $slug Slug único de la sección
 * @property string $zone Zona del frontend donde aparece (home, about...)
 * @property array<string, string>|null $title Título opcional traducible (es, en)
 * @property array<string, string>|null $description Descripción corta traducible (es, en)
 * @property array<string, string>|null $content Contenido HTML rico traducible (es, en)
 * @property string|null $image Imagen asociada a la sección
 * @property int $order Orden de aparición dentro de la zona
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de modificación
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $image_url URL pública dinámica de la imagen
 *
 * @method static Builder<Section> forZone(string $zone) Obtiene secciones ordenadas para una zona
 */
class Section extends Model
{
    use CleansUpStorageFiles, HasFactory, HasSlug, HasTranslations, SanitizesHtmlContent, SoftDeletes;

    /** @var array<string> Campos traducibles usando spatie/laravel-translatable */
    public array $translatable = ['title', 'description', 'content'];

    /** @var array<string> Campos asignables en masa */
    protected $fillable = ['slug', 'zone', 'title', 'description', 'content', 'image', 'order'];

    /**
     * Eventos del modelo para invalidar caché de zona (actual y original) al guardar o eliminar.
     */
    protected static function booted(): void
    {
        $clearCache = function (self $model): void {
            Cache::forget("sections_{$model->zone}_ids");
            Cache::forget("sections_{$model->zone}");

            $originalZone = $model->getOriginal('zone');
            if (! empty($originalZone) && $originalZone !== $model->zone) {
                Cache::forget("sections_{$originalZone}_ids");
                Cache::forget("sections_{$originalZone}");
            }
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
    // ACCESSORS
    // =========================================================

    /**
     * Devuelve la URL dinámica y pública de la imagen de la sección.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para obtener secciones de una zona específica, ordenadas por el campo order.
     *
     * @param  Builder<Section>  $query
     * @param  string  $zone  La zona del frontend
     * @return Builder<Section>
     */
    public function scopeForZone(Builder $query, string $zone): Builder
    {
        return $query->where('zone', $zone)->orderBy('order');
    }
}
