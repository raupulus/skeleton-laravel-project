# Fase 13 — Comando Sitemap

## Resumen
En esta fase se creará el comando artisan `sitemap:generate` que genera el archivo `public/sitemap.xml` usando `spatie/laravel-sitemap`, incluyendo todas las rutas públicas con soporte multi-idioma.

**Dependencias**: Fases 01-12 completadas.

---

## Paso 13.1 — Crear comando artisan

Archivo: `app/Console/Commands/GenerateSitemap.php`

```php
<?php

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;

/**
 * Comando para generar el sitemap XML del sitio.
 *
 * Genera el archivo public/sitemap.xml incluyendo:
 * - Páginas estáticas (home, about, contact, blog, privacy, cookies)
 * - Páginas dinámicas publicadas
 * - Posts publicados
 *
 * Cada URL incluye lastmod, changefreq y priority.
 */
class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Genera el archivo sitemap.xml con todas las URLs públicas del sitio';

    public function handle(SitemapService $sitemapService): int
    {
        $this->info('Generando sitemap...');

        $sitemapService->generate();

        $this->info('Sitemap generado correctamente en: ' . public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}
```

---

## Paso 13.2 — Mejorar SitemapService con hreflang

Actualizar `app/Services/SitemapService.php` (creado en Fase 06) para incluir alternates hreflang:

```php
// Para cada URL, si el sitio soporta múltiples idiomas,
// añadir alternates:
use Spatie\Sitemap\Tags\Url;

$url = Url::create('/blog/' . $post->slug)
    ->setLastModificationDate($post->updated_at)
    ->setPriority(0.8)
    ->setChangeFrequency('weekly')
    ->addAlternate(url('/blog/' . $post->slug) . '?lang=es', 'es')
    ->addAlternate(url('/blog/' . $post->slug) . '?lang=en', 'en');

$sitemap->add($url);
```

---

## Paso 13.3 — Programar ejecución diaria

Archivo: `routes/console.php`

```php
use Illuminate\Support\Facades\Schedule;

Schedule::command('sitemap:generate')->daily()->at('03:00');
```

---

## Paso 13.4 — Ejecutar y verificar

```bash
php artisan sitemap:generate
```

Verificar que `public/sitemap.xml` existe y contiene las URLs correctas.

---

## Checklist de verificación

- [ ] Comando `sitemap:generate` creado y registrado
- [ ] SitemapService genera URLs de páginas estáticas con priority y changefreq
- [ ] SitemapService genera URLs de pages publicadas con lastmod
- [ ] SitemapService genera URLs de posts publicados con lastmod
- [ ] Hreflang alternates incluidos (es, en)
- [ ] Comando programado para ejecución diaria a las 03:00
- [ ] `php artisan sitemap:generate` ejecutado sin errores
- [ ] `public/sitemap.xml` generado con contenido correcto
