# Fase 03 — Modelos y relaciones

## Resumen
En esta fase se crearán todos los modelos Eloquent con sus relaciones, casts, scopes, traits compartidos y accessors/mutators. Los modelos traducibles usarán `spatie/laravel-translatable`.

**Dependencias**: Fase 01 y Fase 02 completadas.

---

## Paso 3.1 — Crear Traits compartidos

### Trait `HasSlug`

Archivo: `app/Traits/HasSlug.php`

```php
<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait para la generación automática de slug a partir del título.
 * Se ejecuta en el evento 'creating' del modelo.
 * El modelo que use este trait debe tener un campo 'slug' y un campo 'title' (o definir slugSource()).
 */
trait HasSlug
{
    /**
     * Registrar el evento boot para generar slug automáticamente.
     */
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $source = $model->getSlugSource();
                // Si el campo fuente es traducible (json), obtener el valor del idioma por defecto
                $value = is_array($source) ? ($source[config('app.locale')] ?? $source[config('app.fallback_locale')] ?? reset($source)) : $source;
                $model->slug = $model->generateUniqueSlug(Str::slug($value));
            }
        });
    }

    /**
     * Obtener el valor fuente para generar el slug.
     */
    protected function getSlugSource(): mixed
    {
        return $this->title;
    }

    /**
     * Generar un slug único verificando en la base de datos.
     */
    protected function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (static::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
```

### Trait `HasStatus`

Archivo: `app/Traits/HasStatus.php`

```php
<?php

namespace App\Traits;

use App\Enums\ContentStatus;

/**
 * Trait para filtrar contenido por estado (published/draft).
 * El modelo que use este trait debe tener un campo 'status' de tipo ContentStatus.
 */
trait HasStatus
{
    /**
     * Scope para obtener solo contenido publicado.
     */
    public function scopePublished($query)
    {
        return $query->where('status', ContentStatus::Published);
    }

    /**
     * Scope para obtener solo borradores.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', ContentStatus::Draft);
    }

    /**
     * Scope para obtener contenido publicado y activo.
     */
    public function scopePublishedAndActive($query)
    {
        return $query->where('status', ContentStatus::Published)
                     ->where('is_active', true);
    }

    /**
     * Comprobar si el contenido está publicado.
     */
    public function isPublished(): bool
    {
        return $this->status === ContentStatus::Published;
    }

    /**
     * Comprobar si el contenido es un borrador.
     */
    public function isDraft(): bool
    {
        return $this->status === ContentStatus::Draft;
    }
}
```

### Trait `HasSeo`

Archivo: `app/Traits/HasSeo.php`

```php
<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Trait para manejar campos SEO con fallbacks.
 * El modelo debe tener los campos: seo_title, seo_description, seo_keywords, title.
 */
trait HasSeo
{
    /**
     * Obtener el título SEO con fallback al título del contenido.
     */
    public function getSeoTitleText(): string
    {
        $seoTitle = $this->seo_title;
        if (is_array($seoTitle)) {
            $seoTitle = $seoTitle[app()->getLocale()] ?? $seoTitle[config('app.fallback_locale')] ?? '';
        }

        if (!empty($seoTitle)) {
            return $seoTitle;
        }

        $title = $this->title;
        if (is_array($title)) {
            return $title[app()->getLocale()] ?? $title[config('app.fallback_locale')] ?? '';
        }

        return $title ?? '';
    }

    /**
     * Obtener la descripción SEO con fallback al excerpt.
     */
    public function getSeoDescriptionText(): string
    {
        $seoDesc = $this->seo_description;
        if (is_array($seoDesc)) {
            $seoDesc = $seoDesc[app()->getLocale()] ?? $seoDesc[config('app.fallback_locale')] ?? '';
        }

        if (!empty($seoDesc)) {
            return $seoDesc;
        }

        if (isset($this->excerpt)) {
            $excerpt = $this->excerpt;
            if (is_array($excerpt)) {
                return $excerpt[app()->getLocale()] ?? $excerpt[config('app.fallback_locale')] ?? '';
            }
            return $excerpt ?? '';
        }

        return '';
    }

    /**
     * Obtener las keywords SEO.
     */
    public function getSeoKeywordsText(): string
    {
        $keywords = $this->seo_keywords;
        if (is_array($keywords)) {
            return $keywords[app()->getLocale()] ?? $keywords[config('app.fallback_locale')] ?? '';
        }
        return $keywords ?? '';
    }
}
```

### Trait `BelongsToUser`

Archivo: `app/Traits/BelongsToUser.php`

