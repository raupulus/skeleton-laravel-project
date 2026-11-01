<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('email', 'admin@example.com')->first()?->id ?? 1;
        $pages = [
            ['slug' => 'about-us', 'title' => ['es' => 'Sobre Nosotros', 'en' => 'About Us'], 'content' => ['es' => '<p>Somos un equipo apasionado por el desarrollo de software moderno.</p>', 'en' => '<p>We are a team passionate about modern software development.</p>'], 'excerpt' => ['es' => 'Conoce nuestro equipo, misión y valores corporativos.', 'en' => 'Meet our team, mission and corporate values.'], 'seo_description' => ['es' => 'Conoce al equipo detrás de Skeleton Laravel Project, nuestra arquitectura de software y valores.', 'en' => 'Meet the team behind Skeleton Laravel Project, our software architecture and values.'], 'status' => 'published', 'featured' => true, 'published_at' => now()],
            ['slug' => 'services', 'title' => ['es' => 'Servicios', 'en' => 'Services'], 'content' => ['es' => '<p>Nuestros servicios de desarrollo web y consultoría tecnológica.</p>', 'en' => '<p>Our web development and technology consulting services.</p>'], 'excerpt' => ['es' => 'Servicios de desarrollo web, APIs y arquitectura cloud.', 'en' => 'Web development, APIs and cloud architecture services.'], 'seo_description' => ['es' => 'Descubre nuestros servicios profesionales de desarrollo con Laravel, arquitecturas escalables y consultoría técnica.', 'en' => 'Discover our professional Laravel development services, scalable architectures and technical consulting.'], 'status' => 'published', 'featured' => true, 'published_at' => now()],
            ['slug' => 'team', 'title' => ['es' => 'Equipo', 'en' => 'Team'], 'content' => ['es' => '<p>Nuestro equipo de ingeniería y diseño.</p>', 'en' => '<p>Our engineering and design team.</p>'], 'excerpt' => ['es' => 'Ingenieros y especialistas en desarrollo web full-stack.', 'en' => 'Engineers and specialists in full-stack web development.'], 'seo_description' => ['es' => 'Equipo multidisciplinar de especialistas en ingeniería de software, UX y despliegue continuo.', 'en' => 'Multidisciplinary team of specialists in software engineering, UX and continuous deployment.'], 'status' => 'published', 'featured' => false, 'published_at' => now()],
            ['slug' => 'faq', 'title' => ['es' => 'Preguntas Frecuentes', 'en' => 'FAQ'], 'content' => ['es' => '<p>Respuestas a las preguntas más frecuentes sobre la plataforma.</p>', 'en' => '<p>Answers to frequently asked questions about the platform.</p>'], 'excerpt' => ['es' => 'Resuelve tus dudas frecuentes sobre instalación y uso.', 'en' => 'Resolve your frequently asked questions about installation and usage.'], 'seo_description' => ['es' => 'Preguntas frecuentes y respuestas detalladas sobre la configuración, despliegue y uso de Skeleton Laravel Project.', 'en' => 'Frequently asked questions and detailed answers about configuring, deploying and using Skeleton Laravel Project.'], 'status' => 'published', 'featured' => false, 'published_at' => now()],
            ['slug' => 'portfolio', 'title' => ['es' => 'Portfolio', 'en' => 'Portfolio'], 'content' => ['es' => '<p>Nuestros proyectos y casos de éxito destacados.</p>', 'en' => '<p>Our featured projects and success stories.</p>'], 'excerpt' => ['es' => 'Proyectos y soluciones tecnológicas desarrolladas.', 'en' => 'Developed projects and technology solutions.'], 'seo_description' => ['es' => 'Explora nuestro portfolio de proyectos web, intranets empresariales y plataformas SaaS construidas con Laravel.', 'en' => 'Explore our portfolio of web projects, enterprise intranets and SaaS platforms built with Laravel.'], 'status' => 'published', 'featured' => true, 'published_at' => now()],
            ['slug' => 'clients', 'title' => ['es' => 'Clientes', 'en' => 'Clients'], 'content' => ['es' => '<p>Empresas y organizaciones que confían en nuestras soluciones.</p>', 'en' => '<p>Companies and organizations that trust our solutions.</p>'], 'excerpt' => ['es' => 'Organizaciones que confían en nuestra tecnología.', 'en' => 'Organizations that trust our technology.'], 'seo_description' => ['es' => 'Conoce las empresas y clientes que utilizan nuestras soluciones basadas en Laravel en entornos de producción.', 'en' => 'Meet the companies and clients using our Laravel-based solutions in production environments.'], 'status' => 'published', 'featured' => false, 'published_at' => now()],
            ['slug' => 'testimonials', 'title' => ['es' => 'Testimonios', 'en' => 'Testimonials'], 'content' => ['es' => '<p>Lo que opinan nuestros clientes y usuarios sobre el proyecto.</p>', 'en' => '<p>What our clients and users say about the project.</p>'], 'excerpt' => ['es' => 'Opiniones y experiencias reales de nuestros usuarios.', 'en' => 'Real opinions and experiences from our users.'], 'seo_description' => ['es' => 'Lee los testimonios y valoraciones de equipos de desarrollo que han adoptado Skeleton Laravel Project.', 'en' => 'Read testimonials and reviews from development teams that have adopted Skeleton Laravel Project.'], 'status' => 'published', 'featured' => false, 'published_at' => now()],
            ['slug' => 'draft-1', 'title' => ['es' => 'Borrador 1', 'en' => 'Draft 1'], 'content' => ['es' => '<p>Borrador.</p>', 'en' => '<p>Draft.</p>'], 'excerpt' => ['es' => 'Página en borrador.', 'en' => 'Draft page.'], 'status' => 'draft', 'featured' => false],
            ['slug' => 'draft-2', 'title' => ['es' => 'Borrador 2', 'en' => 'Draft 2'], 'content' => ['es' => '<p>Borrador 2.</p>', 'en' => '<p>Draft 2.</p>'], 'excerpt' => ['es' => 'Segunda página en borrador.', 'en' => 'Second draft page.'], 'status' => 'draft', 'featured' => false],
            ['slug' => 'terms', 'title' => ['es' => 'Términos y Condiciones', 'en' => 'Terms and Conditions'], 'content' => ['es' => '<p>Términos legales y condiciones de uso de la plataforma.</p>', 'en' => '<p>Legal terms and conditions of use of the platform.</p>'], 'excerpt' => ['es' => 'Condiciones generales de uso del sitio web.', 'en' => 'General terms and conditions of use of the website.'], 'seo_description' => ['es' => 'Consulta los términos y condiciones legales de uso de los servicios y contenidos de Skeleton Laravel Project.', 'en' => 'Read the legal terms and conditions of use for Skeleton Laravel Project services and content.'], 'status' => 'published', 'featured' => false, 'published_at' => now()],
            // Páginas legales obligatorias con slug en inglés
            [
                'slug' => 'privacy',
                'title' => ['es' => 'Política de Privacidad', 'en' => 'Privacy Policy'],
                'content' => ['es' => '<p>Aquí se detalla la política de privacidad del sitio. Edítala desde el panel de administración.</p>', 'en' => '<p>Here you will find the privacy policy of this site. Edit it from the administration panel.</p>'],
                'excerpt' => ['es' => 'Política de privacidad y protección de datos personales del sitio.', 'en' => 'Site privacy and personal data protection policy.'],
                'seo_title' => ['es' => 'Política de Privacidad', 'en' => 'Privacy Policy'],
                'seo_description' => ['es' => 'Consulta nuestra política de privacidad, tratamiento de datos personales y derechos RGPD en Skeleton Laravel Project.', 'en' => 'Read our privacy policy, personal data processing and GDPR rights in Skeleton Laravel Project.'],
                'status' => 'published',
                'featured' => false,
                'published_at' => now(),
            ],
            [
                'slug' => 'cookies',
                'title' => ['es' => 'Política de Cookies', 'en' => 'Cookies Policy'],
                'content' => ['es' => '<p>Aquí se detalla la política de cookies del sitio. Edítala desde el panel de administración.</p>', 'en' => '<p>Here you will find the cookies policy of this site. Edit it from the administration panel.</p>'],
                'excerpt' => ['es' => 'Información sobre el uso de cookies técnicas y analíticas en el sitio.', 'en' => 'Information about the use of technical and analytical cookies on the site.'],
                'seo_title' => ['es' => 'Política de Cookies', 'en' => 'Cookies Policy'],
                'seo_description' => ['es' => 'Consulta nuestra política de cookies para conocer qué cookies técnicas y de sesión utilizamos en el sitio web.', 'en' => 'Read our cookies policy to learn which technical and session cookies we use on the website.'],
                'status' => 'published',
                'featured' => false,
                'published_at' => now(),
            ],
        ];
        foreach ($pages as $p) {
            Page::firstOrCreate(['slug' => $p['slug']], array_merge($p, ['user_id' => $adminId]));
        }
    }
}
