# Módulo: Traits

*Última actualización: 2026-08-26*

> Traits reutilizables que encapsulan comportamiento compartido entre modelos: generación de slug, estados de contenido, campos SEO y asignación de autor.

---

## Resumen

La plataforma utiliza cuatro traits para evitar duplicación de lógica entre los modelos de contenido. Los traits se registran automáticamente en los modelos que los usan y proporcionan scopes, relaciones, eventos y métodos helper.

---

## HasSlug

**Archivo**: `app/Traits/HasSlug.php`

Genera automáticamente un slug URL-friendly único al crear un registro.

| Característica | Detalle |
|---------------|---------|
| **Evento** | `creating` — solo genera slug si el campo está vacío |
| **Fuente** | Campo `title` por defecto (sobreescribible con `getSlugSource()`) |
| **Traducciones** | Si la fuente es un array (campo traducible), usa el idioma actual → fallback → primer valor |
| **Unicidad** | Verifica contra la BD (incluyendo soft-deleted) y añade sufijo numérico si existe (`-1`, `-2`...) |

**Usado en**: Post, Page, Category, Section

---

## HasStatus

**Archivo**: `app/Traits/HasStatus.php`

Gestiona el estado de publicación de contenido con scopes y helpers.

| Scope/Método | Tipo | Descripción |
|--------------|------|-------------|
| `published()` | scope | Solo contenido con `status = published` |
| `draft()` | scope | Solo contenido con `status = draft` |
| `publishedAndActive()` | scope | `status = published` AND `is_active = true` |
| `isPublished()` | bool | Comprueba si el estado es `published` |
| `isDraft()` | bool | Comprueba si el estado es `draft` |

**Usado en**: Post, Page

---

## HasSeo

**Archivo**: `app/Traits/HasSeo.php`

Proporciona métodos para obtener campos SEO del modelo con fallbacks jerárquicos.

| Método | Fallback | Descripción |
|--------|----------|-------------|
| `getSeoTitleText()` | `seo_title` → `title` → `''` | Título SEO para el idioma actual |
| `getSeoDescriptionText()` | `seo_description` → `excerpt` → `''` | Descripción SEO |
| `getSeoKeywordsText()` | `seo_keywords` → `''` | Keywords SEO |

Los métodos soportan tanto campos simples como arrays de traducciones.

**Usado en**: Post, Page

---

## BelongsToUser

**Archivo**: `app/Traits/BelongsToUser.php`

Asigna automáticamente el usuario autenticado como autor al crear contenido.

| Característica | Detalle |
|---------------|---------|
| **Evento** | `creating` — asigna `user_id = auth()->id()` si está vacío y hay usuario logueado |
| **Relación** | `user(): BelongsTo` → acceso al autor con `$model->user` |
| **Scope** | `byUser($userId)` — filtra por usuario propietario |

**Usado en**: Post, Page
