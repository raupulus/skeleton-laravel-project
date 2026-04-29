# Fase 06 — Services y lógica de negocio

## Resumen
En esta fase se crearán los servicios principales que encapsulan la lógica de negocio: EmailService (envío y registro de emails), SettingService (acceso a configuración con caché), SitemapService (generación de sitemap) y SeoService (meta tags dinámicos). Se creará también el helper global `setting()`.

**Dependencias**: Fases 01-05 completadas.

---

## Paso 6.1 — `EmailService`

Archivo: `app/Services/EmailService.php`

```php
<?php

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\SentEmail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Servicio para enviar emails y registrarlos automáticamente en la tabla sent_emails.
 *
 * Todos los emails de la plataforma deben enviarse a través de este servicio
 * para garantizar que quedan registrados en la base de datos.
 */
class EmailService
{
    /**
     * Enviar un email y registrarlo en la base de datos.
     *
     * @param Mailable $mailable  Instancia del Mailable a enviar.
     * @param string   $to        Dirección de email del destinatario.
     * @param string   $subject   Asunto del email (override si el Mailable ya tiene uno).
     * @param array    $metadata  Datos adicionales para almacenar (adjuntos, etc.).
     * @return SentEmail Registro del email enviado.
     */
    public function send(Mailable $mailable, string $to, string $subject = '', array $metadata = []): SentEmail
    {
        $from = config('mail.from.address', 'noreply@example.com');

        try {
            // Renderizar el contenido del email antes de enviarlo
            $renderedContent = $mailable->render();

            Mail::to($to)->send($mailable);

            return SentEmail::create([
                'to' => $to,
                'from' => $from,
                'subject' => $subject ?: $mailable->subject ?? get_class($mailable),
                'body' => $renderedContent,
                'mailable_class' => get_class($mailable),
                'status' => EmailStatus::Sent,
                'error_message' => null,
                'metadata' => $metadata ?: null,
            ]);
        } catch (Throwable $e) {
            return SentEmail::create([
                'to' => $to,
                'from' => $from,
                'subject' => $subject ?: $mailable->subject ?? get_class($mailable),
                'body' => $renderedContent ?? '',
                'mailable_class' => get_class($mailable),
                'status' => EmailStatus::Failed,
                'error_message' => $e->getMessage(),
                'metadata' => $metadata ?: null,
            ]);
        }
    }
}
```

---

## Paso 6.2 — `SettingService`

Archivo: `app/Services/SettingService.php`

```php
<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Servicio para acceder a la configuración de la plataforma con caché.
 *
 * Los settings se cachean durante 1 hora para evitar consultas repetidas.
 * La caché se invalida automáticamente al modificar un setting desde Filament.
 */
class SettingService
{
    /**
     * Clave de caché para todos los settings.
     */
    private const CACHE_KEY = 'app_settings';
    private const CACHE_TTL = 3600; // 1 hora

    /**
     * Obtener el valor de un setting por su key.
     *
     * @param string $key     Clave del setting.
     * @param mixed  $default Valor por defecto si no existe.
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();
        return $settings[$key] ?? $default;
    }

    /**
     * Obtener todos los settings como array key => value.
     */
    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Obtener todos los settings de un grupo.
     */
    public function group(string $group): array
    {
        return Setting::byGroup($group)->ordered()->pluck('value', 'key')->toArray();
    }

    /**
     * Limpiar la caché de settings.
     * Llamar este método cuando se modifique un setting desde el panel.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
```

### Helper global `setting()`

Archivo: `app/Helpers/helpers.php`

```php
<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * Obtener el valor de un setting de la plataforma.
     *
     * @param string $key     Clave del setting.
     * @param mixed  $default Valor por defecto si no existe.
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingService::class)->get($key, $default);
    }
}
```

Registrar el helper en `composer.json` (sección `autoload`):

```json
"autoload": {
    "psr-4": { ... },
    "files": [
        "app/Helpers/helpers.php"
    ]
}
```

Ejecutar:

```bash
composer dump-autoload
```

---

## Paso 6.3 — `SitemapService`

Archivo: `app/Services/SitemapService.php`

