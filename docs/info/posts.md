# Módulo: Posts (Blog)

> Sistema de blog con artículos traducibles (es/en), categorías, campos SEO, estados de publicación y asignación automática de autor.

---

## Objetivo y funcionalidad

El módulo de posts implementa el sistema de blog de la plataforma, permitiendo publicar artículos con contenido enriquecido. Su objetivo es ofrecer un sistema de publicación completo, bilingüe y optimizado para SEO, gestionable desde el panel de administración y visible públicamente en el frontend.

Cada post soporta traducciones en español e inglés para todos sus campos de contenido (título, cuerpo, extracto) y campos SEO (título SEO, meta descripción, keywords), lo que permite mantener versiones del artículo en ambos idiomas de forma independiente. Los posts se pueden organizar mediante categorías (relación muchos a muchos), marcar como destacados, y gestionar con un flujo de publicación basado en estados (borrador → publicado).

En el frontend, el blog se presenta con un listado paginado de posts publicados en `/blog` y una vista de detalle en `/blog/{slug}`. El SEO se gestiona automáticamente mediante el trait `HasSeo` y el `SeoService`, que inyectan los meta tags apropiados en cada página. También se exponen endpoints API públicos para que aplicaciones externas consuman los posts.

El autor se asigna automáticamente al usuario logueado mediante el trait `BelongsToUser`, sin que aparezca en el formulario del panel admin. El slug se genera automáticamente desde el título si no se especifica manualmente.

---

## Resumen

Los posts conforman el sistema de blog de la plataforma. Cada post soporta traducciones en español e inglés para título, contenido, extracto y campos SEO. Pueden asignarse a múltiples categorías, marcarse como destacados y gestionarse con estados de borrador/publicado. El autor se asigna automáticamente al crear (usuario logueado) y no aparece en el formulario.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Post.php` |
| Filament Resource | `app/Filament/Admin/Resources/PostResource.php` |
| Controlador Web | `app/Http/Controllers/Web/PostController.php` |
| Controlador API | `app/Http/Controllers/Api/V1/PostApiController.php` |
| Policy | `app/Policies/PostPolicy.php` |
| Migración | `database/migrations/*_create_posts_table.php` |
| Seeder | `database/seeders/PostSeeder.php` |
| Vista - Listado | `resources/views/posts/index.blade.php` |
| Vista - Detalle | `resources/views/posts/show.blade.php` |

---

## Campos del modelo

| Campo | Tipo | Traducible | Descripción |
|-------|------|:---:|-------------|
| `id` | int (PK) | — | Identificador único |
| `slug` | string (unique) | — | URL amigable, autogenerado desde el título si está vacío |
| `title` | json | ✅ | Título del post (es/en) |
| `content` | json | ✅ | Contenido HTML enriquecido (es/en) |
| `excerpt` | json | ✅ | Extracto/resumen breve (es/en) |
| `seo_title` | json | ✅ | Título optimizado para buscadores (es/en) |
| `seo_description` | json | ✅ | Meta descripción para buscadores (es/en) |
| `seo_keywords` | json | ✅ | Palabras clave para SEO (es/en) |
| `image` | string (nullable) | — | Imagen destacada, almacenada en `storage/app/public/posts` |
| `status` | enum (ContentStatus) | — | Estado: `draft` o `published` |
| `is_active` | boolean | — | Control adicional de visibilidad |
| `featured` | boolean | — | Si el post está marcado como destacado |
| `user_id` | int (FK) | — | Autor, asignado automáticamente vía trait `BelongsToUser` |
| `published_at` | datetime (nullable) | — | Fecha de publicación |
| `deleted_at` | datetime (nullable) | — | Soft delete |

---

## Relaciones

| Relación | Tipo | Modelo | Tabla pivot |
|----------|------|--------|-------------|
| `categories()` | belongsToMany | Category | `category_post` |
| `user()` | belongsTo | User | — (vía trait BelongsToUser) |

---

## Traits utilizados

| Trait | Funcionalidad |
|-------|--------------|
| `HasTranslations` | Campos traducibles (spatie/laravel-translatable) |
| `HasSlug` | Generación automática de slug único desde el título |
| `HasStatus` | Scopes `published()`, `draft()`, `publishedAndActive()` y helpers `isPublished()`, `isDraft()` |
| `HasSeo` | Métodos `getSeoTitleText()`, `getSeoDescriptionText()`, `getSeoKeywordsText()` con fallbacks |
| `BelongsToUser` | Asignación automática de `user_id` al crear y relación `user()` |
| `SoftDeletes` | Borrado lógico |

---

## Rutas

### Web

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/blog` | `blog.index` | Listado paginado de posts publicados |
| GET | `/blog/{slug}` | `blog.show` | Detalle de un post |

### API

| Método | URI | Nombre | Auth |
|--------|-----|--------|:---:|
| GET | `/api/v1/posts` | `api.v1.posts.index` | ❌ |
| GET | `/api/v1/posts/{slug}` | `api.v1.posts.show` | ❌ |

---

## Panel Admin (Filament)

- **Grupo de navegación**: Contenido
- **Icono**: `heroicon-o-newspaper`
- **Formulario**: Tabs de traducción (ES/EN) con campos de contenido y SEO + campos generales (slug, imagen, estado, destacado, activo, categorías, fecha de publicación)
- **Listado**: Columnas slug, título, estado (badge), destacado (icono), fecha de publicación
- **Acciones**: Editar

---

## Datos de ejemplo (Seeder)

El `PostSeeder` crea 10 posts con traducciones es/en (8 publicados, 2 borradores). Es idempotente.
