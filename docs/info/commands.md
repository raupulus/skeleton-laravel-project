# Módulo: Comandos Artisan

*Última actualización: 2026-11-01*

> Catálogo y especificación técnica exhaustiva de los comandos Artisan personalizados de la plataforma.

---

## Resumen

La plataforma incluye 5 comandos Artisan personalizados en `app/Console/Commands/` para automatizar la instalación inicial, la limpieza profunda y rotación segura de claves, la carga de datos corporativos de muestra, la generación del sitemap XML y la compilación de los manuales de usuario en PDF.

| Comando | Firma | Archivo | Propósito |
|---------|-------|---------|-----------|
| **project:install** | `project:install {--force}` | `app/Console/Commands/ProjectInstall.php` | Instalación inicial guiada o desatendida del entorno, dependencias (`composer` + `pnpm`), migraciones, seeders y compilación de assets |
| **project:clear** | `project:clear {--force}` | `app/Console/Commands/ProjectClear.php` | Limpieza integral de cachés y colas, rotación segura opcional de `APP_KEY` (preservando `APP_PREVIOUS_KEYS`) y `composer dump-autoload` |
| **project:dummy** | `project:dummy {--fresh}` | `app/Console/Commands/ProjectDummy.php` | Población de datos corporativos de muestra en todos los módulos (bloqueado en producción) |
| **sitemap:generate** | `sitemap:generate` | `app/Console/Commands/GenerateSitemap.php` | Generación de `public/sitemap.xml` con alternates `hreflang` para todas las rutas públicas |
| **manual:generate-pdf** | `manual:generate-pdf` | `app/Console/Commands/GenerateManualPdf.php` | Compilación de los manuales Markdown (`docs/manual/`) a PDFs corporativos con DomPDF |

---

## 1. `php artisan project:install`

**Archivo**: `app/Console/Commands/ProjectInstall.php`

Automatiza la puesta en marcha inicial del proyecto en desarrollo o contenedores Docker. Puede ejecutarse de forma interactiva (preguntando cada paso) o desatendida con `--force`.

```bash
# Modo interactivo (pregunta antes de cada paso):
php artisan project:install

# Modo desatendido (ejecuta todos los pasos sin confirmación):
php artisan project:install --force
```

### Flujo de ejecución:
1. **Archivo `.env`**: Si no existe `.env`, copia `.env.example`.
2. **Dependencias PHP**: Ejecuta `composer install`.
3. **Dependencias JS**: Ejecuta `pnpm install`.
4. **Clave de aplicación**: Ejecuta `php artisan key:generate`.
5. **Enlace de storage**: Si no existe `public/storage`, ejecuta `php artisan storage:link`.
6. **Migraciones**: Ejecuta `php artisan migrate` (con `--force` si se indicó).
7. **Imágenes de muestra**: Copia `public/images/default/slides/*` a `storage/app/public/slides/`.
8. **Seeders iniciales**: Ejecuta `php artisan db:seed`.
9. **Compilación de assets**: Ejecuta `pnpm run build`.

---

## 2. `php artisan project:clear`

**Archivo**: `app/Console/Commands/ProjectClear.php`

Realiza una limpieza profunda de la aplicación y recompone el mapa de clases de Composer. La rotación de `APP_KEY` **solo se ejecuta si el usuario lo confirma interactivamente o pasa `--force`**, evitando invalidar sesiones o datos cifrados por accidente.

```bash
# Limpieza de cachés, colas y autoload (pregunta si deseas rotar APP_KEY):
php artisan project:clear

# Limpieza completa incluyendo rotación automática de APP_KEY sin confirmación:
php artisan project:clear --force
```

### Flujo de ejecución:
1. **Cachés de Laravel (`clearCaches`)**: Ejecuta `config:clear`, `route:clear`, `view:clear`, `event:clear`, `cache:clear` y `optimize:clear`.
2. **Colas (`clearQueues`)**: Ejecuta `queue:clear --force` (ignorando drivers que no lo soporten, como `sync`) y `queue:restart`.
3. **Rotación segura de `APP_KEY` (`regenerateKeySecurely`)** *(solo con confirmación o `--force`)*:
   - Lee el archivo de entorno mediante `$this->laravel->environmentFilePath()`.
   - Si ya existía una clave en `APP_KEY`, la antepone a la lista separada por comas de `APP_PREVIOUS_KEYS` para que Laravel pueda seguir descifrando valores antiguos.
   - Genera y escribe una nueva clave `base64:...` de 32 bytes.
4. **Autoload de Composer (`recomposeAutoload`)**: Ejecuta `composer dump-autoload` mediante `Symfony\Component\Process\Process`.

> **Nota**: La página **Limpiar Caché** del panel Filament (`/admin/clear-cache`) no invoca `project:clear`; ejecuta únicamente `optimize:clear` y `cache:clear` para no rotar la clave ni lanzar procesos de consola desde peticiones web.

---

## 3. `php artisan project:dummy`

**Archivo**: `app/Console/Commands/ProjectDummy.php`  
**Seeder asociado**: `Database\Seeders\DummyDataSeeder`

Puebla todos los módulos de la plataforma con datos corporativos realistas bilingües (ES/EN) para desarrollo, pruebas y demostraciones con clientes.

```bash
# Inserción idempotente de datos sobre la BD actual:
php artisan project:dummy

# Reinicio completo de base de datos (migrate:fresh) antes de insertar datos:
php artisan project:dummy --fresh
```

### Módulos poblados:
1. **Usuarios (`UserSeeder`)**: `admin@example.com` (`superadmin`), `editor@example.com` (`admin`) y 10 usuarios con rol `user`.
2. **Configuraciones (`SettingSeeder`)**: 12 settings globales en los grupos `general`, `contact`, `social` y `seo`.
3. **Categorías (`CategorySeeder`)**: 5 categorías traducibles (ES/EN).
4. **Páginas (`PageSeeder`)**: 12 páginas traducibles (incluyendo `politica-privacidad` y `politica-cookies`).
5. **Blog (`PostSeeder`)**: Artículos con extractos, categorías, imágenes y traducciones ES/EN.
6. **Carruseles (`SlideSeeder`)**: 10 slides en zonas `home`, `about` y `services`.
7. **Secciones (`SectionSeeder`)**: 7 bloques dinámicos en zonas `home`, `about` y `contact`.
8. **Emails Enviados (`SentEmail`)**: Registros de auditoría de muestra (`sent` y `failed`).
9. **Assets**: Crea el enlace `storage:link` si falta y copia imágenes de muestra a `storage/app/public/{slides,posts,pages,categories,sections}`.

> ⚠️ **Guarda de seguridad**: Si `app()->isProduction()` es `true`, el comando aborta inmediatamente con código de error.

---

## 4. `php artisan sitemap:generate`

**Archivo**: `app/Console/Commands/GenerateSitemap.php`  
**Servicio**: `App\Services\SitemapService`

Genera dinámicamente `public/sitemap.xml` (ignorado en Git) con todas las rutas públicas e idiomas configurados en `config('locales.available')`.

```bash
php artisan sitemap:generate
```

### Programación periódica (`routes/console.php`):
```php
Schedule::command('sitemap:generate')->dailyAt('03:00');
```

---

## 5. `php artisan manual:generate-pdf`

**Archivo**: `app/Console/Commands/GenerateManualPdf.php`

Compila los manuales Markdown de `docs/manual/{admin,user_backend,user}/` y genera:
- `docs/manual/admin.pdf`
- `docs/manual/user_backend.pdf`
- `docs/manual/user.pdf`

```bash
php artisan manual:generate-pdf
```
