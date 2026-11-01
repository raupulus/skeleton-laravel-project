<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder de datos corporativos de demostración.
 * Carga un catálogo completo de información verosímil para pruebas comerciales y desarrollo.
 */
class DummyDataSeeder extends Seeder
{
    /**
     * Ejecuta la inserción de datos de muestra para todos los módulos.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            PageSeeder::class,
            PostSeeder::class,
            SlideSeeder::class,
            SectionSeeder::class,
        ]);
    }
}
