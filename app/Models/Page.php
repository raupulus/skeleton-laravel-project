<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Traits\BelongsToUser;
use App\Traits\CleansUpStorageFiles;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use App\Traits\SanitizesHtmlContent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de página estática editable desde el backend.
 * Similar a los posts pero orientada a páginas de contenido más permanente.
 * Soporta traducciones (es/en), estados, SEO y categorías opcionales.
 *
 * @property int $id Identificador único de la página
 * @property string $slug Slug único para URLs
 * @property array<string, string> $title Título traducible (es, en)
 * @property array<string, string>|null $content Contenido traducible (es, en)
 * @property array<string, string>|null $excerpt Extracto traducible (es, en)
 * @property array<string, string>|null $seo_title Título SEO traducible (es, en)
 * @property array<string, string>|null $seo_description Descripción SEO traducible (es, en)
 * @property array<string, string>|null $seo_keywords Palabras clave SEO traducibles (es, en)
 * @property string|null $image Ruta de la imagen principal
 * @property ContentStatus $status Estado (draft, published)
 * @property bool $is_active Si la página está activa
 * @property bool $featured Si la página está destacada
 * @property int|null $user_id ID del usuario autor
 * @property Carbon|null $published_at Fecha de publicación
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de modificación
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $image_url URL pública dinámica de la imagen
 * @property-read User|null $user Usuario autor
 * @property-read Collection<int, Category> $categories Categorías asignadas
 *
 * @method static \Illuminate\Database\Eloquent\Builder<Page> published() Filtra páginas publicadas y activas
 * @method static \Illuminate\Database\Eloquent\Builder<Page> draft() Filtra páginas en borrador
 */
class Page extends Model
{
    use BelongsToUser, CleansUpStorageFiles, HasFactory, HasSeo, HasSlug, HasStatus, HasTranslations, SanitizesHtmlContent, SoftDeletes;

    /** @var array<string> Campos traducibles usando spatie/laravel-translatable */
    public array $translatable = ['title', 'content', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords'];

    /** @var array<string> Campos asignables en masa */
    protected $fillable = [
        'slug', 'title', 'content', 'excerpt', 'image',
        'status', 'is_active', 'featured', 'user_id',
        'seo_title', 'seo_description', 'seo_keywords', 'published_at',
    ];

    /**
     * Definición de casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'published_at' => 'datetime',
            'status' => ContentStatus::class,
        ];
    }

    // =========================================================
    // ACCESSORS
    // =========================================================

    /**
     * Devuelve la URL dinámica y pública de la imagen de la página.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    // =========================================================
    // RELACIONES
    // =========================================================

    /**
     * Relación muchos-a-muchos con categorías (tabla pivot category_page).
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
