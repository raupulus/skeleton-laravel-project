<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Traits\BelongsToUser;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de post del blog.
 * Soporta traducciones (es/en), estados (draft/published), categorías,
 * SEO fields y asignación automática de user_id al crear.
 *
 * @property int $id Identificador único del post
 * @property string $slug Slug único para URLs
 * @property array<string, string> $title Título traducible (es, en)
 * @property array<string, string>|null $content Contenido traducible (es, en)
 * @property array<string, string>|null $excerpt Extracto traducible (es, en)
 * @property array<string, string>|null $seo_title Título SEO traducible (es, en)
 * @property array<string, string>|null $seo_description Descripción SEO traducible (es, en)
 * @property array<string, string>|null $seo_keywords Palabras clave SEO traducibles (es, en)
 * @property string|null $image Ruta de la imagen principal
 * @property ContentStatus $status Estado (draft, published)
 * @property bool $is_active Si el post está activo
 * @property bool $featured Si el post está destacado
 * @property int $user_id ID del autor
 * @property Carbon|null $published_at Fecha de publicación
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de modificación
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $image_url URL pública dinámica de la imagen
 * @property-read User|null $user Autor del post
 * @property-read Collection<int, Category> $categories Categorías asignadas
 *
 * @method static \Illuminate\Database\Eloquent\Builder<Post> published() Filtra posts publicados y activos
 * @method static \Illuminate\Database\Eloquent\Builder<Post> draft() Filtra posts en borrador
 */
class Post extends Model
{
    use BelongsToUser, HasFactory, HasSeo, HasSlug, HasStatus, HasTranslations, SoftDeletes;

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
     * Devuelve la URL dinámica y pública de la imagen del post.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    // =========================================================
    // RELACIONES
    // =========================================================

    /**
     * Relación muchos-a-muchos con categorías (tabla pivot category_post).
     *
     * @return BelongsToMany<Category>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
