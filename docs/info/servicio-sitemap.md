# Módulo: SitemapService

> Generación automática del sitemap XML con todas las URLs públicas del sitio (estáticas, posts y páginas), con soporte de alternates hreflang para multi-idioma (es/en).

---

## Resumen

El `SitemapService` genera el archivo `public/sitemap.xml` con todas las URLs públicas del sitio. Incluye rutas estáticas (home, blog, about, contact), todos los posts publicados y todas las páginas publicadas. Cada URL incluye alternates hreflang para los idiomas `es` y `en`. Se invoca mediante el comando Artisan `sitemap:generate`.

---

## Archivos

| Tipo | Ruta |
|------|------|
| Servicio | `app/Services/SitemapService.php` |
| Comando Artisan | `app/Console/Commands/GenerateSitemap.php` |
| Salida | `public/sitemap.xml` |
| Paquete | `spatie/laravel-sitemap` |

---

## API del servicio

### `generate(): void`

Genera el sitemap completo y lo guarda en `public/sitemap.xml`.

**Flujo interno:**
1. Crea las URLs estáticas con prioridades diferenciadas
2. Añade todos los posts publicados y activos
3. Añade todas las páginas publicadas y activas
4. Escribe el archivo XML

---

## URLs incluidas

### Estáticas

| URL | Frecuencia de cambio | Prioridad |
|-----|----------------------|:---------:|
| `/` (home) | weekly | 1.0 |
| `/blog` | daily | 0.8 |
| `/about` | monthly | 0.5 |
| `/contact` | monthly | 0.4 |

### Posts

Cada post publicado y activo se añade con:
- **URL**: `route('blog.show', $post->slug)`
- **lastmod**: `$post->updated_at`
- **Frecuencia**: monthly
- **Prioridad**: 0.7

### Páginas

Cada página publicada y activa se añade con:
- **URL**: `route('pages.show', $page->slug)`
- **lastmod**: `$page->updated_at`
- **Frecuencia**: monthly
- **Prioridad**: 0.6

---

## Comando Artisan

```bash
php artisan sitemap:generate
```

Genera/actualiza el archivo `public/sitemap.xml`.

El sitemap se genera automáticamente cada día mediante el scheduler:
```php
// routes/console.php
Schedule::command('sitemap:generate')->daily();
```

---

## Soporte multi-idioma (hreflang)

Cada URL en el sitemap incluye alternates `<xhtml:link rel="alternate">` para los idiomas soportados (`es`, `en`). Los alternates se generan añadiendo el parámetro `?lang={locale}` a la URL principal:

```xml
<url>
  <loc>https://example.com/blog/mi-post</loc>
  <xhtml:link rel="alternate" hreflang="es" href="https://example.com/blog/mi-post?lang=es"/>
  <xhtml:link rel="alternate" hreflang="en" href="https://example.com/blog/mi-post?lang=en"/>
</url>
```

Los idiomas están definidos en la propiedad `$locales` del servicio y son configurables.
