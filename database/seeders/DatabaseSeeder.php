<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal que ejecuta todos los seeders del proyecto.
 * Los seeders son idempotentes (usan firstOrCreate).
 * ATENCIÓN: No debe ejecutarse en producción (contiene credenciales por defecto).
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders del proyecto en orden de dependencias.
     * Bloquea la ejecución en entorno de producción por seguridad.
     */
    public function run(): void
    {
        // Guarda de seguridad: no ejecutar seeders en producción
        if (app()->isProduction()) {
            $this->command?->error('⛔ Los seeders no deben ejecutarse en producción (contienen credenciales por defecto).');

            return;
        }

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
