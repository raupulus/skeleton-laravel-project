<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de categoría, compartida entre posts y páginas.
 * Los campos name y description son traducibles (es/en) mediante spatie/laravel-translatable.
 *
 * @property int $id
 * @property string $slug Slug único para URLs
 * @property array $name Nombre traducible (es, en)
 * @property array $description Descripción traducible (es, en)
 * @property string|null $image Ruta de la imagen de la categoría
 * @property bool $is_active Si la categoría está activa
 * @property int $order Orden de visualización
 */
class Category extends Model
{
    use HasFactory, HasSlug, HasTranslations, SoftDeletes;

    /** @var array<string> Campos traducibles usando spatie/laravel-translatable */
    public array $translatable = ['name', 'description'];

    /** @var array<string> Campos asignables en masa */
    protected $fillable = ['slug', 'name', 'description', 'image', 'is_active', 'order'];

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

    /**
     * Define el campo fuente para generar el slug.
     * Las categorías usan 'name' en lugar de 'title'.
     */
    protected function getSlugSource(): mixed
    {
        return $this->name;
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para filtrar solo categorías activas.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar categorías por el campo order ascendente.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // =========================================================
    // RELACIONES
    // =========================================================

    /**
     * Relación muchos-a-muchos con posts (tabla pivot category_post).
     *
     * @return BelongsToMany<Post>
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Relación muchos-a-muchos con páginas (tabla pivot category_page).
     *
     * @return BelongsToMany<Page>
     */
    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class);
    }
}
