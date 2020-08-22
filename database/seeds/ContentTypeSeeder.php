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
                'name' => 'Página',
                'plural_name' => 'Páginas',
                'slug' => 'page',
                'description' => 'Una página es un tipo de contenido que almacena información sobre la web',
                'icon' => 'fa fa-file',
                'color' => '#ff0000',
            ],
            [
                //'file_id' => '',
                'name' => 'Artículo',
                'plural_name' => 'Artículos',
                'slug' => 'article',
                'description' => 'Un artículo es un tipo de contenido dónde se describe un proceso para lograr algo o experiencia del autor',
                'icon' => 'fa fa-file',
                'color' => '#00ff00',
            ],
            [
                //'file_id' => '',
                'name' => 'Noticia',
                'plural_name' => 'Noticias',
                'slug' => 'new',
                'description' => 'Una noticia es un tipo de contenido que contiene un suceso que es novedad',
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
