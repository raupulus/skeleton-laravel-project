# Módulo: Categorías

> Taxonomía compartida entre posts y páginas, con nombres traducibles (es/en), slug único y ordenación personalizada.

---

## Objetivo y funcionalidad

El módulo de categorías proporciona un sistema de taxonomía para organizar el contenido de la plataforma temáticamente. Su objetivo es permitir agrupar posts y páginas bajo etiquetas comunes (ej: «Tecnología», «Noticias», «Tutoriales»), facilitando la navegación y el filtrado del contenido tanto en el frontend como en la API.

Las categorías funcionan como entidades independientes con nombre y descripción traducibles (español e inglés), imagen representativa opcional, estado activo/inactivo y un campo de orden para controlar su posición en los listados. Se relacionan con posts y páginas mediante relaciones muchos a muchos (tablas pivot `category_post` y `category_page`), lo que permite que un mismo contenido pertenezca a varias categorías simultáneamente.

Desde el panel de administración se pueden crear, editar y desactivar categorías. En el frontend, las categorías asignadas se muestran en las tarjetas de post y en las vistas de detalle. La API expone endpoints públicos para listar y consultar categorías.

---

## Resumen

Las categorías permiten organizar el contenido (posts y páginas) temáticamente. Son entidades independientes con nombre y descripción traducibles, imagen opcional, estado activo/inactivo y un campo de orden para controlar su posición en los listados. Cada categoría se relaciona con posts y páginas mediante tablas pivot.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Category.php` |
| Filament Resource | `app/Filament/Admin/Resources/CategoryResource.php` |
| Controlador API | `app/Http/Controllers/Api/V1/CategoryApiController.php` |
| Policy | `app/Policies/CategoryPolicy.php` |
| Migración | `database/migrations/*_create_categories_table.php` |
| Seeder | `database/seeders/CategorySeeder.php` |

---

## Campos del modelo

| Campo | Tipo | Traducible | Descripción |
|-------|------|:---:|-------------|
| `id` | int (PK) | — | Identificador único |
| `slug` | string (unique) | — | URL amigable autogenerada desde el nombre |
| `name` | json | ✅ | Nombre de la categoría (es/en) |
| `description` | json | ✅ | Descripción opcional (es/en) |
| `image` | string (nullable) | — | Imagen representativa, almacenada en `storage/app/public/categories` |
| `is_active` | boolean | — | Si la categoría está visible y seleccionable |
| `order` | integer | — | Posición en los listados (menor = primero). Por defecto: 0 |
| `deleted_at` | datetime (nullable) | — | Soft delete |

---

## Relaciones

| Relación | Tipo | Modelo | Tabla pivot |
|----------|------|--------|-------------|
| `posts()` | belongsToMany | Post | `category_post` |
| `pages()` | belongsToMany | Page | `category_page` |

---

## Scopes

| Scope | Descripción |
|-------|-------------|
| `active()` | Solo categorías con `is_active = true` |
| `ordered()` | Ordenadas por campo `order` ascendente |

---

## Traits

- `HasSlug` — Genera slug único desde el campo `name`
- `HasTranslations` — Campos traducibles vía spatie/laravel-translatable
- `SoftDeletes` — Borrado lógico
- `HasFactory` — Factory para tests

---

## Rutas API

| Método | URI | Nombre | Auth |
|--------|-----|--------|:---:|
| GET | `/api/v1/categories` | `api.v1.categories.index` | ❌ |
| GET | `/api/v1/categories/{slug}` | `api.v1.categories.show` | ❌ |

---

## Panel Admin (Filament)

- **Grupo de navegación**: Contenido
- **Icono**: `heroicon-o-tag`
- **Labels**: «Categoría» / «Categorías»
- **Búsqueda global**: Por `slug` y `name`
- **Formulario** (orden de campos):
  1. **Imagen** con cropper 16:9 (`ImageCropField::make16x9`) — ancho completo, primer campo
  2. **Tabs de traducción** (nombre y descripción en ES/EN)
  3. **Slug** + **Orden** — en la misma fila (50%-50%)
  4. **Activo** (toggle) — debajo, ancho completo
- **Listado**: slug, nombre, activo (icono), orden
- **Filtros**: Activo (ternario), Papelera (TrashedFilter)
- **Acciones**: Editar, Eliminar, Restaurar, Eliminar permanentemente
- **Slug auto**: Se genera desde `name` (sobreescribe `getSlugSource()`)

---

## Datos de ejemplo (Seeder)

El `CategorySeeder` crea 5 categorías con traducciones es/en. Es idempotente.
