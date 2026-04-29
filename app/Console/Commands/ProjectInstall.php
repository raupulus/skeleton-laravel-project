<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ProjectInstall extends Command
{
    protected $signature='project:install {--force : Ejecutar sin confirmación}';
    protected $description='Instala y configura el proyecto';

    public function handle(): int
    {
        $this->info('=== Instalación del proyecto ===');
        if(!file_exists(base_path('.env'))){copy(base_path('.env.example'),base_path('.env'));$this->info('✓ .env creado');}
        if($this->option('force')||$this->confirm('¿Ejecutar composer install?',true)){passthru('composer install');}
        if($this->option('force')||$this->confirm('¿Ejecutar npm install?',true)){passthru('npm install');}
        if($this->option('force')||$this->confirm('¿Generar key?',true)){$this->call('key:generate');}
        if(!file_exists(public_path('storage'))){$this->call('storage:link');}
        if($this->option('force')||$this->confirm('¿Ejecutar migraciones?',true)){$this->call('migrate',['--force'=>$this->option('force')]);}
        if($this->option('force')||$this->confirm('¿Ejecutar seeders?',true)){$this->call('db:seed',['--force'=>$this->option('force')]);}
        $this->copySeedImages();
        $this->info('=== Instalación completada ===');
        return Command::SUCCESS;
    }

    /**
     * Copia las imágenes de muestra al storage para que los seeders tengan imágenes reales.
     * Copia public/images/default/slides/ → storage/app/public/slides/
     */
    protected function copySeedImages(): void
    {
        // Copiar imágenes de slides al storage público
        $sourceSlidesDir = public_path('images/default/slides');
        $destSlidesDir   = storage_path('app/public/slides');

        if (!is_dir($sourceSlidesDir)) {
            $this->warn('⚠ No se encontró el directorio de slides de muestra: ' . $sourceSlidesDir);
            return;
        }

        File::ensureDirectoryExists($destSlidesDir);

        $copied = 0;
        foreach (File::files($sourceSlidesDir) as $file) {
            $dest = $destSlidesDir . DIRECTORY_SEPARATOR . $file->getFilename();
            if (!file_exists($dest)) {
                File::copy($file->getPathname(), $dest);
                $copied++;
            }
        }

        if ($copied > 0) {
            $this->info("✓ {$copied} imágenes de slides copiadas al storage");
        } else {
            $this->info('✓ Imágenes de slides ya presentes en storage');
        }
    }
}

