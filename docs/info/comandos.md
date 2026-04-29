# Módulo: Comandos Artisan

> Comandos personalizados para instalación del proyecto, limpieza de caché, generación de sitemap y generación de PDFs de manuales.

---

## Resumen

La plataforma incluye cuatro comandos Artisan personalizados que automatizan tareas comunes de desarrollo, mantenimiento y documentación.

---

## project:install

**Archivo**: `app/Console/Commands/ProjectInstall.php`

Instala y configura el proyecto completo de forma interactiva.

```bash
php artisan project:install
php artisan project:install --force  # Sin confirmaciones (para Docker/CI)
```

**Acciones que realiza:**
1. Copia `.env.example` a `.env` (si no existe)
2. Genera la clave de la aplicación (`key:generate`)
3. Crea el enlace simbólico de storage (`storage:link`)
4. Ejecuta migraciones
5. Ejecuta seeders
6. **Copia imágenes de muestra de slides** desde `public/images/default/slides/` a `storage/app/public/slides/` para que el carrusel tenga imágenes funcionales desde el primer despliegue

---

## project:clear

**Archivo**: `app/Console/Commands/ProjectClear.php`

Limpia toda la caché del proyecto de una sola vez.

```bash
php artisan project:clear
```

**Cachés que limpia:**
- Config cache (`config:clear`)
- Route cache (`route:clear`)
- View cache (`view:clear`)
- Event cache (`event:clear`)
- Application cache (`cache:clear`)
- Optimización (`optimize:clear`)

---

## sitemap:generate

**Archivo**: `app/Console/Commands/GenerateSitemap.php`

Genera el archivo `public/sitemap.xml` con todas las URLs públicas del sitio.

```bash
php artisan sitemap:generate
```

Internamente delega en `SitemapService::generate()`. Ver [SitemapService](servicio-sitemap.md) para detalle de URLs incluidas.

---

## manual:generate-pdf

**Archivo**: `app/Console/Commands/GenerateManualPdf.php`

Genera un PDF por cada subdirectorio de `docs/manual/` a partir de los archivos Markdown.

```bash
php artisan manual:generate-pdf
```

**Comportamiento:**
1. Lee cada subdirectorio de `docs/manual/` (admin, user_backend, user)
2. Ordena los archivos `.md` alfabéticamente
3. Convierte Markdown a HTML con `league/commonmark` (con soporte tablas)
4. Genera un PDF con `barryvdh/laravel-dompdf` incluyendo portada, estilos profesionales y salto de página entre secciones
5. Guarda el PDF en `docs/manual/{directorio}.pdf`

**Dependencias**: `barryvdh/laravel-dompdf`, `league/commonmark`
