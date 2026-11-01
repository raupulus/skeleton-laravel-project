<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

/**
 * Comando Artisan para limpiar todas las cachés, colas,
 * regenerar opcionalmente la clave de cifrado de forma segura y recomponer el autoload.
 */
class ProjectClear extends Command
{
    /**
     * La firma del comando en consola.
     *
     * @var string
     */
    protected $signature = 'project:clear {--force : Ejecutar sin confirmación (incluye rotación de APP_KEY)}';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Limpia todo el caché, colas, regenera opcionalmente la clave del .env de forma segura y recompone el autoload';

    /**
     * Ejecuta el comando.
     */
    public function handle(): int
    {
        $this->info('=== Iniciando limpieza integral del proyecto ===');

        // 1. Limpiar todas las cachés del framework
        $this->clearCaches();

        // 2. Limpiar y reiniciar colas
        $this->clearQueues();

        // 3. Rotar clave .env solo si se pasa --force o el usuario lo confirma en consola interactiva
        if ($this->shouldRotateKey()) {
            $this->regenerateKeySecurely();
        } else {
            $this->line('→ Rotación de APP_KEY omitida (pasa --force para rotarla sin preguntar).');
        }

        // 4. Recomponer el autoload de Composer
        $this->recomposeAutoload();

        $this->newLine();
        $this->info('✓ Proyecto limpiado, colas reseteadas y autoload recompuesto.');

        return Command::SUCCESS;
    }

    /**
     * Determina si debe rotarse APP_KEY.
     */
    protected function shouldRotateKey(): bool
    {
        if ($this->option('force')) {
            return true;
        }

        if (! $this->input->isInteractive()) {
            return false;
        }

        return $this->confirm('¿Deseas rotar APP_KEY preservando la clave anterior en APP_PREVIOUS_KEYS?', false);
    }

    /**
     * Limpia todas las capas de caché de Laravel.
     */
    protected function clearCaches(): void
    {
        $this->line('→ Limpiando cachés...');
        $this->callSilently('config:clear');
        $this->callSilently('route:clear');
        $this->callSilently('view:clear');
        $this->callSilently('event:clear');
        $this->callSilently('cache:clear');
        $this->callSilently('optimize:clear');
        $this->info('  ✓ Cachés de configuración, rutas, vistas, eventos y aplicación eliminadas.');
    }

    /**
     * Limpia y reinicia el servicio de colas.
     */
    protected function clearQueues(): void
    {
        $this->line('→ Limpiando colas...');
        try {
            $this->callSilently('queue:clear', ['--force' => true]);
        } catch (\Throwable) {
            // El driver puede no soportar queue:clear (ej: sync)
        }
        $this->callSilently('queue:restart');
        $this->info('  ✓ Colas limpiadas y workers reiniciados.');
    }

    /**
     * Regenera la clave de cifrado APP_KEY de forma segura en el archivo .env.
     * Si la clave ya existía, preserva la anterior en APP_PREVIOUS_KEYS
     * para permitir el descifrado de cargas existentes (rotación segura).
     */
    protected function regenerateKeySecurely(): void
    {
        $this->line('→ Gestionando clave de cifrado .env de forma segura...');
        $envPath = $this->laravel->environmentFilePath();

        if (! File::exists($envPath)) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
                $this->info('  ✓ Archivo .env creado a partir de .env.example');
            } else {
                $this->warn('  ⚠ No se encontró archivo .env ni .env.example.');

                return;
            }
        }

        $envContent = File::get($envPath);
        preg_match('/^APP_KEY=(.*)$/m', $envContent, $keyMatches);
        $currentKey = trim($keyMatches[1] ?? '');

        // Si ya hay una clave activa, la preservamos en APP_PREVIOUS_KEYS para rotación segura
        if (! empty($currentKey)) {
            preg_match('/^APP_PREVIOUS_KEYS=(.*)$/m', $envContent, $prevMatches);
            $existingPrevious = trim($prevMatches[1] ?? '');

            $previousList = array_values(array_filter(explode(',', $existingPrevious)));
            if (! in_array($currentKey, $previousList, true)) {
                array_unshift($previousList, $currentKey);
            }
            $newPreviousStr = implode(',', $previousList);

            if (preg_match('/^APP_PREVIOUS_KEYS=/m', $envContent)) {
                $envContent = (string) preg_replace(
                    '/^APP_PREVIOUS_KEYS=.*$/m',
                    'APP_PREVIOUS_KEYS='.$newPreviousStr,
                    $envContent
                );
            } else {
                $envContent = (string) preg_replace(
                    '/^APP_KEY=.*$/m',
                    "APP_KEY={$currentKey}\nAPP_PREVIOUS_KEYS={$newPreviousStr}",
                    $envContent
                );
            }
        }

        // Generar una nueva clave y escribirla en el archivo de entorno configurado
        $newKey = 'base64:'.base64_encode(random_bytes(32));
        if (preg_match('/^APP_KEY=/m', $envContent)) {
            $envContent = (string) preg_replace('/^APP_KEY=.*$/m', 'APP_KEY='.$newKey, $envContent);
        } else {
            $envContent .= "\nAPP_KEY={$newKey}\n";
        }

        File::put($envPath, $envContent);
        config(['app.key' => $newKey]);

        if (! empty($currentKey)) {
            $this->info('  ✓ Clave anterior preservada en APP_PREVIOUS_KEYS para descifrado seguro.');
        }
        $this->info('  ✓ Clave APP_KEY regenerada exitosamente.');
    }

    /**
     * Recompone el mapa de clases del autoload de Composer.
     */
    protected function recomposeAutoload(): void
    {
        $this->line('→ Recomponiendo el autoload de Composer...');

        $process = new Process(['composer', 'dump-autoload'], base_path());
        $process->setTimeout(120);

        try {
            $process->run();
            if ($process->isSuccessful()) {
                $this->info('  ✓ Autoload recompuesto con éxito.');
            } else {
                $this->warn('  ⚠ composer dump-autoload finalizó con advertencias: '.trim($process->getErrorOutput()));
            }
        } catch (\Throwable $e) {
            $this->warn('  ⚠ No se pudo ejecutar composer dump-autoload automáticamente ('.$e->getMessage().'). Ejecútalo manualmente si es necesario.');
        }
    }
}
