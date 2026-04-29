# Fase 16 — Comandos

## Resumen
En esta fase se crearán los comandos artisan `project:install` y `project:clear` para facilitar la instalación y mantenimiento del proyecto.

**Dependencias**: Fases 01-15 completadas.

---

## Paso 16.1 — Comando `project:install`

Archivo: `app/Console/Commands/ProjectInstall.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Comando para instalar el proyecto en un entorno de desarrollo.
 *
 * Ejecuta secuencialmente: composer install, npm install, generar key,
 * crear enlace de storage, ejecutar migraciones y seeders.
 * Pide confirmación antes de cada paso destructivo.
 */
class ProjectInstall extends Command
{
    protected $signature = 'project:install
                            {--force : Ejecutar sin pedir confirmación}';

    protected $description = 'Instala y configura el proyecto para desarrollo (dependencias, migraciones, seeders)';

    public function handle(): int
    {
        $this->info('=== Instalación del proyecto ===');
        $this->newLine();

        // 1. Verificar archivo .env
        if (!file_exists(base_path('.env'))) {
            $this->warn('No se encontró archivo .env. Copiando .env.example...');
            copy(base_path('.env.example'), base_path('.env'));
            $this->info('✓ Archivo .env creado desde .env.example');
        }

        // 2. Composer install
        if ($this->option('force') || $this->confirm('¿Ejecutar composer install?', true)) {
            $this->info('Ejecutando composer install...');
            passthru('composer install');
            $this->info('✓ Dependencias PHP instaladas');
        }

        // 3. NPM install
        if ($this->option('force') || $this->confirm('¿Ejecutar npm install?', true)) {
            $this->info('Ejecutando npm install...');
            passthru('npm install');
            $this->info('✓ Dependencias Node.js instaladas');
        }

        // 4. Generar key
        if ($this->option('force') || $this->confirm('¿Generar clave de aplicación?', true)) {
            $this->call('key:generate');
            $this->info('✓ Clave de aplicación generada');
        }

        // 5. Storage link
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
            $this->info('✓ Enlace simbólico de storage creado');
        }

        // 6. Migraciones
        if ($this->option('force') || $this->confirm('¿Ejecutar migraciones de base de datos?', true)) {
            $this->call('migrate', ['--force' => $this->option('force')]);
            $this->info('✓ Migraciones ejecutadas');
        }

        // 7. Seeders
        if ($this->option('force') || $this->confirm('¿Ejecutar seeders con datos iniciales?', true)) {
            $this->call('db:seed', ['--force' => $this->option('force')]);
            $this->info('✓ Seeders ejecutados');
        }

        // 8. Build assets
        if ($this->option('force') || $this->confirm('¿Compilar assets (npm run build)?', true)) {
            $this->info('Compilando assets...');
            passthru('npm run build');
            $this->info('✓ Assets compilados');
        }

        // 9. Generar sitemap
        $this->call('sitemap:generate');
        $this->info('✓ Sitemap generado');

        $this->newLine();
        $this->info('=== Instalación completada ===');
        $this->info('Puedes iniciar el servidor con: php artisan serve');

        return Command::SUCCESS;
    }
}
```

---

## Paso 16.2 — Comando `project:clear`

Archivo: `app/Console/Commands/ProjectClear.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Comando para limpiar toda la caché del proyecto.
 *
 * Útil tras subir cambios a producción o para resolver problemas
 * de caché en desarrollo.
 */
class ProjectClear extends Command
{
    protected $signature = 'project:clear';

    protected $description = 'Limpia toda la caché del proyecto (config, rutas, vistas, eventos, caché general)';

    public function handle(): int
    {
        $this->info('=== Limpiando caché del proyecto ===');
        $this->newLine();

        // Limpiar caché de configuración
        $this->call('config:clear');
        $this->info('✓ Caché de configuración limpiada');

        // Limpiar caché de rutas
        $this->call('route:clear');
        $this->info('✓ Caché de rutas limpiada');

        // Limpiar caché de vistas
        $this->call('view:clear');
        $this->info('✓ Caché de vistas limpiada');

        // Limpiar caché de eventos
        $this->call('event:clear');
        $this->info('✓ Caché de eventos limpiada');

        // Limpiar caché general
        $this->call('cache:clear');
        $this->info('✓ Caché general limpiada');

        // Limpiar caché de Filament
        $this->call('filament:clear-cached-components');
        $this->info('✓ Caché de componentes Filament limpiada');

        // Limpiar caché de optimización
        $this->call('optimize:clear');
        $this->info('✓ Caché de optimización limpiada');

        $this->newLine();
        $this->info('=== Todas las cachés han sido limpiadas ===');

        return Command::SUCCESS;
    }
}
```

---

## Checklist de verificación

- [ ] Comando `project:install` creado con todos los pasos de instalación
- [ ] `project:install` pide confirmación antes de cada paso (excepto con `--force`)
- [ ] `project:install` copia `.env.example` si no existe `.env`
- [ ] Comando `project:clear` creado limpiando: config, routes, views, events, cache, filament, optimize
- [ ] `php artisan project:install --force` funciona sin interacción
- [ ] `php artisan project:clear` ejecutado sin errores