```php
<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait que asigna automáticamente el user_id del usuario autenticado al crear un registro.
 * El modelo que use este trait debe tener un campo 'user_id'.
 */
trait BelongsToUser
{
    /**
     * Registrar el evento boot para asignar user_id automáticamente al crear.
     */
    public static function bootBelongsToUser(): void
    {
        static::creating(function ($model) {
            if (empty($model->user_id) && auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    /**
     * Relación: el contenido pertenece a un usuario (autor).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## Paso 3.2 — Modelo `User`

Archivo: `app/Models/User.php`

```php
<?php

namespace App\Models;

use App\Enums\Role;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo de usuario de la plataforma.
 *
 * Implementa FilamentUser para controlar el acceso a los paneles Filament.
 * Usa HasApiTokens de Sanctum para la autenticación API.
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Determinar si el usuario puede acceder al panel Filament indicado.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role->isAdmin() && $this->is_active;
        }

        // Panel de usuario: cualquier usuario activo puede acceder
        return $this->is_active;
    }

    // --- Scopes ---

    /**
     * Scope para filtrar usuarios activos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para filtrar por rol.
     */
    public function scopeByRole($query, Role $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope para filtrar administradores (superadmin + admin).
     */
    public function scopeAdmins($query)
    {
        return $query->whereIn('role', [Role::SuperAdmin, Role::Admin]);
    }

    // --- Relaciones ---

    /**
     * Relación: páginas creadas por este usuario.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Relación: posts creados por este usuario.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // --- Helpers ---

    /**
     * Comprobar si el usuario es superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === Role::SuperAdmin;
    }

    /**
     * Comprobar si el usuario es admin (superadmin o admin).
     */
    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }
}
```

---

## Paso 3.3 — Modelo `Category`

Archivo: `app/Models/Category.php`

```php
<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de categoría compartida entre páginas y posts.
 */
class Category extends Model
{
    use HasFactory, HasSlug, HasTranslations, SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'image',
        'is_active',
        'order',
    ];

    /**
     * Campos traducibles (spatie/laravel-translatable).
     */
    public array $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // --- Relaciones ---

    /**
     * Relación: páginas asociadas a esta categoría.
     */
    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, 'category_page');
    }

    /**
     * Relación: posts asociados a esta categoría.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }

    // --- Slug source ---

    protected function getSlugSource(): mixed
    {
        return $this->name;
    }
}
```

---

## Paso 3.4 — Modelo `Page`

Archivo: `app/Models/Page.php`

```php
<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Traits\BelongsToUser;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de página estática editable desde el backend.
 */
class Page extends Model
{
    use BelongsToUser, HasFactory, HasSeo, HasSlug, HasStatus, HasTranslations, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'excerpt',
        'image',
        'status',
        'is_active',
        'featured',
        'user_id',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'published_at',
    ];

    /**
     * Campos traducibles (spatie/laravel-translatable).
     */
    public array $translatable = [
        'title', 'content', 'excerpt',
        'seo_title', 'seo_description', 'seo_keywords',
    ];

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // --- Scopes ---

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
    }

    // --- Relaciones ---

    /**
     * Relación: categorías asociadas a esta página.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_page');
    }
}
```

---

## Paso 3.5 — Modelo `Post`

Archivo: `app/Models/Post.php`

```php
<?php

namespace App\Models;

use App\Enums\ContentStatus;
use App\Traits\BelongsToUser;
use App\Traits\HasSeo;
use App\Traits\HasSlug;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de post/artículo del blog.
 */
