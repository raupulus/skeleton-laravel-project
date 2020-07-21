<?php

use App\ContentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ContentTypeSeeder extends Seeder
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
                'name' => 'Page',
                'slug' => 'page',
                'description' => 'Página con información sobre la web',
                'icon' => 'fa fa-file',
                'color' => '#ff0000',
            ],
            [
                //'file_id' => '',
                'name' => 'Article',
                'slug' => 'article',
                'description' => 'Artículo',
                'icon' => 'fa fa-file',
                'color' => '#00ff00',
            ],
            [
                //'file_id' => '',
                'name' => 'New',
                'slug' => 'new',
                'description' => 'Noticias',
                'icon' => 'fa fa-file',
                'color' => '#0000ff',
            ],
        ];

        foreach ($data as $contentTypeData) {
            try {
                ContentType::firstOrCreate($contentTypeData);
            } catch (Exception $e) {
                Log::error('Error en ContentType Seeder al crear datos');
                Log::error($e);
            }
        }
    }
}
