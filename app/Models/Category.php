<?php

namespace App\Models;

use App\Traits\HasSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de categoría, compartida entre posts y páginas.
 * Los campos name y description son traducibles (es/en) mediante spatie/laravel-translatable.
 *
 * @property int $id Identificador único
 * @property string $slug Slug único para URLs
 * @property array<string, string> $name Nombre traducible (es, en)
 * @property array<string, string>|null $description Descripción traducible (es, en)
 * @property string|null $image Ruta de la imagen de la categoría
 * @property bool $is_active Si la categoría está activa
 * @property int $order Orden de visualización
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de actualización
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $image_url URL pública dinámica de la imagen
 * @property-read Collection<int, Post> $posts Posts asignados
 * @property-read Collection<int, Page> $pages Páginas asignadas
 *
 * @method static Builder<Category> active() Filtra categorías activas
 * @method static Builder<Category> ordered() Ordena por campo order ascendente
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
    // ACCESSORS
    // =========================================================

    /**
     * Devuelve la URL dinámica y pública de la imagen de la categoría.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para filtrar solo categorías activas.
     *
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar categorías por el campo order ascendente.
     *
     * @param  Builder<Category>  $query
     * @return Builder<Category>
     */
    public function scopeOrdered(Builder $query): Builder
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
