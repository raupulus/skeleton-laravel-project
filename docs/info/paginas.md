# Módulo: Páginas

*Última actualización: 2026-08-26*

> Páginas de contenido estático/dinámico traducibles (es/en) con campos SEO, categorías opcionales y estados de publicación.

---

## Objetivo y funcionalidad

El módulo de páginas permite crear contenido más permanente y estructural que los posts del blog. Su objetivo es dar soporte a las páginas institucionales y de contenido fijo de la plataforma, como «Sobre nosotros», «Servicios», «Términos y condiciones», «Política de privacidad», etc.

Las páginas comparten la misma arquitectura técnica que los posts (traducciones bilingües, campos SEO, categorías opcionales, estados de publicación, slug automático y asignación de autor), pero se muestran en rutas independientes (`/pages/{slug}`) y están pensadas para contenido que no cambia con frecuencia. Esto permite que el administrador cree y edite páginas completas desde el panel de administración sin necesidad de tocar código ni vistas Blade.

Las páginas legales (`politica-privacidad`, `politica-cookies`) se crean automáticamente mediante el seeder para garantizar que los enlaces del footer y del formulario de contacto funcionen desde el primer despliegue. También se exponen endpoints API públicos para consumo externo.

---

## Resumen

Las páginas sirven para contenido más permanente que los posts: «Sobre nosotros», «Servicios», «Términos y condiciones», etc. Comparten la misma arquitectura que los posts (traducciones, SEO, categorías, estados, slug automático, asignación de autor), pero se muestran en rutas independientes (`/pages/{slug}`).

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Page.php` |
| Filament Resource | `app/Filament/Admin/Resources/PageResource.php` |
| Controlador Web | `app/Http/Controllers/Web/PageController.php` |
| Controlador API | `app/Http/Controllers/Api/V1/PageApiController.php` |
| Policy | `app/Policies/PagePolicy.php` |
| Migración | `database/migrations/*_create_pages_table.php` |
| Seeder | `database/seeders/PageSeeder.php` |
| Vista - Detalle | `resources/views/pages/show.blade.php` |

---

## Campos del modelo

Idénticos al modelo Post. Ver [Posts > Campos del modelo](posts.md#campos-del-modelo).

Campos traducibles: `title`, `content`, `excerpt`, `seo_title`, `seo_description`, `seo_keywords`.

---

## Relaciones

| Relación | Tipo | Modelo | Tabla pivot |
|----------|------|--------|-------------|
| `categories()` | belongsToMany | Category | `category_page` |
| `user()` | belongsTo | User | — (vía trait BelongsToUser) |

---

## Traits utilizados

Mismos que Post: `HasTranslations`, `HasSlug`, `HasStatus`, `HasSeo`, `BelongsToUser`, `SoftDeletes`, `HasFactory`.

---

## Rutas

### Web

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/pages/{slug}` | `pages.show` | Detalle de una página |

### API

| Método | URI | Nombre | Auth |
|--------|-----|--------|:---:|
| GET | `/api/v1/pages` | `api.v1.pages.index` | ❌ |
| GET | `/api/v1/pages/{slug}` | `api.v1.pages.show` | ❌ |

---

## Panel Admin (Filament)

- **Grupo de navegación**: Contenido
- **Icono**: `heroicon-o-document-text`
- **Labels**: «Página» / «Páginas»
- **Formulario**: Tabs de traducción (ES/EN) + slug, imagen, estado, destacado, activo, categorías, fecha de publicación
- **Listado**: slug, título, estado (badge), destacado (icono), fecha de publicación
- **Filtros**: Estado (select con ContentStatus)

---

## Datos de ejemplo (Seeder)

El `PageSeeder` crea 12 páginas con traducciones es/en (10 publicadas, 2 borradores). Es idempotente.

Las páginas **`politica-privacidad`** y **`politica-cookies`** se crean siempre en el seeder para garantizar que las rutas legales del footer y del formulario de contacto funcionen desde el primer despliegue. Anteriormente existían como vistas Blade estáticas (`privacy.blade.php` y `cookies.blade.php`); ahora son páginas dinámicas editables desde Filament Admin.
