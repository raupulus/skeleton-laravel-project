# Módulo: Slides

> Carruseles de imágenes agrupados por zona, con texto traducible (es/en), editor de recorte integrado y soporte para imágenes horizontales (16:9) y verticales (8:12).

---

## Resumen

Los slides alimentan los carruseles visuales del frontend. Se agrupan por `zone` (ej: `home`, `about`, `services`) para que distintas páginas puedan tener sus propios carruseles. Cada slide tiene una imagen principal obligatoria en formato 16:9 (con recorte integrado), una imagen vertical opcional en 8:12, título y contenido traducibles, URL de enlace y control de orden y visibilidad.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Slide.php` |
| Filament Resource | `app/Filament/Admin/Resources/SlideResource.php` |
| Policy | `app/Policies/SlidePolicy.php` |
| Componente Blade | `resources/views/components/slide-carousel.blade.php` |
| Migración | `database/migrations/*_create_slides_table.php` |
| Seeder | `database/seeders/SlideSeeder.php` |

---

## Campos del modelo

| Campo | Tipo | Traducible | Descripción |
|-------|------|:---:|-------------|
| `id` | int (PK) | — | Identificador único |
| `title` | json (nullable) | ✅ | Título superpuesto sobre la imagen (es/en) |
| `content` | json (nullable) | ✅ | Texto descriptivo del slide (es/en) |
| `image` | string | — | **Obligatorio**. Imagen principal recortada a 16:9. Almacenada en `storage/app/public/slides` |
| `image_vertical` | string (nullable) | — | Imagen vertical recortada a 8:12. Para versiones responsive |
| `url` | string (nullable) | — | URL de destino al hacer clic en el slide |
| `zone` | string | — | **Obligatorio**. Identifica el carrusel: `home`, `about`, `services`, etc. |
| `order` | integer | — | Posición dentro de la zona. Menor = primero. Por defecto: 0 |
| `is_active` | boolean | — | Visibilidad en el frontend. Activo por defecto |
| `deleted_at` | datetime (nullable) | — | Soft delete |

---

## Scopes

| Scope | Descripción |
|-------|-------------|
| `forZone($zone)` | Filtra por zona, solo activos, ordenados por `order` |

---

## Traits

- `HasTranslations` — Campos traducibles (spatie/laravel-translatable)
- `SoftDeletes` — Borrado lógico
- `HasFactory` — Factory para tests

---

## Uso en el frontend

El componente Blade `<x-slide-carousel zone="home" />` renderiza el carrusel de la zona indicada usando Alpine.js para la navegación. Carga los slides activos de la zona, ordenados por `order`.

---

## Panel Admin (Filament)

- **Grupo de navegación**: Media
- **Icono**: `heroicon-o-photo`
- **Formulario**: Tabs de traducción (título y contenido en ES/EN) + imagen 16:9 con editor de recorte, imagen vertical 8:12 con editor de recorte, URL, zona, orden, activo
- **Listado**: imagen (miniatura), título, zona, orden, activo. Ordenado por zona por defecto.
- **Recorte de imágenes**: El `FileUpload` usa `imageEditor()` con `imageEditorAspectRatios(['16:9'])` para la imagen principal y `['8:12']` para la vertical

---

## Datos de ejemplo (Seeder)

El `SlideSeeder` crea 10 slides en 3 zonas (home, about, services). Es idempotente.

Las imágenes del seeder apuntan a rutas de storage (`slides/slide-home-1.webp`, etc.) en formato WebP.
Las imágenes de muestra se almacenan en `public/images/default/slides/` y el comando `project:install`
las copia automáticamente en `storage/app/public/slides/` para que el carrusel funcione desde el primer despliegue.
