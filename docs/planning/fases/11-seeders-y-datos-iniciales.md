# Fase 11 — Seeders y datos iniciales

## Resumen
En esta fase se crearán seeders idempotentes para todas las entidades con datos de ejemplo. Se usará `firstOrCreate`/`updateOrCreate` para evitar duplicados al ejecutar múltiples veces.

**Dependencias**: Fases 01-10 completadas.

---

## Paso 11.1 — `UserSeeder`

Archivo: `database/seeders/UserSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder de usuarios: crea un superadmin y 10 usuarios de ejemplo.
 * Idempotente: no duplica si ya existen (verificación por email).
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario superadmin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => Role::SuperAdmin,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Usuario admin
        User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password'),
                'role' => Role::Admin,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 10 usuarios normales de ejemplo
        $users = [
            ['name' => 'María García', 'email' => 'maria@example.com'],
            ['name' => 'Carlos López', 'email' => 'carlos@example.com'],
            ['name' => 'Ana Martínez', 'email' => 'ana@example.com'],
            ['name' => 'Pedro Sánchez', 'email' => 'pedro@example.com'],
            ['name' => 'Laura Fernández', 'email' => 'laura@example.com'],
            ['name' => 'Diego Rodríguez', 'email' => 'diego@example.com'],
            ['name' => 'Sofía Hernández', 'email' => 'sofia@example.com'],
            ['name' => 'Miguel Torres', 'email' => 'miguel@example.com'],
            ['name' => 'Elena Ruiz', 'email' => 'elena@example.com'],
            ['name' => 'Javier Moreno', 'email' => 'javier@example.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role' => Role::User,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
```

---

## Paso 11.2 — `CategorySeeder`

Archivo: `database/seeders/CategorySeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Seeder de categorías con traducciones es/en.
 * Idempotente: verificación por slug.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'tecnologia',
                'name' => ['es' => 'Tecnología', 'en' => 'Technology'],
                'description' => ['es' => 'Artículos sobre tecnología y desarrollo.', 'en' => 'Articles about technology and development.'],
                'order' => 1,
            ],
            [
                'slug' => 'diseno',
                'name' => ['es' => 'Diseño', 'en' => 'Design'],
                'description' => ['es' => 'Artículos sobre diseño web y UX/UI.', 'en' => 'Articles about web design and UX/UI.'],
                'order' => 2,
            ],
            [
                'slug' => 'negocios',
                'name' => ['es' => 'Negocios', 'en' => 'Business'],
                'description' => ['es' => 'Artículos sobre emprendimiento y negocios.', 'en' => 'Articles about entrepreneurship and business.'],
                'order' => 3,
            ],
            [
                'slug' => 'tutoriales',
                'name' => ['es' => 'Tutoriales', 'en' => 'Tutorials'],
                'description' => ['es' => 'Guías paso a paso y tutoriales prácticos.', 'en' => 'Step by step guides and practical tutorials.'],
                'order' => 4,
            ],
            [
                'slug' => 'noticias',
                'name' => ['es' => 'Noticias', 'en' => 'News'],
                'description' => ['es' => 'Últimas noticias del sector.', 'en' => 'Latest industry news.'],
                'order' => 5,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
```

---

## Paso 11.3 — `PageSeeder`

Archivo: `database/seeders/PageSeeder.php`

Crear 10 páginas con traducciones es/en, estados variados y campos SEO. Usar `firstOrCreate` por slug. Asignar `user_id` del admin (id 1). Ejemplos: "Sobre nosotros", "Nuestros servicios", "Equipo", "FAQ", etc.

