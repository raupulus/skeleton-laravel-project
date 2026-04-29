<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats=[
            // Categorías de documentación del skeleton (usadas en PostSeeder)
            ['slug'=>'documentacion','name'=>['es'=>'Documentación','en'=>'Documentation'],'description'=>['es'=>'Guías y documentación del proyecto skeleton.','en'=>'Guides and project skeleton documentation.'],'order'=>1,'is_active'=>true],
            ['slug'=>'desarrollo','name'=>['es'=>'Desarrollo','en'=>'Development'],'description'=>['es'=>'Artículos sobre desarrollo con el stack del proyecto.','en'=>'Articles about development with the project stack.'],'order'=>2,'is_active'=>true],
            ['slug'=>'despliegue','name'=>['es'=>'Despliegue','en'=>'Deployment'],'description'=>['es'=>'Guías de despliegue en Docker y producción.','en'=>'Docker and production deployment guides.'],'order'=>3,'is_active'=>true],
            // Categorías genéricas adicionales
            ['slug'=>'tecnologia','name'=>['es'=>'Tecnología','en'=>'Technology'],'description'=>['es'=>'Artículos sobre tecnología.','en'=>'Technology articles.'],'order'=>4,'is_active'=>true],
            ['slug'=>'tutoriales','name'=>['es'=>'Tutoriales','en'=>'Tutorials'],'description'=>['es'=>'Guías y tutoriales.','en'=>'Guides and tutorials.'],'order'=>5,'is_active'=>true],
        ];
        foreach($cats as $c){Category::firstOrCreate(['slug'=>$c['slug']],$c);}
    }
}
