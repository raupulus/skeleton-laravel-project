<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

/**
 * Verifica que los archivos de traducción de Filament existen y son consistentes.
 */
class FilamentTranslationsTest extends TestCase
{
    /**
     * Verifica que el archivo de traducciones de Filament en español existe y tiene keys clave.
     */
    public function test_filament_spanish_translations_exist(): void
    {
        $translations = require lang_path('es/filament.php');
        $this->assertIsArray($translations);
        $this->assertArrayHasKey('nav_content', $translations);
        $this->assertArrayHasKey('nav_system', $translations);
        $this->assertArrayHasKey('nav_actions', $translations);
        $this->assertArrayHasKey('user', $translations);
        $this->assertArrayHasKey('post', $translations);
        $this->assertArrayHasKey('title', $translations);
        $this->assertArrayHasKey('slug', $translations);
        $this->assertArrayHasKey('regenerate_sitemap', $translations);
        $this->assertArrayHasKey('clear_cache', $translations);
        $this->assertArrayHasKey('view_logs', $translations);
        $this->assertArrayHasKey('download_error_log', $translations);
    }

    /**
     * Verifica que el archivo de traducciones de Filament en inglés existe y tiene keys clave.
     */
    public function test_filament_english_translations_exist(): void
    {
        $translations = require lang_path('en/filament.php');
        $this->assertIsArray($translations);
        $this->assertArrayHasKey('nav_content', $translations);
        $this->assertArrayHasKey('nav_system', $translations);
        $this->assertArrayHasKey('nav_actions', $translations);
    }

    /**
     * Verifica que ambos archivos de traducción tienen las mismas keys.
     */
    public function test_both_filament_translations_have_same_keys(): void
    {
        $es = require lang_path('es/filament.php');
        $en = require lang_path('en/filament.php');
        $esKeys = array_keys($es);
        $enKeys = array_keys($en);
        sort($esKeys);
        sort($enKeys);
        $this->assertEquals($esKeys, $enKeys, 'Las keys de lang/es/filament.php y lang/en/filament.php no coinciden.');
    }
}
