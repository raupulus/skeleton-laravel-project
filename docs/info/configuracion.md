# Módulo: Configuración (Settings)

> Ajustes globales de la plataforma en formato clave-valor, agrupados por categoría, cacheados durante 1 hora y accesibles mediante el helper global `setting()`.

---

## Resumen

El módulo de configuración permite gestionar ajustes del sitio (título, descripción, redes sociales, datos de contacto, SEO por defecto, etc.) desde el panel admin sin tocar código. Funciona con un patrón key-value donde cada registro tiene una clave única, un valor, un tipo de dato, un grupo y un orden. Los valores se cachean 1 hora para optimizar el rendimiento.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/Setting.php` |
| Servicio | `app/Services/SettingService.php` |
| Helper global | `app/Helpers/helpers.php` → función `setting()` |
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

Registrado en `composer.json` bajo `autoload.files`. Internamente llama a `app(SettingService::class)->get(...)`.

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
