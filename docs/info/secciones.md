# Módulo: Secciones

> Bloques de contenido dinámico del frontend, agrupados por zona, con título, descripción y contenido enriquecido traducibles (es/en). Editables desde el backend sin tocar código.

---

## Resumen

Las secciones permiten gestionar bloques de contenido reutilizables que se muestran en las distintas páginas del frontend (home, about, contact, etc.). Cada sección tiene título, descripción, contenido HTML enriquecido e imagen, todo traducible. Se agrupan por `zone` y se ordenan con el campo `order`. El componente Blade `<x-section-block>` las renderiza automáticamente con el idioma del visitante.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Section.php` |
| Filament Resource | `app/Filament/Admin/Resources/SectionResource.php` |
| Policy | `app/Policies/SectionPolicy.php` |
| Componente Blade | `resources/views/components/section-block.blade.php` |
| Migración | `database/migrations/*_create_sections_table.php` |
| Seeder | `database/seeders/SectionSeeder.php` |

---

## Campos del modelo

| Campo | Tipo | Traducible | Descripción |
|-------|------|:---:|-------------|
| `id` | int (PK) | — | Identificador único |
| `slug` | string (unique) | — | Identificador URL, autogenerado desde el título |
| `zone` | string | — | **Obligatorio**. Zona del frontend: `home`, `about`, `contact`, etc. |
| `title` | json (nullable) | ✅ | Título de la sección (es/en) |
| `description` | json (nullable) | ✅ | Descripción/subtítulo (es/en) |
| `content` | json (nullable) | ✅ | Contenido HTML enriquecido (es/en), editado con RichEditor |
| `image` | string (nullable) | — | Imagen asociada, almacenada en `storage/app/public/sections` |
| `order` | integer | — | Posición dentro de la zona (menor = primero). Por defecto: 0 |
| `deleted_at` | datetime (nullable) | — | Soft delete |

---

## Scopes

| Scope | Descripción |
|-------|-------------|
| `forZone($zone)` | Filtra por zona y ordena por `order` ascendente |

---

## Traits

- `HasSlug` — Genera slug único desde el título
- `HasTranslations` — Campos traducibles (spatie/laravel-translatable)
- `SoftDeletes` — Borrado lógico
- `HasFactory` — Factory para tests

---

## Uso en el frontend

Las secciones se cargan en los controladores (ej: `HomeController` carga las de zona `home`) y se renderizan mediante el componente `<x-section-block :section="$section" />`. El componente muestra título, descripción, contenido e imagen en el idioma actual del visitante.

---

## Panel Admin (Filament)

- **Grupo de navegación**: Frontend
- **Icono**: `heroicon-o-squares-2x2`
- **Labels**: «Sección» / «Secciones»
- **Formulario**: Tabs de traducción (título, descripción y contenido/RichEditor en ES/EN) + slug, zona, imagen, orden
- **Listado**: slug, zona, título, orden. Ordenado por zona por defecto.

---

## Datos de ejemplo (Seeder)

El `SectionSeeder` crea 7 secciones en 3 zonas (home, about, contact). Es idempotente.
