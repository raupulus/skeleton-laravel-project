<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Traits\BelongsToUser;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de página estática editable desde el backend.
 * Similar a los posts pero orientada a páginas de contenido más permanente.
 * Soporta traducciones (es/en), estados, SEO y categorías opcionales.
 *
 * @property int $id
 * @property string $slug
 * @property array $title Traducible (es, en)
 * @property array $content Traducible (es, en)
 * @property array $excerpt Traducible (es, en)
 * @property array $seo_title Traducible (es, en)
 * @property array $seo_description Traducible (es, en)
 * @property array $seo_keywords Traducible (es, en)
 * @property string|null $image
 * @property string $status draft|published
 * @property bool $is_active
 * @property bool $featured
 * @property int $user_id Asignado automáticamente al crear
 * @property Carbon|null $published_at
 */
class Page extends Model
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
