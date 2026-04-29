<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

/**
 * Seeder de secciones dinámicas del frontend.
 * Idempotente: usa firstOrCreate por slug.
 */
class SectionSeeder extends Seeder
{
    /**
     * Crea las secciones dinámicas por zona.
     *
     * @return void
     */
    public function run(): void
    {
        $sections = [
            // ============================================================
            // ZONA: home
            // ============================================================
            [
                'slug'        => 'home-hero',
                'zone'        => 'home',
                'title'       => [
                    'es' => 'Un punto de partida profesional',
                    'en' => 'A professional starting point',
                ],
                'description' => [
                    'es' => 'Este skeleton incluye autenticación, panel admin, API REST, traducciones, SEO y Docker. Todo configurado y listo para que empieces a construir tu siguiente proyecto Laravel sin perder tiempo en la base.',
                    'en' => 'This skeleton includes authentication, admin panel, REST API, translations, SEO and Docker. Everything configured and ready for you to start building your next Laravel project without wasting time on the foundation.',
                ],
                'content'     => [
                    'es' => '<p>Diseñado por y para desarrolladores mid-senior que quieren un punto de partida sólido. Cada componente sigue las mejores prácticas de Laravel: PSR-12, tipado completo, Service Layer, seeders idempotentes y tests incluidos.</p>',
                    'en' => '<p>Designed by and for mid-senior developers who want a solid starting point. Each component follows Laravel best practices: PSR-12, full typing, Service Layer, idempotent seeders and tests included.</p>',
                ],
                'order'       => 1,
            ],
            [
                'slug'        => 'home-features',
                'zone'        => 'home',
                'title'       => [
                    'es' => 'Arquitectura lista para escalar',
                    'en' => 'Architecture ready to scale',
                ],
                'description' => [
                    'es' => 'La estructura del proyecto separa claramente controladores web, API, servicios, traits y enums. Los modelos usan traducción con Spatie, estados con enums PHP 8.4 y asignación automática de usuario al crear.',
                    'en' => 'The project structure clearly separates web controllers, API, services, traits and enums. Models use Spatie translations, PHP 8.4 enum states and automatic user assignment on creation.',
                ],
                'order'       => 2,
            ],
            [
                'slug'        => 'home-cta',
                'zone'        => 'home',
                'title'       => [
                    'es' => '¿Listo para empezar?',
                    'en' => 'Ready to start?',
                ],
                'description' => [
                    'es' => 'Clona el repositorio, ejecuta php artisan project:install y tendrás un proyecto completo con datos de ejemplo en menos de 5 minutos. Consulta la documentación en el blog para aprender cómo extenderlo.',
                    'en' => 'Clone the repository, run php artisan project:install and you\'ll have a complete project with sample data in less than 5 minutes. Check the blog documentation to learn how to extend it.',
                ],
                'order'       => 3,
            ],

            // ============================================================
            // ZONA: about
            // ============================================================
            [
                'slug'        => 'about-intro',
                'zone'        => 'about',
                'title'       => [
                    'es' => 'Sobre este proyecto',
                    'en' => 'About this project',
                ],
                'content'     => [
                    'es' => '<p>Skeleton Laravel Project nació como una necesidad de tener una base sólida y profesional para iniciar nuevos proyectos Laravel sin repetir la misma configuración inicial una y otra vez.</p><p>Incluye las funcionalidades más comunes de cualquier aplicación web moderna: autenticación, gestión de contenido, API REST, panel de administración, traducciones, SEO y despliegue con Docker.</p>',
                    'en' => '<p>Skeleton Laravel Project was born from the need to have a solid and professional foundation for starting new Laravel projects without repeating the same initial setup over and over.</p><p>It includes the most common features of any modern web application: authentication, content management, REST API, admin panel, translations, SEO and Docker deployment.</p>',
                ],
                'order'       => 1,
            ],
            [
                'slug'        => 'about-team',
                'zone'        => 'about',
                'title'       => [
                    'es' => 'Open Source',
                    'en' => 'Open Source',
                ],
                'content'     => [
                    'es' => '<p>Este proyecto es open source y está disponible en GitHub. Las contribuciones son bienvenidas: reporta bugs, sugiere mejoras o envía pull requests.</p>',
                    'en' => '<p>This project is open source and available on GitHub. Contributions are welcome: report bugs, suggest improvements or send pull requests.</p>',
                ],
                'order'       => 2,
            ],

            // ============================================================
            // ZONA: contact
            // ============================================================
            [
                'slug'        => 'contact-info',
                'zone'        => 'contact',
                'title'       => [
                    'es' => 'Información de contacto',
                    'en' => 'Contact information',
                ],
                'description' => [
                    'es' => 'Si tienes preguntas sobre el proyecto o necesitas soporte, usa el formulario de contacto o escríbenos directamente.',
                    'en' => 'If you have questions about the project or need support, use the contact form or write to us directly.',
                ],
                'order'       => 1,
            ],
            [
                'slug'        => 'contact-map',
                'zone'        => 'contact',
                'title'       => [
                    'es' => 'Ubicación',
                    'en' => 'Location',
                ],
                'content'     => [
                    'es' => '<p>Madrid, España.</p>',
                    'en' => '<p>Madrid, Spain.</p>',
                ],
                'order'       => 2,
            ],
        ];

        foreach ($sections as $s) {
            Section::firstOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
