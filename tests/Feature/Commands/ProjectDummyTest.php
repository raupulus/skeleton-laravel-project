<?php

namespace Tests\Feature\Commands;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Section;
use App\Models\SentEmail;
use App\Models\Setting;
use App\Models\Slide;
use App\Models\User;
use Database\Seeders\DummyDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para el comando Artisan project:dummy y DummyDataSeeder.
 */
class ProjectDummyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comprueba que project:dummy puebla los datos corporativos de todos los módulos.
     */
    public function test_project_dummy_populates_all_modules(): void
    {
        $this->artisan('project:dummy')
            ->expectsOutputToContain('Generando datos corporativos de ejemplo')
            ->expectsOutputToContain('Todos los módulos han sido poblados con datos corporativos de muestra')
            ->assertSuccessful();

        $this->assertGreaterThan(0, User::count(), 'Deben existir usuarios.');
        $this->assertGreaterThan(0, Setting::count(), 'Deben existir configuraciones.');
        $this->assertGreaterThan(0, Category::count(), 'Deben existir categorías.');
        $this->assertGreaterThan(0, Page::count(), 'Deben existir páginas.');
        $this->assertGreaterThan(0, Post::count(), 'Deben existir posts.');
        $this->assertGreaterThan(0, Slide::count(), 'Deben existir slides.');
        $this->assertGreaterThan(0, Section::count(), 'Deben existir secciones.');
        $this->assertGreaterThan(0, SentEmail::count(), 'Deben existir registros de auditoría de emails.');
    }

    /**
     * Comprueba que DummyDataSeeder se ejecuta con éxito y puebla la BD.
     */
    public function test_dummy_data_seeder_runs_successfully(): void
    {
        $this->seed(DummyDataSeeder::class);

        $this->assertGreaterThan(0, User::count(), 'Deben existir usuarios.');
        $this->assertGreaterThan(0, Setting::count(), 'Deben existir configuraciones.');
        $this->assertGreaterThan(0, Category::count(), 'Deben existir categorías.');
        $this->assertGreaterThan(0, Page::count(), 'Deben existir páginas.');
        $this->assertGreaterThan(0, Post::count(), 'Deben existir posts.');
        $this->assertGreaterThan(0, Slide::count(), 'Deben existir slides.');
        $this->assertGreaterThan(0, Section::count(), 'Deben existir secciones.');
    }
}
