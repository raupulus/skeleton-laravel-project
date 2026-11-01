<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder de posts de documentación del skeleton project.
 * Idempotente: usa firstOrCreate por slug, se puede ejecutar varias veces sin duplicar.
 */
class PostSeeder extends Seeder
{
    /**
     * Crea los posts de documentación del proyecto.
     */
    public function run(): void
    {
        $adminId = User::where('email', 'admin@example.com')->first()?->id ?? 1;
        $catIds = Category::pluck('id')->toArray();

        $posts = [

            // ----------------------------------------------------------------
            // 1. Introducción al Skeleton
            // ----------------------------------------------------------------
            [
                'slug' => 'introduccion-skeleton-laravel-project',
                'title' => ['es' => 'Introducción al Skeleton Laravel Project', 'en' => 'Introduction to Skeleton Laravel Project'],
                'excerpt' => [
                    'es' => 'Todo lo que necesitas saber para entender qué es este skeleton, qué incluye y cómo sacarle partido desde el primer día.',
                    'en' => 'Everything you need to know to understand this skeleton, what it includes and how to get the most out of it from day one.',
                ],
                'content' => [
                    'es' => '<h2>¿Qué es el Skeleton Laravel Project?</h2><p>Es una plantilla base para proyectos Laravel que ya tiene implementadas todas las funcionalidades comunes: autenticación web y API, panel de administración, sistema de contenido, traducciones, SEO, Docker y más. El objetivo es que puedas empezar un nuevo proyecto sin dedicar semanas a configuración y boilerplate.</p><h2>¿Qué incluye?</h2><ul><li><strong>PHP 8.5 + Laravel 13</strong>: El stack más moderno, con typed properties, enums backed y return types en todos los métodos.</li><li><strong>Filament 5</strong>: Dos paneles separados. <code>/admin</code> para superadmin/admin y <code>/panel</code> para usuarios registrados.</li><li><strong>Autenticación completa</strong>: Web con Laravel Breeze y API con Sanctum. Roles: superadmin, admin, user.</li><li><strong>Sistema de contenido</strong>: Posts, Pages, Categorías, Slides y Sections, todos traducibles ES/EN.</li><li><strong>API REST v1</strong>: Endpoints públicos y autenticados, documentados con Scribe.</li><li><strong>SEO</strong>: Meta tags, Open Graph, Twitter Cards, JSON-LD, sitemap XML y hreflang.</li><li><strong>Docker</strong>: Configuración lista para desarrollo y producción.</li><li><strong>Tests</strong>: Feature tests para autenticación, API y rutas web.</li></ul><h2>Credenciales por defecto (seeders)</h2><table><thead><tr><th>Email</th><th>Password</th><th>Rol</th></tr></thead><tbody><tr><td>admin@example.com</td><td>password</td><td>superadmin</td></tr><tr><td>editor@example.com</td><td>password</td><td>admin</td></tr></tbody></table><h2>Inicio rápido</h2><pre><code>cp .env.example .env\ncomposer install &amp;&amp; pnpm install\nphp artisan project:install\nphp artisan serve\npnpm run dev</code></pre><p>El comando <code>project:install</code> genera la clave, crea el enlace de storage, ejecuta migraciones y seeders, todo con confirmaciones paso a paso.</p><h2>Estructura de directorios clave</h2><pre><code>app/\n├── Enums/          # Role, ContentStatus, EmailStatus\n├── Filament/       # Admin/ y Panel/ (Filament resources)\n├── Http/\n│   ├── Controllers/Api/V1/   # Controladores REST\n│   ├── Controllers/Web/      # Controladores frontend\n│   └── Requests/             # FormRequests validados\n├── Models/         # User, Post, Page, Category, Slide, Section, Setting, SentEmail\n├── Services/       # EmailService, SeoService, SettingService, SitemapService\n└── Traits/         # HasSlug, HasStatus, HasSeo, BelongsToUser</code></pre>',
                    'en' => '<h2>What is Skeleton Laravel Project?</h2><p>It is a base template for Laravel projects that already has all common features implemented: web and API authentication, admin panel, content system, translations, SEO, Docker and more.</p><h2>Default credentials (seeders)</h2><table><thead><tr><th>Email</th><th>Password</th><th>Role</th></tr></thead><tbody><tr><td>admin@example.com</td><td>password</td><td>superadmin</td></tr></tbody></table><h2>Quick start</h2><pre><code>cp .env.example .env\nphp artisan project:install</code></pre>',
                ],
                'seo_title' => ['es' => 'Introducción al Skeleton Laravel Project', 'en' => 'Introduction to Skeleton Laravel Project'],
                'seo_description' => ['es' => 'Guía de inicio al skeleton: qué incluye, estructura, credenciales y cómo arrancar el proyecto.', 'en' => 'Getting started guide: what it includes, structure, credentials and how to start the project.'],
                'status' => 'published', 'featured' => true, 'is_active' => true,
                'published_at' => now()->subDays(30),
                '_categories' => ['documentacion', 'desarrollo'],
            ],

            // ----------------------------------------------------------------
            // 2. Panel Filament
            // ----------------------------------------------------------------
            [
                'slug' => 'panel-administracion-filament',
                'title' => ['es' => 'Panel de administración con Filament 5', 'en' => 'Admin panel with Filament 5'],
                'excerpt' => [
                    'es' => 'Cómo está estructurado el panel admin, qué recursos incluye, cómo acceder y cómo extenderlo con nuevos recursos.',
                    'en' => 'How the admin panel is structured, what resources it includes, how to access it and how to extend it with new resources.',
                ],
                'content' => [
                    'es' => '<h2>Dos paneles separados</h2><p>El proyecto incluye dos paneles Filament con acceso independiente:</p><ul><li><strong>Panel Admin <code>/admin</code></strong>: Solo para usuarios con rol <code>superadmin</code> o <code>admin</code> y <code>is_active = true</code>. Gestión completa del sistema.</li><li><strong>Panel Usuario <code>/panel</code></strong>: Para cualquier usuario con <code>is_active = true</code>. Solo puede editar su perfil y gestionar sus tokens API.</li></ul><h2>Recursos del Panel Admin</h2><table><thead><tr><th>Resource</th><th>Navigation Group</th><th>Descripción</th></tr></thead><tbody><tr><td>UserResource</td><td>Sistema</td><td>CRUD de usuarios con filtros por rol</td></tr><tr><td>PostResource</td><td>Contenido</td><td>Blog/artículos con traducciones tabs</td></tr><tr><td>PageResource</td><td>Contenido</td><td>Páginas estáticas con traducciones</td></tr><tr><td>CategoryResource</td><td>Contenido</td><td>Categorías compartidas</td></tr><tr><td>SlideResource</td><td>Media</td><td>Carruseles agrupados por zona</td></tr><tr><td>SectionResource</td><td>Frontend</td><td>Secciones dinámicas por zona</td></tr><tr><td>SettingResource</td><td>Sistema</td><td>Configuración key-value</td></tr><tr><td>SentEmailResource</td><td>Sistema</td><td>Historial de emails enviados (solo lectura)</td></tr></tbody></table><h2>Cómo añadir un nuevo Resource</h2><pre><code>php artisan make:filament-resource NombreModelo --generate</code></pre><p>El resource se crea en <code>app/Filament/Admin/Resources/</code>. Edita el Navigation Group en el método <code>getNavigationGroup()</code>.</p><h2>Campos traducibles en Filament</h2><p>Los modelos con <code>HasTranslations</code> tienen tabs por idioma en sus formularios usando el componente <code>Tabs</code> de Filament.</p>',
                    'en' => '<h2>Two separate panels</h2><ul><li><strong>Admin Panel <code>/admin</code></strong>: Only for superadmin/admin roles.</li><li><strong>User Panel <code>/panel</code></strong>: Any active user. Profile and API token management only.</li></ul><h2>Add a new Resource</h2><pre><code>php artisan make:filament-resource ModelName --generate</code></pre>',
                ],
                'seo_title' => ['es' => 'Panel de administración Filament 5 — Guía completa', 'en' => 'Filament 5 Admin Panel — Complete Guide'],
                'seo_description' => ['es' => 'Guía de uso del panel admin: recursos disponibles, acceso, grupos de navegación y cómo extenderlo.', 'en' => 'Admin panel usage guide: available resources, access, navigation groups and how to extend it.'],
                'status' => 'published', 'featured' => true, 'is_active' => true,
                'published_at' => now()->subDays(28),
                '_categories' => ['documentacion'],
            ],

            // ----------------------------------------------------------------
            // 3. API REST con Sanctum
            // ----------------------------------------------------------------
            [
                'slug' => 'api-rest-sanctum-documentacion',
                'title' => ['es' => 'API REST con Laravel Sanctum', 'en' => 'REST API with Laravel Sanctum'],
                'excerpt' => [
                    'es' => 'Cómo usar la API REST del proyecto: endpoints disponibles, autenticación con tokens Sanctum y cómo generar la documentación con Scribe.',
                    'en' => 'How to use the project REST API: available endpoints, authentication with Sanctum tokens and how to generate documentation with Scribe.',
                ],
                'content' => [
                    'es' => '<h2>Estructura de la API</h2><p>La API está versionada bajo el prefijo <code>/api/v1</code>. Todos los controladores están en <code>app/Http/Controllers/Api/V1/</code>.</p><h2>Endpoints públicos (sin autenticación)</h2><table><thead><tr><th>Método</th><th>Endpoint</th><th>Descripción</th></tr></thead><tbody><tr><td>GET</td><td>/api/v1/posts</td><td>Listado paginado de posts publicados</td></tr><tr><td>GET</td><td>/api/v1/posts/{slug}</td><td>Detalle de un post</td></tr><tr><td>GET</td><td>/api/v1/pages</td><td>Listado paginado de páginas</td></tr><tr><td>GET</td><td>/api/v1/pages/{slug}</td><td>Detalle de una página</td></tr><tr><td>GET</td><td>/api/v1/categories</td><td>Listado de categorías</td></tr><tr><td>POST</td><td>/api/v1/auth/register</td><td>Registro de nuevo usuario</td></tr><tr><td>POST</td><td>/api/v1/auth/login</td><td>Login — devuelve Bearer token</td></tr></tbody></table><h2>Endpoints autenticados (Bearer token requerido)</h2><table><thead><tr><th>Método</th><th>Endpoint</th><th>Descripción</th></tr></thead><tbody><tr><td>GET</td><td>/api/v1/auth/user</td><td>Datos del usuario autenticado</td></tr><tr><td>POST</td><td>/api/v1/auth/logout</td><td>Revoca el token actual</td></tr><tr><td>GET</td><td>/api/v1/user/tokens</td><td>Lista de tokens propios</td></tr><tr><td>POST</td><td>/api/v1/user/tokens</td><td>Crear nuevo token</td></tr><tr><td>DELETE</td><td>/api/v1/user/tokens/{id}</td><td>Eliminar un token</td></tr></tbody></table><h2>Autenticación — Flujo completo</h2><pre><code># 1. Obtener token\ncurl -X POST /api/v1/auth/login \\\n  -H "Content-Type: application/json" \\\n  -d \'{"email":"admin@example.com","password":"password"}\'\n\n# Respuesta: {"token": "1|abc123..."}\n\n# 2. Usar token en peticiones autenticadas\ncurl -X GET /api/v1/auth/user \\\n  -H "Authorization: Bearer 1|abc123..."</code></pre><h2>Documentación con Scribe</h2><pre><code>php artisan scribe:generate</code></pre><p>Disponible en <code>/docs</code>.</p>',
                    'en' => '<h2>API Structure</h2><p>The API is versioned under <code>/api/v1</code>. All controllers are in <code>app/Http/Controllers/Api/V1/</code>.</p><h2>Authentication</h2><pre><code>curl -X POST /api/v1/auth/login \\\n  -d \'{"email":"admin@example.com","password":"password"}\'</code></pre><p>Generate docs: <code>php artisan scribe:generate</code> → available at <code>/docs</code></p>',
                ],
                'seo_title' => ['es' => 'API REST con Sanctum — Endpoints y autenticación', 'en' => 'REST API with Sanctum — Endpoints and authentication'],
                'seo_description' => ['es' => 'Referencia completa de la API REST: endpoints públicos y autenticados, tokens Sanctum y documentación Scribe.', 'en' => 'Complete REST API reference: public and authenticated endpoints, Sanctum tokens and Scribe documentation.'],
                'status' => 'published', 'featured' => true, 'is_active' => true,
                'published_at' => now()->subDays(25),
                '_categories' => ['documentacion', 'desarrollo'],
            ],

            // ----------------------------------------------------------------
            // 4. Traducciones
            // ----------------------------------------------------------------
            [
                'slug' => 'sistema-traducciones-spatie-translatable',
                'title' => ['es' => 'Sistema de traducciones con Spatie Translatable', 'en' => 'Translation system with Spatie Translatable'],
                'excerpt' => [
                    'es' => 'Cómo funcionan las traducciones en los modelos Eloquent, cómo cambiar el idioma en el frontend y cómo gestionar los ficheros de idioma.',
                    'en' => 'How translations work in Eloquent models, how to switch language in the frontend and how to manage language files.',
                ],
                'content' => [
                    'es' => '<h2>Dos niveles de traducción</h2><ol><li><strong>Archivos de idioma Laravel</strong> (<code>lang/es/</code>, <code>lang/en/</code>): Para textos estáticos de la UI.</li><li><strong>spatie/laravel-translatable</strong>: Para contenido dinámico en modelos (títulos, contenido de Posts, Pages, Sections, Slides, Categories).</li></ol><h2>Campos almacenados como JSON en la BD</h2><pre><code>// Columna title (tipo JSON) en la tabla posts:\n{"es": "Mi artículo", "en": "My article"}</code></pre><h2>Usar traducciones en código</h2><pre><code>// Obtener traducción del locale actual\n$post->getTranslation(\'title\', app()->getLocale());\n\n// Guardar con traducción\n$post->setTranslation(\'title\', \'es\', \'Mi título\');\n$post->setTranslation(\'title\', \'en\', \'My title\');\n$post->save();</code></pre><h2>Usar traducciones en Blade</h2><pre><code>@{{-- Texto de interfaz (archivos lang/) --}}\n@{{ __(\'messages.read_more\') }}\n\n@{{-- Contenido de modelo traducible --}}\n@{{ $post->getTranslation(\'title\', app()->getLocale()) }}</code></pre><h2>Cambiar idioma</h2><p>El usuario cambia el idioma visitando <code>/lang/es</code> o <code>/lang/en</code>. El middleware <code>SetLocale</code> lo persiste en sesión.</p><h2>Añadir campo traducible a un modelo</h2><ol><li>En la migración, usar <code>->json(\'campo\')</code></li><li>En el modelo, añadir el campo al array <code>$translatable</code></li><li>En el Resource de Filament, usar tabs por idioma</li></ol>',
                    'en' => '<h2>Two translation levels</h2><ol><li><strong>Laravel language files</strong>: Static UI texts.</li><li><strong>spatie/laravel-translatable</strong>: Dynamic model content stored as JSON.</li></ol><h2>Usage</h2><pre><code>$post->getTranslation(\'title\', app()->getLocale());</code></pre><p>Change language by visiting <code>/lang/es</code> or <code>/lang/en</code>.</p>',
                ],
                'seo_title' => ['es' => 'Traducciones ES/EN con Spatie Translatable', 'en' => 'ES/EN Translations with Spatie Translatable'],
                'seo_description' => ['es' => 'Guía completa del sistema de traducciones: archivos de idioma, modelos traducibles y cambio de idioma.', 'en' => 'Complete translation system guide: language files, translatable models and language switching.'],
                'status' => 'published', 'featured' => false, 'is_active' => true,
                'published_at' => now()->subDays(22),
                '_categories' => ['documentacion'],
            ],

            // ----------------------------------------------------------------
            // 5. Despliegue con Docker
            // ----------------------------------------------------------------
            [
                'slug' => 'despliegue-docker-laravel',
                'title' => ['es' => 'Despliegue con Docker', 'en' => 'Docker deployment'],
                'excerpt' => [
                    'es' => 'Cómo levantar el proyecto con Docker en desarrollo y prepararlo para producción usando docker-compose.',
                    'en' => 'How to run the project with Docker in development and prepare it for production using docker-compose.',
                ],
                'content' => [
                    'es' => '<h2>Servicios incluidos</h2><ul><li><strong>app</strong>: PHP 8.5 FPM con todas las extensiones necesarias</li><li><strong>nginx</strong>: Servidor web, configuración en <code>docker/nginx/</code></li><li><strong>db</strong>: PostgreSQL con volumen persistente</li></ul><h2>Iniciar en desarrollo</h2><pre><code>cp .env.example .env\n# Editar .env: DB_HOST=db\ndocker compose up -d\ndocker compose exec app php artisan project:install --force</code></pre><h2>Variables de entorno para Docker</h2><pre><code>APP_URL=http://localhost:8080\nDB_CONNECTION=pgsql\nDB_HOST=db\nDB_PORT=5432\nDB_DATABASE=laravel\nDB_USERNAME=laravel\nDB_PASSWORD=secret</code></pre><h2>Comandos artisan en Docker</h2><pre><code>docker compose exec app php artisan migrate\ndocker compose exec app php artisan db:seed\ndocker compose exec app php artisan queue:work</code></pre><h2>Storage persistente</h2><p>El directorio <code>storage/app/</code> está montado como volumen para que los archivos subidos persistan entre reinicios del contenedor.</p><h2>Reconstruir contenedores</h2><pre><code>docker compose build --no-cache app\ndocker compose down\n# Eliminar también volúmenes (¡borra datos de BD!)\ndocker compose down -v</code></pre>',
                    'en' => '<h2>Services</h2><ul><li><strong>app</strong>: PHP 8.5 FPM</li><li><strong>nginx</strong>: Web server</li><li><strong>db</strong>: PostgreSQL with persistent volume</li></ul><h2>Start in development</h2><pre><code>docker compose up -d\ndocker compose exec app php artisan project:install --force</code></pre>',
                ],
                'seo_title' => ['es' => 'Despliegue con Docker — Guía paso a paso', 'en' => 'Docker Deployment — Step by step guide'],
                'seo_description' => ['es' => 'Cómo dockerizar el proyecto Laravel: servicios, variables de entorno, storage persistente y comandos útiles.', 'en' => 'How to dockerize the Laravel project: services, environment variables, persistent storage and useful commands.'],
                'status' => 'published', 'featured' => true, 'is_active' => true,
                'published_at' => now()->subDays(20),
                '_categories' => ['despliegue'],
            ],

            // ----------------------------------------------------------------
            // 6. Despliegue en producción
            // ----------------------------------------------------------------
            [
                'slug' => 'despliegue-produccion-nginx',
                'title' => ['es' => 'Despliegue en producción con Nginx', 'en' => 'Production deployment with Nginx'],
                'excerpt' => [
                    'es' => 'Guía para desplegar en un VPS con Nginx, configurar SSL, optimizar Laravel para producción y automatizar el deploy.',
                    'en' => 'Guide to deploy on a VPS with Nginx, configure SSL, optimize Laravel for production and automate deployment.',
                ],
                'content' => [
                    'es' => '<h2>Requisitos del servidor</h2><ul><li>Ubuntu 22.04 / Debian 12</li><li>PHP 8.5 con extensiones: pdo_pgsql, mbstring, xml, curl, zip, gd</li><li>PostgreSQL 16, Nginx, Certbot (SSL)</li><li>Composer 2, Node.js 20, pnpm</li></ul><h2>Configuración Nginx</h2><pre><code>sudo cp docs/deploys/nginx.conf /etc/nginx/sites-available/mi-proyecto\nsudo ln -s /etc/nginx/sites-available/mi-proyecto /etc/nginx/sites-enabled/\nsudo nginx -t &amp;&amp; sudo systemctl reload nginx</code></pre><h2>Variables de entorno para producción</h2><pre><code>APP_ENV=production\nAPP_DEBUG=false\nAPP_URL=https://tudominio.com\nCACHE_STORE=redis\nQUEUE_CONNECTION=redis\nSESSION_DRIVER=redis</code></pre><h2>Proceso de despliegue</h2><pre><code>git pull origin main\ncomposer install --no-dev --optimize-autoloader\npnpm install --frozen-lockfile &amp;&amp; pnpm run build\nphp artisan migrate --force\nphp artisan project:clear\nphp artisan optimize\nphp artisan sitemap:generate\nsudo systemctl restart php8.5-fpm</code></pre><h2>Script automatizado</h2><pre><code>bash docs/deploys/deploy.sh</code></pre><h2>Cola de trabajos en producción</h2><p>Se recomienda Redis como driver de cola. Configura un servicio systemd para el worker que se reinicie automáticamente.</p>',
                    'en' => '<h2>Server requirements</h2><ul><li>Ubuntu 22.04, PHP 8.5, PostgreSQL 16, Nginx, Certbot</li></ul><h2>Deployment</h2><pre><code>git pull origin main\ncomposer install --no-dev --optimize-autoloader\npnpm install --frozen-lockfile &amp;&amp; pnpm run build\nphp artisan migrate --force\nphp artisan optimize</code></pre>',
                ],
                'seo_title' => ['es' => 'Despliegue en producción con Nginx y PHP 8.5', 'en' => 'Production deployment with Nginx and PHP 8.5'],
                'seo_description' => ['es' => 'Guía completa para desplegar en producción: Nginx, variables de entorno, optimización Laravel y scripts de deploy.', 'en' => 'Complete production deployment guide: Nginx, environment variables, Laravel optimization and deploy scripts.'],
                'status' => 'published', 'featured' => true, 'is_active' => true,
                'published_at' => now()->subDays(18),
                '_categories' => ['despliegue'],
            ],

            // ----------------------------------------------------------------
            // 7. Settings y helper global
            // ----------------------------------------------------------------
            [
                'slug' => 'settings-dinamicos-helper-global',
                'title' => ['es' => 'Settings dinámicos y helper global setting()', 'en' => 'Dynamic settings and global helper setting()'],
                'excerpt' => [
                    'es' => 'Cómo usar el sistema de configuración dinámica: el helper setting(), la caché automática y cómo añadir nuevas keys desde Filament.',
                    'en' => 'How to use the dynamic configuration system: the setting() helper, automatic caching and how to add new keys from Filament.',
                ],
                'content' => [
                    'es' => '<h2>¿Qué son los Settings?</h2><p>Son pares key-value en la tabla <code>settings</code> para configurar el sitio sin tocar código: título, redes sociales, email de contacto, Google Analytics ID...</p><h2>Helper global</h2><pre><code>// En un controlador, servicio o vista Blade\n$title = setting(\'site_title\', \'Mi Sitio Web\');\n// En Blade:\n&#123;&#123; setting(\'contact_email\', \'\') &#125;&#125;</code></pre><h2>Settings disponibles por defecto</h2><table><thead><tr><th>Key</th><th>Grupo</th></tr></thead><tbody><tr><td>site_title</td><td>general</td></tr><tr><td>site_description</td><td>general</td></tr><tr><td>contact_email</td><td>contact</td></tr><tr><td>facebook_url</td><td>social</td></tr><tr><td>google_analytics_id</td><td>seo</td></tr></tbody></table><h2>Caché automática</h2><p>El <code>SettingService</code> cachea los settings 1 hora. Invalida la caché manualmente con:</p><pre><code>php artisan cache:clear</code></pre><h2>Añadir un nuevo setting en el seeder</h2><pre><code>Setting::firstOrCreate(\n    [\'key\' => \'whatsapp_url\'],\n    [\'display_name\' => \'WhatsApp URL\', \'value\' => \'\', \'type\' => \'text\', \'group\' => \'social\']\n);</code></pre>',
                    'en' => '<h2>What are Settings?</h2><p>Key-value pairs in the <code>settings</code> table for configuring the site without touching code.</p><h2>Global helper</h2><pre><code>setting(\'site_title\', \'My Site\');\n// In Blade:\n&#123;&#123; setting(\'contact_email\') &#125;&#125;</code></pre>',
                ],
                'seo_title' => ['es' => 'Sistema de settings dinámicos y helper setting()', 'en' => 'Dynamic settings system and setting() helper'],
                'seo_description' => ['es' => 'Guía del sistema de settings: helper global, caché, keys disponibles y cómo añadir nuevas configuraciones.', 'en' => 'Settings system guide: global helper, caching, available keys and how to add new configurations.'],
                'status' => 'published', 'featured' => false, 'is_active' => true,
                'published_at' => now()->subDays(16),
                '_categories' => ['documentacion'],
            ],

            // ----------------------------------------------------------------
            // 8. Comandos Artisan personalizados
            // ----------------------------------------------------------------
            [
                'slug' => 'comandos-artisan-personalizados',
                'title' => ['es' => 'Comandos Artisan personalizados del proyecto', 'en' => 'Custom Artisan commands'],
                'excerpt' => [
                    'es' => 'Los tres comandos artisan del proyecto: project:install, project:clear y sitemap:generate. Cuándo usarlos y qué hacen exactamente.',
                    'en' => 'The three project artisan commands: project:install, project:clear and sitemap:generate. When to use them and what they do exactly.',
                ],
                'content' => [
                    'es' => '<h2>project:install</h2><p>Instala y configura el proyecto desde cero con confirmaciones interactivas.</p><pre><code>php artisan project:install\n# O sin confirmaciones (CI/CD o Docker):\nphp artisan project:install --force</code></pre><p>Ejecuta: key:generate → storage:link → migrate → db:seed → cache:clear → pnpm run build (opcional).</p><h2>project:clear</h2><p>Limpia toda la caché. Útil tras subir cambios al servidor.</p><pre><code>php artisan project:clear</code></pre><p>Limpia: config, rutas, vistas compiladas, caché de aplicación y eventos.</p><h2>sitemap:generate</h2><p>Genera <code>public/sitemap.xml</code> con todas las URLs públicas.</p><pre><code>php artisan sitemap:generate</code></pre><p>Se puede programar en <code>routes/console.php</code>:</p><pre><code>Schedule::command(\'sitemap:generate\')->daily();</code></pre>',
                    'en' => '<h2>project:install</h2><pre><code>php artisan project:install --force</code></pre><h2>project:clear</h2><pre><code>php artisan project:clear</code></pre><h2>sitemap:generate</h2><pre><code>php artisan sitemap:generate</code></pre>',
                ],
                'seo_title' => ['es' => 'Comandos Artisan del proyecto: install, clear, sitemap', 'en' => 'Project Artisan commands: install, clear, sitemap'],
                'seo_description' => ['es' => 'Referencia de los comandos artisan del proyecto: qué hacen, cuándo usarlos y cómo programarlos.', 'en' => 'Project artisan commands reference: what they do, when to use them and how to schedule them.'],
                'status' => 'published', 'featured' => false, 'is_active' => true,
                'published_at' => now()->subDays(14),
                '_categories' => ['documentacion', 'desarrollo'],
            ],

            // ----------------------------------------------------------------
            // 9. Sistema de autenticación
            // ----------------------------------------------------------------
            [
                'slug' => 'sistema-autenticacion-web-api',
                'title' => ['es' => 'Sistema de autenticación: Web y API', 'en' => 'Authentication system: Web and API'],
                'excerpt' => [
                    'es' => 'Cómo funciona la autenticación en el proyecto: Laravel Breeze para web, Sanctum para API, roles de usuario y políticas de acceso.',
                    'en' => 'How authentication works in the project: Laravel Breeze for web, Sanctum for API, user roles and access policies.',
                ],
                'content' => [
                    'es' => '<h2>Autenticación web (Laravel Breeze)</h2><p>Rutas en <code>routes/auth.php</code>: login, register, logout, forgot-password, reset-password, verify-email.</p><h2>Roles de usuario (Enum PHP 8.5)</h2><pre><code>enum Role: string\n{\n    case SuperAdmin = \'superadmin\';\n    case Admin      = \'admin\';\n    case User       = \'user\';\n}\n\n// Comprobación\nif ($user->role === Role::Admin) { ... }</code></pre><h2>Acceso a paneles Filament</h2><p>El modelo <code>User</code> implementa <code>canAccessPanel(Panel $panel)</code>:</p><ul><li><strong>Panel Admin</strong>: solo <code>superadmin</code> y <code>admin</code></li><li><strong>Panel Usuario</strong>: cualquier usuario con <code>is_active = true</code></li></ul><h2>Políticas de autorización</h2><p>Cada modelo tiene su Policy en <code>app/Policies/</code>. Patrón: solo admins pueden crear/editar/eliminar:</p><pre><code>public function create(User $user): bool\n{\n    return in_array($user->role, [Role::Admin, Role::SuperAdmin]);\n}</code></pre><h2>Autenticación API con Sanctum</h2><p>Ver el post <em>API REST con Laravel Sanctum</em> para el flujo completo de obtención y uso de tokens.</p>',
                    'en' => '<h2>Roles (PHP 8.5 Backed Enum)</h2><pre><code>enum Role: string { case SuperAdmin = \'superadmin\'; case Admin = \'admin\'; case User = \'user\'; }</code></pre><h2>Panel access</h2><p>User model implements <code>canAccessPanel(Panel $panel)</code> to control access to each panel.</p>',
                ],
                'seo_title' => ['es' => 'Autenticación web y API con Sanctum', 'en' => 'Web and API authentication with Sanctum'],
                'seo_description' => ['es' => 'Sistema de autenticación del proyecto: Breeze, Sanctum, roles PHP enum y políticas de acceso.', 'en' => 'Project authentication system: Breeze, Sanctum, PHP enum roles and access policies.'],
                'status' => 'published', 'featured' => false, 'is_active' => true,
                'published_at' => now()->subDays(12),
                '_categories' => ['documentacion', 'desarrollo'],
            ],

            // ----------------------------------------------------------------
            // 10. Vue 3 + Alpine.js
            // ----------------------------------------------------------------
            [
                'slug' => 'vue3-alpinejs-frontend',
                'title' => ['es' => 'Vue 3 y Alpine.js en el frontend', 'en' => 'Vue 3 and Alpine.js in the frontend'],
                'excerpt' => [
                    'es' => 'Cómo añadir componentes Vue 3 al frontend Blade y cuándo usar Alpine.js para interactividad ligera.',
                    'en' => 'How to add Vue 3 components to the Blade frontend and when to use Alpine.js for light interactivity.',
                ],
                'content' => [
                    'es' => '<h2>Vue 3: preparado, no activo por defecto</h2><p>Vue 3 está integrado vía Vite pero no se usa en producción aún. El punto de montaje en el home es <code>&lt;div id="vue-app"&gt;</code>.</p><h2>Añadir un componente Vue</h2><p>1. Crea <code>resources/js/components/MiComponente.vue</code>:</p><pre><code>&lt;template&gt;\n  &lt;div&gt;&lt;button @click="count++"&gt;&#123;&#123; count &#125;&#125;&lt;/button&gt;&lt;/div&gt;\n&lt;/template&gt;\n&lt;script setup&gt;\nimport { ref } from \'vue\'\nconst count = ref(0)\n&lt;/script&gt;</code></pre><p>2. Regístralo en <code>resources/js/app.js</code>:</p><pre><code>import MiComponente from \'./components/MiComponente.vue\'\napp.component(\'mi-componente\', MiComponente)</code></pre><p>3. Úsalo en Blade dentro de <code>#vue-app</code>:</p><pre><code>&lt;div id="vue-app"&gt;&lt;mi-componente /&gt;&lt;/div&gt;</code></pre><h2>Alpine.js para interactividad ligera</h2><pre><code>&lt;!-- Toggle --&gt;\n&lt;div x-data="{ open: false }"&gt;\n  &lt;button @click="open = !open"&gt;Toggle&lt;/button&gt;\n  &lt;div x-show="open"&gt;Contenido&lt;/div&gt;\n&lt;/div&gt;</code></pre><h2>¿Cuándo usar cada uno?</h2><table><thead><tr><th>Caso de uso</th><th>Recomendación</th></tr></thead><tbody><tr><td>Toggle, dropdown, modals simples</td><td>Alpine.js</td></tr><tr><td>Formularios reactivos complejos</td><td>Vue 3</td></tr><tr><td>Componentes con estado complejo</td><td>Vue 3</td></tr></tbody></table>',
                    'en' => '<h2>Vue 3: ready but not active by default</h2><p>Integrated via Vite. Mount point: <code>&lt;div id="vue-app"&gt;</code>.</p><h2>Alpine.js for light interactivity</h2><p>Already loaded. Recommended for simple toggles, dropdowns and animations.</p>',
                ],
                'seo_title' => ['es' => 'Vue 3 y Alpine.js en el frontend Laravel', 'en' => 'Vue 3 and Alpine.js in the Laravel frontend'],
                'seo_description' => ['es' => 'Cómo usar Vue 3 y Alpine.js en el proyecto: cuándo usar cada uno, añadir componentes y puntos de montaje.', 'en' => 'How to use Vue 3 and Alpine.js in the project: when to use each, adding components and mount points.'],
                'status' => 'published', 'featured' => false, 'is_active' => true,
                'published_at' => now()->subDays(10),
                '_categories' => ['desarrollo'],
            ],

        ];

        foreach ($posts as $data) {
            // Separar las categorías de los datos del modelo
            $categorySlugsList = $data['_categories'] ?? [];
            unset($data['_categories']);

            // Crear o recuperar el post por slug (idempotente)
            $post = Post::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['user_id' => $adminId])
            );

            // Forzar actualización de campos traducibles para evitar problemas de caché en Scribe
            $post->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'excerpt' => $data['excerpt'],
                'seo_title' => $data['seo_title'],
                'seo_description' => $data['seo_description'],
            ]);

            // Asociar categorías por slug
            if (! empty($categorySlugsList)) {
                $cats = Category::whereIn('slug', $categorySlugsList)->pluck('id')->toArray();
                if (! empty($cats)) {
                    $post->categories()->syncWithoutDetaching($cats);
                }
            } elseif (! empty($catIds)) {
                $post->categories()->syncWithoutDetaching([$catIds[0]]);
            }
        }
    }
}