```php
<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Servicio para generar el sitemap XML del sitio.
 *
 * Incluye todas las rutas públicas: home, about, contact, blog,
 * páginas publicadas y posts publicados.
 */
class SitemapService
{
    /**
     * Generar el sitemap y guardarlo en public/sitemap.xml.
     */
    public function generate(): void
    {
        $sitemap = Sitemap::create();

        // Páginas estáticas
        $staticPages = [
            ['url' => '/', 'priority' => 1.0, 'freq' => 'daily'],
            ['url' => '/about', 'priority' => 0.8, 'freq' => 'monthly'],
            ['url' => '/contact', 'priority' => 0.7, 'freq' => 'monthly'],
            ['url' => '/blog', 'priority' => 0.9, 'freq' => 'daily'],
            ['url' => '/privacy', 'priority' => 0.3, 'freq' => 'yearly'],
            ['url' => '/cookies', 'priority' => 0.3, 'freq' => 'yearly'],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency($page['freq'])
            );
        }

        // Páginas dinámicas publicadas
        Page::publishedAndActive()->get()->each(function (Page $page) use ($sitemap) {
            $sitemap->add(
                Url::create("/pages/{$page->slug}")
                    ->setLastModificationDate($page->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency('weekly')
            );
        });

        // Posts publicados
        Post::publishedAndActive()->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
```

---

## Paso 6.4 — `SeoService`

Archivo: `app/Services/SeoService.php`

```php
<?php

namespace App\Services;

/**
 * Servicio para generar meta tags SEO dinámicamente.
 *
 * Se usa desde las vistas Blade para inyectar meta tags de Open Graph,
 * Twitter Cards, JSON-LD y etiquetas estándar.
 */
class SeoService
{
    private string $title = '';
    private string $description = '';
    private string $keywords = '';
    private string $image = '';
    private string $url = '';
    private string $type = 'website';
    private string $robots = 'index,follow';
    private ?string $author = null;
    private ?string $publishedAt = null;

    /**
     * Establecer el título SEO.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Establecer la descripción SEO.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Establecer palabras clave.
     */
    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Establecer imagen para Open Graph y Twitter Cards.
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Establecer la URL canónica.
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Establecer el tipo Open Graph (website, article, etc.).
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Establecer la directiva de robots.
     */
    public function setRobots(string $robots): self
    {
        $this->robots = $robots;
        return $this;
    }

    /**
     * Establecer autor para artículos.
     */
    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Establecer fecha de publicación para artículos.
     */
    public function setPublishedAt(string $publishedAt): self
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    /**
     * Configurar SEO desde un modelo con trait HasSeo.
     */
    public function fromModel(mixed $model): self
    {
        if (method_exists($model, 'getSeoTitleText')) {
            $this->setTitle($model->getSeoTitleText());
        }
        if (method_exists($model, 'getSeoDescriptionText')) {
            $this->setDescription($model->getSeoDescriptionText());
        }
        if (method_exists($model, 'getSeoKeywordsText')) {
            $this->setKeywords($model->getSeoKeywordsText());
        }
        if (isset($model->image)) {
            $this->setImage(asset($model->image));
        }

        return $this;
    }

    /**
     * Obtener todos los datos SEO como array para la vista.
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title ?: setting('site_title', config('app.name')),
            'description' => $this->description ?: setting('site_description', ''),
            'keywords' => $this->keywords ?: setting('default_meta_keywords', ''),
            'image' => $this->image ?: asset('images/redes-sociales/rs-1200x1200.png'),
            'url' => $this->url ?: url()->current(),
            'type' => $this->type,
            'robots' => $this->robots,
            'author' => $this->author,
            'publishedAt' => $this->publishedAt,
        ];
    }
}
```

Registrar `SeoService` como singleton en `AppServiceProvider`:

```php
public function register(): void
{
    $this->app->singleton(SeoService::class);
    $this->app->singleton(SettingService::class);
}
```

---

## Checklist de verificación

- [ ] `EmailService` creado con método `send()` que registra en `sent_emails` y maneja excepciones
- [ ] `SettingService` creado con caché, métodos `get()`, `all()`, `group()`, `clearCache()`
- [ ] Helper global `setting()` creado y registrado en composer.json autoload files
- [ ] `composer dump-autoload` ejecutado
- [ ] `SitemapService` creado con generación de sitemap incluyendo rutas estáticas, pages y posts
- [ ] `SeoService` creado con builder pattern, método `fromModel()`, método `toArray()`
- [ ] `SeoService` y `SettingService` registrados como singletons en `AppServiceProvider`
