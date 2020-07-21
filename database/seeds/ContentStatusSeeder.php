<?php

use App\ContentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                //'file_id' => '',
                'name' => 'Borrador',
                'slug' => 'draft',
                'description' => 'Contenido sin completar datos',
                'icon' => 'fa fa-file',
                'color' => '#ff0000',
            ],
            [
                //'file_id' => '',
                'name' => 'Publicado',
                'slug' => 'publish',
                'description' => 'Contenido publicado',
                'icon' => 'fa fa-file',
                'color' => '#00ff00',
            ],
            [
                //'file_id' => '',
                'name' => 'Programado',
                'slug' => 'programmed',
                'description' => 'Contenido Programado para publicar',
                'icon' => 'fa fa-file',
                'color' => '#0000ff',
            ],
            [
                //'file_id' => '',
                'name' => 'No Publicado',
                'slug' => 'not-published',
                'description' => 'Contenido sin publicar',
                'icon' => 'fa fa-file',
                'color' => '#0000ff',
            ],
        ];

        foreach ($data as $contentStatusData) {
            try {
                ContentStatus::firstOrCreate($contentStatusData);
            } catch (Exception $e) {
                Log::error('Error en ContentStatus Seeder al crear datos');
                Log::error($e);
            }
        }
    }
}
