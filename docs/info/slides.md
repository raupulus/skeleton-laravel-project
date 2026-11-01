# Módulo: Slides

*Última actualización: 2026-11-01*

> Carruseles de imágenes agrupados por zona, con texto traducible (es/en), editor de recorte integrado y soporte para imágenes horizontales (16:9) y verticales (8:12).

---

## Objetivo y funcionalidad

El módulo de slides gestiona los carruseles visuales que se muestran en las distintas páginas del frontend. Su objetivo es permitir que los administradores configuren banners e imágenes destacadas con texto superpuesto, sin necesidad de modificar código ni vistas.

Los slides se agrupan por zonas (ej: `home`, `about`, `services`), de modo que cada página del frontend puede tener su propio carrusel independiente. Cada slide incluye una imagen principal obligatoria en formato 16:9 (con editor de recorte integrado en Filament), una imagen vertical opcional en formato 8:12 para versiones responsive/móvil, título y contenido traducibles (español e inglés), una URL de enlace opcional, y controles de orden y visibilidad.

En el frontend, el componente Blade `<x-slide-carousel zone="home" />` renderiza el carrusel de la zona indicada usando Alpine.js para la navegación entre slides. El componente carga automáticamente solo los slides activos de la zona solicitada, ordenados según el campo `order`.

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

**Accessor disponible**: `$slide->image_url` (`getImageUrlAttribute()`) devuelve la URL pública de la imagen principal vía `Storage::disk('public')->url($this->image)` o `null` si no tiene imagen.

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
- **Formulario** (orden de campos):
  1. **Imagen principal** con cropper 16:9 (`ImageCropField::make16x9`) — obligatoria, ancho completo
  2. **Imagen vertical** con cropper 8:12 (`ImageCropField::make8x12`) — opcional, ancho completo
  3. **Tabs de traducción** (título y contenido en ES/EN)
  4. **URL** — enlace de destino al hacer clic
  5. **Zona** — TextInput con `datalist()` que sugiere zonas existentes y permite crear nuevas
  6. **Orden** — numérico, por defecto 0
  7. **Activo** — toggle
- **Listado**: imagen (miniatura), título, zona, orden, activo. Ordenado por zona por defecto.
- **Filtros**: Zona (select dinámico), Activo (ternario), Papelera (TrashedFilter)
- **Acciones**: Editar, Eliminar, Restaurar, Eliminar permanentemente
- **Cropper**: Usa `imageAspectRatio()` + `automaticallyCropImagesToAspectRatio()` de Filament 5 para forzar las proporciones
- **Invalidación de caché**: Al guardar/eliminar un slide, se invalida la caché `slides_{zone}_ids`

---

## Datos de ejemplo (Seeder)

El `SlideSeeder` crea 10 slides en 3 zonas (home, about, services). Es idempotente.

Las imágenes del seeder apuntan a rutas de storage (`slides/slide-home-1.webp`, etc.) en formato WebP.
Las imágenes de muestra se almacenan en `public/images/default/slides/` y el comando `project:install`
las copia automáticamente en `storage/app/public/slides/` para que el carrusel funcione desde el primer despliegue.
