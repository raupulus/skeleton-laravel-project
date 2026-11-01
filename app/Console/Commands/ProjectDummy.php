<?php

namespace App\Console\Commands;

use App\Enums\EmailStatus;
use App\Models\SentEmail;
use Database\Seeders\DummyDataSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Comando Artisan para poblar datos corporativos realistas en todos los módulos del proyecto.
 * Diseñado para entornos de desarrollo y demostraciones con clientes.
 */
class ProjectDummy extends Command
{
    /**
     * Firma del comando en consola.
     *
     * @var string
     */
    protected $signature = 'project:dummy {--fresh : Ejecuta migrate:fresh antes de insertar datos}';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'Puebla la base de datos con contenido corporativo realista para todos los módulos';

    /**
     * Ejecuta el comando.
     */
    public function handle(): int
    {
        $this->info('=== Generando datos corporativos de ejemplo (project:dummy) ===');

        if (app()->isProduction()) {
            $this->error('⛔ Este comando no debe ejecutarse en entorno de producción.');

            return Command::FAILURE;
        }

        if ($this->option('fresh')) {
            $this->warn('→ Reiniciando base de datos (--fresh)...');
            $this->call('migrate:fresh', ['--force' => true]);
        }

        // 1. Enlace de storage y copia de assets de muestra
        $this->prepareStorageAndAssets();

        // 2. Ejecutar seeders corporativos mediante db:seed
        $this->line('→ Ejecutando seeders corporativos (usuarios, ajustes, categorías, páginas, posts, slides, secciones)...');
        $this->call('db:seed', [
            '--class' => DummyDataSeeder::class,
            '--force' => true,
        ]);

        // 3. Insertar registros de auditoría de emails de muestra
        $this->seedSampleSentEmails();

        $this->newLine();
        $this->info('✓ Todos los módulos han sido poblados con datos corporativos de muestra.');
        $this->table(
            ['Módulo', 'Estado'],
            [
                ['Usuarios (Admin / Editor / Users)', 'Poblado'],
                ['Configuraciones (Settings)', 'Poblado'],
                ['Categorías (Taxonomía)', 'Poblado'],
                ['Páginas (Corporativas / Legales)', 'Poblado'],
                ['Blog (Posts traducibles es/en)', 'Poblado'],
                ['Slides (Carruseles por zona)', 'Poblado'],
                ['Secciones (Bloques dinámicos)', 'Poblado'],
                ['Emails Enviados (Auditoría)', 'Poblado'],
            ]
        );

        return Command::SUCCESS;
    }

    /**
     * Asegura el symlink de storage y copia las imágenes de muestra requeridas.
     */
    protected function prepareStorageAndAssets(): void
    {
        $this->line('→ Verificando enlaces de almacenamiento e imágenes...');

        if (! file_exists(public_path('storage'))) {
            $this->callSilently('storage:link');
            $this->info('  ✓ Enlace simbólico de storage creado.');
        }

        $sourceSlidesDir = public_path('images/default/slides');
        $destSlidesDir = storage_path('app/public/slides');

        if (is_dir($sourceSlidesDir)) {
            File::ensureDirectoryExists($destSlidesDir);
            $copied = 0;
            foreach (File::files($sourceSlidesDir) as $file) {
                $dest = $destSlidesDir.DIRECTORY_SEPARATOR.$file->getFilename();
                if (! file_exists($dest)) {
                    File::copy($file->getPathname(), $dest);
                    $copied++;
                }
            }
            if ($copied > 0) {
                $this->info("  ✓ {$copied} imágenes de slides copiadas a storage.");
            }
        }
    }

    /**
     * Puebla registros de emails enviados para auditoría de ejemplo.
     */
    protected function seedSampleSentEmails(): void
    {
        $this->line('→ Insertando registro de emails enviados (auditoría)...');

        $sampleEmails = [
            [
                'to' => 'admin@example.com',
                'from' => 'noreply@example.com',
                'subject' => 'Bienvenido a Skeleton Platform',
                'body' => '<p>Hola Admin, te damos la bienvenida a la plataforma corporativa.</p>',
                'mailable_class' => 'App\Mail\WelcomeMail',
                'status' => EmailStatus::Sent,
                'error_message' => null,
                'metadata' => ['ip' => '127.0.0.1', 'user_id' => 1],
            ],
            [
                'to' => 'cliente@empresa.com',
                'from' => 'contacto@example.com',
                'subject' => 'Nueva solicitud de contacto recibida',
                'body' => '<p>Hemos recibido tu consulta sobre servicios de consultoría digital.</p>',
                'mailable_class' => 'App\Mail\ContactMail',
                'status' => EmailStatus::Sent,
                'error_message' => null,
                'metadata' => ['subject' => 'Servicios de consultoría', 'ip' => '127.0.0.1'],
            ],
            [
                'to' => 'maria@example.com',
                'from' => 'noreply@example.com',
                'subject' => 'Restablecimiento de contraseña',
                'body' => '<p>Has solicitado restablecer tu contraseña. Haz clic en el enlace para continuar.</p>',
                'mailable_class' => 'App\Mail\GenericMail',
                'status' => EmailStatus::Sent,
                'error_message' => null,
                'metadata' => ['type' => 'password_reset'],
            ],
            [
                'to' => 'error.destino@invalido.local',
                'from' => 'noreply@example.com',
                'subject' => 'Notificación de evento programado',
                'body' => '<p>Recordatorio de evento.</p>',
                'mailable_class' => 'App\Mail\GenericMail',
                'status' => EmailStatus::Failed,
                'error_message' => 'SMTP error 550: Mailbox unavailable or rejected',
                'metadata' => ['retry_count' => 3],
            ],
        ];

        foreach ($sampleEmails as $emailData) {
            SentEmail::firstOrCreate(
                ['to' => $emailData['to'], 'subject' => $emailData['subject']],
                $emailData
            );
        }

        $this->info('  ✓ Registros de auditoría de emails creados.');
    }
}
