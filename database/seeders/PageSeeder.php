<?php
namespace Database\Seeders;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;
class PageSeeder extends Seeder
{
    public function run(): void
    {
        $adminId=User::where('email','admin@example.com')->first()?->id??1;
        $pages=[
            ['slug'=>'sobre-nosotros','title'=>['es'=>'Sobre Nosotros','en'=>'About Us'],'content'=>['es'=>'<p>Somos un equipo apasionado.</p>','en'=>'<p>We are a passionate team.</p>'],'excerpt'=>['es'=>'Conoce nuestro equipo.','en'=>'Meet our team.'],'status'=>'published','featured'=>true,'published_at'=>now()],
            ['slug'=>'servicios','title'=>['es'=>'Servicios','en'=>'Services'],'content'=>['es'=>'<p>Nuestros servicios.</p>','en'=>'<p>Our services.</p>'],'status'=>'published','featured'=>true,'published_at'=>now()],
            ['slug'=>'equipo','title'=>['es'=>'Equipo','en'=>'Team'],'content'=>['es'=>'<p>Nuestro equipo.</p>','en'=>'<p>Our team.</p>'],'status'=>'published','featured'=>false,'published_at'=>now()],
            ['slug'=>'faq','title'=>['es'=>'Preguntas Frecuentes','en'=>'FAQ'],'content'=>['es'=>'<p>Preguntas frecuentes.</p>','en'=>'<p>FAQ.</p>'],'status'=>'published','featured'=>false,'published_at'=>now()],
            ['slug'=>'portfolio','title'=>['es'=>'Portfolio','en'=>'Portfolio'],'content'=>['es'=>'<p>Nuestros trabajos.</p>','en'=>'<p>Our work.</p>'],'status'=>'published','featured'=>true,'published_at'=>now()],
            ['slug'=>'clientes','title'=>['es'=>'Clientes','en'=>'Clients'],'content'=>['es'=>'<p>Nuestros clientes.</p>','en'=>'<p>Our clients.</p>'],'status'=>'published','featured'=>false,'published_at'=>now()],
            ['slug'=>'testimonios','title'=>['es'=>'Testimonios','en'=>'Testimonials'],'content'=>['es'=>'<p>Lo que dicen de nosotros.</p>','en'=>'<p>What they say.</p>'],'status'=>'published','featured'=>false,'published_at'=>now()],
            ['slug'=>'borrador-1','title'=>['es'=>'Borrador 1','en'=>'Draft 1'],'content'=>['es'=>'<p>Borrador.</p>','en'=>'<p>Draft.</p>'],'status'=>'draft','featured'=>false],
            ['slug'=>'borrador-2','title'=>['es'=>'Borrador 2','en'=>'Draft 2'],'content'=>['es'=>'<p>Borrador 2.</p>','en'=>'<p>Draft 2.</p>'],'status'=>'draft','featured'=>false],
            ['slug'=>'terminos','title'=>['es'=>'Términos','en'=>'Terms'],'content'=>['es'=>'<p>Términos legales.</p>','en'=>'<p>Legal terms.</p>'],'status'=>'published','featured'=>false,'published_at'=>now()],
            // Páginas legales obligatorias — reemplazan las vistas estáticas cookies.blade.php y privacy.blade.php
            [
                'slug'         => 'politica-privacidad',
                'title'        => ['es' => 'Política de Privacidad', 'en' => 'Privacy Policy'],
                'content'      => ['es' => '<p>Aquí se detalla la política de privacidad del sitio. Edítala desde el panel de administración.</p>', 'en' => '<p>Here you will find the privacy policy of this site. Edit it from the administration panel.</p>'],
                'excerpt'      => ['es' => 'Política de privacidad del sitio.', 'en' => 'Site privacy policy.'],
                'seo_title'    => ['es' => 'Política de Privacidad', 'en' => 'Privacy Policy'],
                'seo_description' => ['es' => 'Consulta nuestra política de privacidad.', 'en' => 'Read our privacy policy.'],
                'status'       => 'published',
                'featured'     => false,
                'published_at' => now(),
            ],
            [
                'slug'         => 'politica-cookies',
                'title'        => ['es' => 'Política de Cookies', 'en' => 'Cookies Policy'],
                'content'      => ['es' => '<p>Aquí se detalla la política de cookies del sitio. Edítala desde el panel de administración.</p>', 'en' => '<p>Here you will find the cookies policy of this site. Edit it from the administration panel.</p>'],
                'excerpt'      => ['es' => 'Política de cookies del sitio.', 'en' => 'Site cookies policy.'],
                'seo_title'    => ['es' => 'Política de Cookies', 'en' => 'Cookies Policy'],
                'seo_description' => ['es' => 'Consulta nuestra política de cookies.', 'en' => 'Read our cookies policy.'],
                'status'       => 'published',
                'featured'     => false,
                'published_at' => now(),
            ],
        ];
        foreach($pages as $p){Page::firstOrCreate(['slug'=>$p['slug']],array_merge($p,['user_id'=>$adminId]));}
    }
}
