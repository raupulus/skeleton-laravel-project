# Acciones Admin

*Última actualización: 2026-08-26*

Sección del panel admin con acciones de mantenimiento del sistema. Accesible solo para usuarios con rol admin o superadmin. Aparece como último grupo en el menú lateral ("Acciones", después de "Sistema").

## Archivos principales

- `app/Filament/Admin/Pages/RegenerateSitemap.php` — Página de regeneración del sitemap
- `app/Filament/Admin/Pages/ClearCache.php` — Página de limpieza de caché
- `app/Filament/Admin/Pages/ViewLogs.php` — Página de visualización de logs
- `app/Http/Controllers/Web/LogDownloadController.php` — Controlador de descarga segura de logs
- `resources/views/filament/admin/pages/regenerate-sitemap.blade.php`
- `resources/views/filament/admin/pages/clear-cache.blade.php`
- `resources/views/filament/admin/pages/view-logs.blade.php`
- `app/Filament/Admin/Widgets/LogDownloadWidget.php` — Widget de descarga de logs en el dashboard
- `resources/views/filament/admin/widgets/log-download.blade.php`

## Páginas

### Regenerar Sitemap
- **Icono navegación:** `heroicon-o-globe-alt`
- **Grupo de navegación:** Acciones
- Vista: descripción de texto sin icono grande, solo texto informativo
- Ejecuta el comando `php artisan sitemap:generate` desde una acción del header
- Modal de confirmación antes de ejecutar
- Notificación de éxito tras completar

### Limpiar Caché
- **Icono navegación:** `heroicon-o-trash`
- **Grupo de navegación:** Acciones
- Vista: descripción de texto sin icono grande + panel de advertencias (fondo amber)
- Ejecuta el comando `php artisan project:clear` desde una acción del header
- Modal de confirmación con listado de consecuencias:
  - Cierre de sesiones activas
  - Vaciado de caché de datos
  - Interrupción de colas de eventos
  - Primera carga más lenta

### Ver Logs
- **Icono navegación:** `heroicon-o-document-magnifying-glass`
- **Grupo de navegación:** Acciones
- Vista: descripción + tabla con `<x-filament::section>` con `table-layout: fixed` y `<colgroup>` con anchos porcentuales (35%, 15%, 22%, 28%)
- Lista archivos `.log` de `storage/logs/` ordenados por fecha descendente
- Columnas: Archivo, Tamaño, Última modificación, Acciones (Ver/Descargar con iconos)
- Permite ver contenido del log en un modal fullscreen (últimas 500 líneas)
- Permite descargar archivos de log

## Widget de Dashboard — LogDownloadWidget
- Estructura idéntica al AccountWidget de Filament (misma clase CSS `fi-account-widget`)
- A la izquierda: botón de descarga (solo icono, flecha) con tooltip
- Centro (flex-1): título "Descargar log de errores" + tamaño en MB
- A la derecha: botón "Ver Logs" con icono
- Orden: -2 (justo después del AccountWidget)

## Rutas
- Las páginas de acciones se descubren automáticamente vía `discoverPages()` en `AdminPanelProvider`
- Ruta de descarga: `GET /admin/logs/download/{filename}` — controlador `LogDownloadController`, middleware `auth`, verificación de rol admin
- Nombre de ruta: `admin.logs.download`

## Traducciones
- Todas las keys en `lang/es/filament.php` y `lang/en/filament.php`
- Prefijo: `regenerate_sitemap_*`, `clear_cache_*`, `view_logs_*`, `download_error_log`

## Seguridad
- Las páginas solo son accesibles para admin/superadmin (protegido por el panel Filament)
- La ruta de descarga verifica `auth()->user()->role->isAdmin()`
- Protección contra path traversal con `realpath()` + `str_starts_with()`