class Post extends Model
{
    use BelongsToUser, HasFactory, HasSeo, HasSlug, HasStatus, HasTranslations, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'excerpt',
        'image',
        'status',
        'is_active',
        'featured',
        'user_id',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'published_at',
    ];

    public array $translatable = [
        'title', 'content', 'excerpt',
        'seo_title', 'seo_description', 'seo_keywords',
    ];

    protected function casts(): array
    {
        return [
            'status' => ContentStatus::class,
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // --- Scopes ---

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
    }

    public function scopeRecent($query, int $limit = 10)
    {
        return $query->publishedAndActive()->orderByDesc('published_at')->limit($limit);
    }

    // --- Relaciones ---

    /**
     * Relación: categorías asociadas a este post.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
}
```

---

## Paso 3.6 — Modelo `Slide`

Archivo: `app/Models/Slide.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de slide/banner multimedia agrupado por zona.
 */
class Slide extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'image',
        'image_vertical',
        'url',
        'zone',
        'order',
        'is_active',
    ];

    public array $translatable = ['title', 'content'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByZone($query, string $zone)
    {
        return $query->where('zone', $zone);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope: slides activos de una zona, ordenados.
     */
    public function scopeForZone($query, string $zone)
    {
        return $query->active()->byZone($zone)->ordered();
    }
}
```

---

## Paso 3.7 — Modelo `Section`

Archivo: `app/Models/Section.php`

```php
<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Modelo de sección dinámica para zonas del frontend.
 */
class Section extends Model
{
    use HasFactory, HasSlug, HasTranslations, SoftDeletes;

    protected $fillable = [
        'slug',
        'zone',
        'title',
        'description',
        'content',
        'image',
        'order',
    ];

    public array $translatable = ['title', 'description', 'content'];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    // --- Scopes ---

    public function scopeByZone($query, string $zone)
    {
        return $query->where('zone', $zone);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope: secciones de una zona, ordenadas.
     */
    public function scopeForZone($query, string $zone)
    {
        return $query->byZone($zone)->ordered();
    }
}
```

---

## Paso 3.8 — Modelo `Setting`

Archivo: `app/Models/Setting.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de configuración de la plataforma en formato clave-valor.
 */
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'display_name',
        'value',
        'details',
        'type',
        'order',
        'group',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    // --- Scopes ---

    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Obtener el valor de un setting por su key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting?->value ?? $default;
    }
}
```

---

## Paso 3.9 — Modelo `SentEmail`

Archivo: `app/Models/SentEmail.php`

```php
<?php

namespace App\Models;

use App\Enums\EmailStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de registro de emails enviados por la plataforma.
 */
class SentEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'from',
        'subject',
        'body',
        'mailable_class',
        'status',
        'error_message',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'status' => EmailStatus::class,
            'metadata' => 'array',
        ];
    }

    // --- Scopes ---

    public function scopeSent($query)
    {
        return $query->where('status', EmailStatus::Sent);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', EmailStatus::Failed);
    }

    public function scopeRecent($query, int $limit = 10)
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }
}
```

---

## Paso 3.10 — Crear Factories

Crear factories para cada modelo con datos de prueba realistas en español.

Archivos a crear:
- `database/factories/UserFactory.php` — Ya existe por defecto en Laravel, actualizarlo para incluir role y is_active
- `database/factories/CategoryFactory.php`
- `database/factories/PageFactory.php`
- `database/factories/PostFactory.php`
- `database/factories/SlideFactory.php`
- `database/factories/SectionFactory.php`
- `database/factories/SettingFactory.php`
- `database/factories/SentEmailFactory.php`

Ejemplo de `CategoryFactory.php`:

```php
<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nameEs = fake('es_ES')->words(3, true);
        $nameEn = fake('en_US')->words(3, true);

        return [
            'slug' => Str::slug($nameEs),
            'name' => ['es' => $nameEs, 'en' => $nameEn],
            'description' => ['es' => fake('es_ES')->sentence(), 'en' => fake('en_US')->sentence()],
            'image' => null,
            'is_active' => true,
            'order' => fake()->numberBetween(0, 100),
        ];
    }
}
```

Cada factory debe generar datos traducibles con claves `es` y `en` para los campos `$translatable` del modelo.

---

## Checklist de verificación

- [ ] Trait `HasSlug` creado con generación automática de slug único
- [ ] Trait `HasStatus` creado con scopes published/draft/publishedAndActive
- [ ] Trait `HasSeo` creado con métodos getSeoTitleText, getSeoDescriptionText, getSeoKeywordsText
- [ ] Trait `BelongsToUser` creado con asignación automática de user_id en creating
- [ ] Modelo `User` con HasApiTokens, FilamentUser, casts de Role, scopes active/byRole/admins, relaciones pages/posts
- [ ] Modelo `Category` con HasTranslations, HasSlug, relaciones pages/posts (many-to-many)
- [ ] Modelo `Page` con todos los traits (BelongsToUser, HasSeo, HasSlug, HasStatus, HasTranslations), relación categories
- [ ] Modelo `Post` con misma estructura que Page, scope recent
- [ ] Modelo `Slide` con HasTranslations, scopes active/byZone/ordered/forZone
- [ ] Modelo `Section` con HasTranslations, HasSlug, scopes byZone/ordered/forZone
- [ ] Modelo `Setting` con método estático getValue, scopes byGroup/ordered
- [ ] Modelo `SentEmail` con cast EmailStatus, scopes sent/failed/recent
- [ ] Factories creadas para todos los modelos con datos traducibles
- [ ] Todos los $fillable, $casts, $translatable correctamente definidos
- [ ] Todos los modelos documentados con PHPDoc en español
