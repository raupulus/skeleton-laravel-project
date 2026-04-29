<?php
namespace Database\Seeders;
use App\Models\Slide;
use Illuminate\Database\Seeder;
class SlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides=[
            ['title'=>['es'=>'Bienvenido','en'=>'Welcome'],'content'=>['es'=>'Descubre nuestra plataforma.','en'=>'Discover our platform.'],'image'=>'slides/slide-home-1.webp','zone'=>'home','order'=>1,'is_active'=>true],
            ['title'=>['es'=>'Innovación','en'=>'Innovation'],'image'=>'slides/slide-home-2.webp','zone'=>'home','order'=>2,'is_active'=>true],
            ['title'=>['es'=>'Tecnología','en'=>'Technology'],'image'=>'slides/slide-home-3.webp','zone'=>'home','order'=>3,'is_active'=>true],
            ['title'=>['es'=>'Contacta','en'=>'Contact'],'image'=>'slides/slide-home-4.webp','zone'=>'home','order'=>4,'is_active'=>true],
            ['title'=>['es'=>'Nuestra historia','en'=>'Our history'],'image'=>'slides/slide-about-1.webp','zone'=>'about','order'=>1,'is_active'=>true],
            ['title'=>['es'=>'Valores','en'=>'Values'],'image'=>'slides/slide-about-2.webp','zone'=>'about','order'=>2,'is_active'=>true],
            ['title'=>['es'=>'Misión','en'=>'Mission'],'image'=>'slides/slide-about-3.webp','zone'=>'about','order'=>3,'is_active'=>true],
            ['title'=>['es'=>'Servicio 1','en'=>'Service 1'],'image'=>'slides/slide-services-1.webp','zone'=>'services','order'=>1,'is_active'=>true],
            ['title'=>['es'=>'Servicio 2','en'=>'Service 2'],'image'=>'slides/slide-services-2.webp','zone'=>'services','order'=>2,'is_active'=>true],
            ['title'=>['es'=>'Servicio 3','en'=>'Service 3'],'image'=>'slides/slide-services-3.webp','zone'=>'services','order'=>3,'is_active'=>true],
        ];
        foreach($slides as $s){Slide::firstOrCreate(['zone'=>$s['zone'],'order'=>$s['order']],$s);}
    }
}