```php
class PageSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('email', 'admin@example.com')->first()?->id ?? 1;

        $pages = [
            [
                'slug' => 'sobre-nosotros',
                'title' => ['es' => 'Sobre Nosotros', 'en' => 'About Us'],
                'content' => ['es' => '<p>Somos un equipo apasionado...</p>', 'en' => '<p>We are a passionate team...</p>'],
                'excerpt' => ['es' => 'Conoce más sobre nuestro equipo.', 'en' => 'Learn more about our team.'],
                'status' => 'published',
                'featured' => true,
                'user_id' => $adminId,
                'seo_title' => ['es' => 'Sobre Nosotros - Conócenos', 'en' => 'About Us - Meet our team'],
                'seo_description' => ['es' => 'Página sobre nuestro equipo y misión.', 'en' => 'Page about our team and mission.'],
                'seo_keywords' => ['es' => 'equipo, nosotros, empresa', 'en' => 'team, about, company'],
                'published_at' => now(),
            ],
            // ... 9 páginas más con la misma estructura
        ];

        // Incluir al menos 10 páginas variadas (publicadas y borradores)

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
```

Crear las 10 páginas completas con contenido realista en español e inglés. Al menos 7 publicadas y 3 borradores.

---

## Paso 11.4 — `PostSeeder`

Archivo: `database/seeders/PostSeeder.php`

Crear 10 posts con traducciones, categorías asignadas, estados variados y campos SEO. Usar `firstOrCreate` por slug. Asignar categorías aleatorias.

Misma estructura que PageSeeder pero con posts temáticos: "Introducción a Laravel", "Diseño responsive", "Vue.js para principiantes", etc.

Después de crear cada post, asignar 1-2 categorías:

```php
$post->categories()->syncWithoutDetaching($categoryIds);
```

---

## Paso 11.5 — `SlideSeeder`

Archivo: `database/seeders/SlideSeeder.php`

Crear 10 slides en 3 zones distintas: home (4), about (3), services (3).

```php
class SlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            // Zone: home
            [
                'title' => ['es' => 'Bienvenido a nuestra plataforma', 'en' => 'Welcome to our platform'],
                'content' => ['es' => 'Descubre todo lo que podemos ofrecer.', 'en' => 'Discover everything we can offer.'],
                'image' => 'images/default_800x600.png',
                'zone' => 'home',
                'order' => 1,
                'is_active' => true,
            ],
            // ... más slides para home, about, services
        ];

        foreach ($slides as $slideData) {
            // Verificar por zone + order para idempotencia
            Slide::firstOrCreate(
                ['zone' => $slideData['zone'], 'order' => $slideData['order']],
                $slideData
            );
        }
    }
}
```

---

## Paso 11.6 — `SectionSeeder`

Archivo: `database/seeders/SectionSeeder.php`

Crear secciones para las zonas principales:

```
home:
  - home-hero (Hero principal)
  - home-features (Características)
  - home-cta (Call to action)

about:
  - about-intro (Introducción)
  - about-team (Equipo)

contact:
  - contact-info (Información de contacto)
  - contact-map (Mapa)
```

Cada sección con traducciones es/en y contenido descriptivo.

---

## Paso 11.7 — `SettingSeeder`

Archivo: `database/seeders/SettingSeeder.php`

