# Módulo: Configuración (Settings)

*Última actualización: 2026-11-01*

> Ajustes globales de la plataforma en formato clave-valor, agrupados por categoría, cacheados durante 1 hora y accesibles mediante el helper global `setting()`.

---

## Objetivo y funcionalidad

El módulo de configuración permite gestionar los ajustes globales del sitio web desde el panel de administración, sin necesidad de modificar archivos `.env` ni código fuente. Su objetivo es centralizar toda la configuración dinámica de la plataforma (nombre del sitio, datos de contacto, URLs de redes sociales, valores SEO por defecto, logotipo, etc.) en un sistema key-value editable en tiempo real.

Cada setting tiene una clave única, un valor, un tipo de dato (text, textarea, image, number), un grupo de clasificación (general, contact, social, seo) y un orden de visualización. Los valores se cachean durante 1 hora para optimizar el rendimiento, y la caché se invalida automáticamente al editar cualquier setting desde Filament.

El acceso a los settings desde cualquier parte de la aplicación se realiza mediante el helper global `setting('clave', 'valor_por_defecto')`, que internamente consulta el `SettingService`. Esto permite que las vistas Blade, controladores, servicios y mailables consuman la configuración de forma sencilla y uniforme. Los settings se utilizan extensivamente en el layout (logo, nombre del sitio, redes sociales, copyright), en el servicio SEO (meta tags por defecto), en el envío de emails (dirección de contacto) y en múltiples componentes del frontend.

---

## Resumen

El módulo de configuración permite gestionar ajustes del sitio (título, descripción, redes sociales, datos de contacto, SEO por defecto, etc.) desde el panel admin sin tocar código. Funciona con un patrón key-value donde cada registro tiene una clave única, un valor, un tipo de dato, un grupo y un orden. Los valores se cachean 1 hora para optimizar el rendimiento.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Setting.php` |
| Servicio | `app/Services/SettingService.php` |
| Helpers globales | `app/Helpers/helpers.php` → `setting()`, `media_url()`, `storage_image()`, `format_date()` |
| Filament Resource | `app/Filament/Admin/Resources/SettingResource.php` |
| Policy | `app/Policies/SettingPolicy.php` |
| Migración | `database/migrations/*_create_settings_table.php` |
| Seeder | `database/seeders/SettingSeeder.php` |

---

## Campos del modelo

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int (PK) | Identificador único |
| `key` | string (unique) | Clave única en snake_case (ej: `site_title`, `contact_email`) |
| `display_name` | string | Nombre legible para el panel admin |
| `value` | text (nullable) | Valor actual de la configuración |
| `details` | text (nullable) | Descripción interna/ayuda del propósito del setting |
| `type` | string | Tipo de dato: `text`, `textarea`, `image`, `number` |
| `order` | integer | Posición dentro de su grupo |
| `group` | string | Grupo: `general`, `seo`, `social`, `contact` |

---

## Scopes

| Scope | Descripción |
|-------|-------------|
| `byGroup($group)` | Filtra por grupo y ordena por `order` |

---

## SettingService

Clase: `App\Services\SettingService`

| Método | Firma | Descripción |
|--------|-------|-------------|
| `get()` | `get(string $key, mixed $default = null): mixed` | Obtiene un setting por clave con caché |
| `all()` | `all(): array` | Devuelve todos los settings como array `[key => value]` |
| `clearCache()` | `clearCache(): void` | Invalida la caché, forzando recarga desde BD |

**Caché**: Los settings se cachean bajo la clave `settings_all` durante 3600 segundos (1 hora). La caché se limpia automáticamente al guardar/editar desde Filament.

---

## Helper global

```php
setting('site_title', 'Valor por defecto');
```

Registrado en `composer.json` bajo `autoload.files` junto con `media_url()`, `storage_image()` y `format_date()`. Internamente llama a `app(SettingService::class)->get(...)`.

---

## Settings predefinidos (Seeder)

| Clave | Grupo | Descripción |
|-------|-------|-------------|
| `site_title` | general | Nombre del sitio |
| `site_description` | general | Descripción general |
| `site_logo` | general | Ruta del logotipo |
| `contact_email` | contact | Email de contacto |
| `contact_phone` | contact | Teléfono de contacto |
| `contact_address` | contact | Dirección postal |
| `facebook_url` | social | URL de Facebook |
| `twitter_url` | social | URL de Twitter/X |
| `instagram_url` | social | URL de Instagram |
| `linkedin_url` | social | URL de LinkedIn |
| `default_meta_keywords` | seo | Keywords SEO por defecto |
| `default_meta_description` | seo | Descripción SEO por defecto |

---

## Panel Admin (Filament)

- **Grupo de navegación**: Sistema
- **Icono**: `heroicon-o-cog-6-tooth`
- **Labels**: «Configuración» / «Configuraciones»
- **Formulario**: key, display_name, value (textarea), details, type (select), order, group
- **Listado**: key, display_name, value (truncado 50 chars), group. Ordenado por grupo.
- **Al guardar**: Se ejecuta `SettingService::clearCache()` para invalidar la caché inmediatamente
