# Módulo: SeoService

> Servicio para la gestión dinámica de meta tags SEO (title, description, OG, Twitter Cards, JSON-LD) con soporte para carga automática desde modelos.

---

## Resumen

El `SeoService` acumula los valores SEO que se inyectan en el layout `head.blade.php`. Cada controlador configura los meta tags de su página mediante una API fluida (method chaining). Los valores por defecto se cargan desde los settings del sistema (`site_title`, `site_description`, `default_meta_keywords`).

---

## Archivo

`app/Services/SeoService.php`

---

## API del servicio

Todos los setters retornan `static` para encadenar:

| Método | Descripción |
|--------|-------------|
| `setTitle(string)` | Título para `<title>` y `og:title` |
| `setDescription(string)` | Meta description y `og:description` |
| `setKeywords(string)` | Meta keywords |
| `setUrl(string)` | URL canónica |
| `setType(string)` | Tipo Open Graph: `website`, `article`, `product`... |
| `setImage(string)` | URL imagen para OG y Twitter Cards |
| `setRobots(string)` | Directiva meta robots (ej: `noindex,follow`) |
| `fromModel(object)` | Carga SEO de un modelo con trait `HasSeo`: llama a `getSeoTitleText()`, `getSeoDescriptionText()`, `getSeoKeywordsText()` y usa `$model->image` |
| `toArray()` | Devuelve array con todos los valores SEO para la vista |

---

## Valores por defecto (fallbacks)

Cuando un campo SEO no se establece explícitamente, se usan estos fallbacks:

| Campo | Fallback |
|-------|----------|
| title | `setting('site_title')` → `config('app.name')` |
| description | `setting('site_description')` → `''` |
| keywords | `setting('default_meta_keywords')` → `''` |
| url | `url()->current()` |
| type | `website` |
| image | `asset('images/redes-sociales/rs-1200x1200.png')` |
| robots | `index,follow` |

---

## Uso en controladores

```php
public function show(string $slug, SeoService $seo): View
{
    $post = Post::where('slug', $slug)->firstOrFail();
    $seo->fromModel($post)->setType('article');
    return view('posts.show', compact('post', 'seo'));
}
```

---

## Integración con el layout

La vista `resources/views/layouts/head.blade.php` recibe `$seo->toArray()` y genera:
- Meta tags básicos (charset, viewport, csrf, title, description, keywords, robots)
- Canonical URL y hreflang (es/en/x-default)
- Open Graph completo (locale, title, site_name, type, description, image, url)
- Twitter Cards (summary_large_image)
- JSON-LD structured data (WebSite / Article)
- Favicons
