<?php

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Tests para el comando Artisan project:clear.
 * Utiliza un archivo de entorno temporal para no alterar el .env real del proyecto.
 */
class ProjectClearTest extends TestCase
{
    private string $tempEnvDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tempEnvDir = sys_get_temp_dir().'/skeleton_env_'.uniqid();
        File::ensureDirectoryExists($this->tempEnvDir);
        File::put($this->tempEnvDir.'/.env', "APP_NAME=Test\nAPP_KEY=base64:dGVzdGtleXRlc3RrZXl0ZXN0a2V5dGVzdGtleXRlc3Q=\n");

        $this->app->useEnvironmentPath($this->tempEnvDir);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->tempEnvDir);

        parent::tearDown();
    }

    /**
     * Comprueba que project:clear sin --force limpia cachés y omite la rotación de clave.
     */
    public function test_project_clear_without_force_skips_key_rotation(): void
    {
        $this->artisan('project:clear')
            ->expectsOutputToContain('Iniciando limpieza integral del proyecto')
            ->expectsConfirmation('¿Deseas rotar APP_KEY preservando la clave anterior en APP_PREVIOUS_KEYS?', 'no')
            ->expectsOutputToContain('Rotación de APP_KEY omitida')
            ->expectsOutputToContain('Proyecto limpiado')
            ->assertSuccessful();

        $content = File::get($this->tempEnvDir.'/.env');
        $this->assertStringNotContainsString('APP_PREVIOUS_KEYS=', $content);
        $this->assertStringContainsString('APP_KEY=base64:dGVzdGtleXRlc3RrZXl0ZXN0a2V5dGVzdGtleXRlc3Q=', $content);
    }

    /**
     * Comprueba que project:clear --force rota APP_KEY preservando la anterior en APP_PREVIOUS_KEYS.
     */
    public function test_project_clear_with_force_rotates_and_preserves_previous_keys(): void
    {
        $oldKey = 'base64:dGVzdGtleXRlc3RrZXl0ZXN0a2V5dGVzdGtleXRlc3Q=';

        $this->artisan('project:clear', ['--force' => true])
            ->expectsOutputToContain('Clave anterior preservada en APP_PREVIOUS_KEYS')
            ->expectsOutputToContain('Clave APP_KEY regenerada exitosamente')
            ->assertSuccessful();

        $content = File::get($this->tempEnvDir.'/.env');
        $this->assertMatchesRegularExpression('/^APP_KEY=base64:/m', $content);
        $this->assertStringContainsString('APP_PREVIOUS_KEYS='.$oldKey, $content);
        $this->assertStringNotContainsString('APP_KEY='.$oldKey, $content);
    }
}
