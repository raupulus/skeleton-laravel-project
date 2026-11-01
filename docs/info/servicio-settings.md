# Módulo: SettingService y Helpers Globales

*Última actualización: 2026-11-01*

> Servicio para acceso cacheado a la configuración del sistema y funciones helper globales cargadas vía Composer (`setting()`, `media_url()`, `storage_image()`, `format_date()`).

---

## Objetivo y funcionalidad

El `SettingService` es la capa de acceso a los ajustes de configuración del sistema almacenados en la base de datos. Su objetivo es proporcionar una interfaz rápida, cacheada y sencilla para leer los settings desde cualquier punto de la aplicación (controladores, vistas Blade, servicios, mailables), evitando consultas repetitivas a la base de datos.

El servicio carga todos los settings de la BD en una sola consulta, los cachea durante 1 hora y expone métodos para consultar por clave individual o recuperar todos los settings de golpe. La caché se invalida automáticamente cuando se edita cualquier setting desde el panel de administración de Filament, garantizando que los cambios se reflejen de forma inmediata.

Para mayor comodidad, el archivo `app/Helpers/helpers.php` expone el helper global `setting('clave', 'valor_por_defecto')` junto con utilidades adicionales para resolver URLs de medios y formatear fechas en las vistas Blade.

---

## Resumen

El `SettingService` carga todos los settings de la BD y los cachea durante 1 hora. Ofrece un método `get()` para leer un setting por clave (con valor por defecto) y un helper global `setting()` para acceder de forma aún más sencilla. La caché se invalida automáticamente al modificar settings desde el panel Filament.

---

## Archivos

| Tipo | Ruta |
|------|------|
| Servicio | `app/Services/SettingService.php` |
| Helpers globales | `app/Helpers/helpers.php` |
| Registro autoload | `composer.json` → `autoload.files` |

---

## API del servicio

| Método | Firma | Descripción |
|--------|-------|-------------|
| `get()` | `get(string $key, mixed $default = null): mixed` | Obtiene un setting por clave. Devuelve `$default` si no existe |
| `all()` | `all(): array` | Devuelve todos los settings como `['key' => 'value', ...]` |
| `clearCache()` | `clearCache(): void` | Invalida la caché, forzando recarga en la próxima llamada |

---

## Caché

- **Clave de caché**: `settings_all`
- **TTL**: 3600 segundos (1 hora)
- **Driver**: El configurado en `config('cache.default')`
- **Invalidación**: `clearCache()` se invoca automáticamente desde `SettingResource` (`afterSave`) al crear o editar un setting

---

## Helpers globales (`app/Helpers/helpers.php`)

| Función | Firma | Descripción |
|---------|-------|-------------|
| `setting()` | `setting(string $key, mixed $default = null): mixed` | Obtiene el valor de un setting delegando en `app(SettingService::class)->get($key, $default)` |
| `media_url()` | `media_url(?string $path, ?string $default = null): ?string` | Resuelve una ruta o URL de imagen: respeta URLs absolutas (`http://`, `https://`, `//`), assets estáticos (`images/...`) y rutas relativas del disco `public` (`Storage::disk('public')->url($path)`) |
| `storage_image()` | `storage_image(?string $path, ?string $default = null): ?string` | Alias semántico de `media_url()` para vistas Blade |
| `format_date()` | `format_date(mixed $date, string $format = 'd/m/Y'): string` | Formatea instancias `DateTimeInterface` o cadenas de fecha con `Carbon::parse($date)->translatedFormat($format)` |

```php
// Uso en cualquier parte del código (controladores, vistas, servicios...)
setting('site_title', 'Mi App');

// En vistas Blade
{{ setting('contact_email', 'info@example.com') }}
{{ media_url($post->image, asset('images/defaults/no-image.webp')) }}
{{ format_date($post->published_at, 'd M, Y') }}
```

---

## Dónde se usa `setting()`

El helper `setting()` se usa extensamente en:
- `resources/views/layouts/head.blade.php` — Meta tags SEO
- `resources/views/layouts/navbar.blade.php` — Logo y nombre del sitio
- `resources/views/layouts/footer.blade.php` — Copyright y redes sociales
- `resources/views/mail/layouts/base.blade.php` — Cabecera de emails
- `app/Services/SeoService.php` — Valores SEO por defecto
- `app/Http/Controllers/Web/ContactController.php` — Email de destino del contacto
