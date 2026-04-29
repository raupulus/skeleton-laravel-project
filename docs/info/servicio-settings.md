# Módulo: SettingService

> Servicio para acceso cacheado a la configuración del sistema. Interfaz principal para leer settings desde cualquier parte de la aplicación.

---

## Resumen

El `SettingService` carga todos los settings de la BD y los cachea durante 1 hora. Ofrece un método `get()` para leer un setting por clave (con valor por defecto) y un helper global `setting()` para acceder de forma aún más sencilla. La caché se invalida automáticamente al modificar settings desde el panel Filament.

---

## Archivos

| Tipo | Ruta |
|------|------|
| Servicio | `app/Services/SettingService.php` |
| Helper global | `app/Helpers/helpers.php` |
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
- **Invalidación**: `clearCache()` se invoca automáticamente desde los Resources de Filament (`afterSave`) al crear o editar un setting

---

## Helper global `setting()`

```php
// Uso en cualquier parte del código (controladores, vistas, servicios...)
setting('site_title', 'Mi App');  // Devuelve el valor o el default

// En vistas Blade
{{ setting('contact_email', 'info@example.com') }}
```

El helper delega en `app(SettingService::class)->get(...)`.

---

## Dónde se usa

El helper `setting()` se usa extensamente en:
- `resources/views/layouts/head.blade.php` — Meta tags SEO
- `resources/views/layouts/navbar.blade.php` — Logo y nombre del sitio
- `resources/views/layouts/footer.blade.php` — Copyright y redes sociales
- `resources/views/mail/layouts/base.blade.php` — Cabecera de emails
- `app/Services/SeoService.php` — Valores SEO por defecto
- `app/Http/Controllers/Web/ContactController.php` — Email de destino del contacto