```php
class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Grupo: general
            ['key' => 'site_title', 'display_name' => 'Título del sitio', 'value' => 'Skeleton Laravel Project', 'type' => 'text', 'group' => 'general', 'order' => 1],
            ['key' => 'site_description', 'display_name' => 'Descripción del sitio', 'value' => 'Plantilla base para proyectos Laravel', 'type' => 'textarea', 'group' => 'general', 'order' => 2],
            ['key' => 'site_logo', 'display_name' => 'Logo del sitio', 'value' => 'images/logos/64x64.png', 'type' => 'image', 'group' => 'general', 'order' => 3],
            ['key' => 'site_favicon', 'display_name' => 'Favicon', 'value' => 'images/logos/32x32.png', 'type' => 'image', 'group' => 'general', 'order' => 4],

            // Grupo: contact
            ['key' => 'contact_email', 'display_name' => 'Email de contacto', 'value' => 'info@example.com', 'type' => 'text', 'group' => 'contact', 'order' => 1],
            ['key' => 'contact_phone', 'display_name' => 'Teléfono de contacto', 'value' => '+34 600 000 000', 'type' => 'text', 'group' => 'contact', 'order' => 2],
            ['key' => 'contact_address', 'display_name' => 'Dirección', 'value' => 'Calle Ejemplo 123, Madrid, España', 'type' => 'textarea', 'group' => 'contact', 'order' => 3],

            // Grupo: social
            ['key' => 'facebook_url', 'display_name' => 'Facebook URL', 'value' => 'https://facebook.com', 'type' => 'text', 'group' => 'social', 'order' => 1],
            ['key' => 'twitter_url', 'display_name' => 'Twitter/X URL', 'value' => 'https://twitter.com', 'type' => 'text', 'group' => 'social', 'order' => 2],
            ['key' => 'instagram_url', 'display_name' => 'Instagram URL', 'value' => 'https://instagram.com', 'type' => 'text', 'group' => 'social', 'order' => 3],
            ['key' => 'linkedin_url', 'display_name' => 'LinkedIn URL', 'value' => 'https://linkedin.com', 'type' => 'text', 'group' => 'social', 'order' => 4],
            ['key' => 'youtube_url', 'display_name' => 'YouTube URL', 'value' => '', 'type' => 'text', 'group' => 'social', 'order' => 5],
            ['key' => 'github_url', 'display_name' => 'GitHub URL', 'value' => 'https://github.com', 'type' => 'text', 'group' => 'social', 'order' => 6],

            // Grupo: seo
            ['key' => 'default_meta_description', 'display_name' => 'Meta descripción por defecto', 'value' => 'Skeleton Laravel Project - Plantilla base para proyectos Laravel', 'type' => 'textarea', 'group' => 'seo', 'order' => 1],
            ['key' => 'default_meta_keywords', 'display_name' => 'Keywords por defecto', 'value' => 'laravel, php, skeleton, plantilla, proyecto', 'type' => 'text', 'group' => 'seo', 'order' => 2],
            ['key' => 'google_analytics_id', 'display_name' => 'Google Analytics ID', 'value' => '', 'type' => 'text', 'group' => 'seo', 'order' => 3],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
```

---

## Paso 11.8 — `DatabaseSeeder`

Archivo: `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal que ejecuta todos los seeders en orden de dependencias.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // Primero: usuarios (sin dependencias)
            SettingSeeder::class,      // Segundo: configuración (sin dependencias)
            CategorySeeder::class,    // Tercero: categorías (sin dependencias)
            PageSeeder::class,        // Cuarto: páginas (depende de users y categories)
            PostSeeder::class,        // Quinto: posts (depende de users y categories)
            SlideSeeder::class,       // Sexto: slides (sin dependencias)
            SectionSeeder::class,     // Séptimo: secciones (sin dependencias)
        ]);
    }
}
```

---

## Paso 11.9 — Ejecutar seeders

```bash
php artisan db:seed
```

Verificar idempotencia ejecutándolo dos veces:

```bash
php artisan db:seed
# No debe duplicar datos
```

---

## Checklist de verificación

- [ ] `UserSeeder` con superadmin (admin@example.com, role=superadmin), admin y 10 usuarios normales
- [ ] `CategorySeeder` con 5 categorías con traducciones es/en, idempotente por slug
- [ ] `PageSeeder` con 10 páginas con traducciones, SEO, estados variados, idempotente por slug
- [ ] `PostSeeder` con 10 posts con traducciones, categorías asignadas, idempotente por slug
- [ ] `SlideSeeder` con 10 slides en 3 zones (home, about, services), idempotente
- [ ] `SectionSeeder` con secciones para home (hero, features, cta), about (intro, team), contact (info, map)
- [ ] `SettingSeeder` con configuración inicial: general, contact, social, seo
- [ ] `DatabaseSeeder` ejecuta todos los seeders en orden correcto de dependencias
- [ ] `php artisan db:seed` ejecutado sin errores
- [ ] Ejecutar `php artisan db:seed` dos veces sin duplicar datos
