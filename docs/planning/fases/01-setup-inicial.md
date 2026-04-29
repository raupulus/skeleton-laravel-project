# Fase 01 — Setup inicial y configuración

## Resumen
En esta fase se creará el proyecto Laravel 13 desde cero, se instalarán y configurarán todos los paquetes necesarios, se establecerá la estructura de directorios y se copiarán los recursos del proyecto anterior.

---

## Paso 1.1 — Crear proyecto Laravel 13

```bash
cd /ruta/al/workspace
composer create-project laravel/laravel laravel_project "13.*"
cd laravel_project
```

**Verificación**: Ejecutar `php artisan --version` y confirmar que muestra Laravel 13.x.

---

## Paso 1.2 — Configurar `.env` para PostgreSQL

Archivo: `laravel_project/.env`

```env
APP_NAME="Skeleton Laravel Project"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=skeleton_laravel
DB_USERNAME=postgres
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Archivo: `laravel_project/config/database.php`

Verificar que la conexión por defecto es `pgsql` y que la configuración de PostgreSQL está correcta:

```php
'default' => env('DB_CONNECTION', 'pgsql'),
```

**Verificación**: Ejecutar `php artisan db:show` (con la BD creada) y confirmar conexión.

---

## Paso 1.3 — Configurar locales (idiomas)

Archivo: `laravel_project/config/app.php`

Modificar las siguientes claves:

```php
'locale' => 'es',
'fallback_locale' => 'en',
'faker_locale' => 'es_ES',
```

Crear archivo de configuración personalizado para los idiomas disponibles:

Archivo: `laravel_project/config/locales.php`

```php
<?php

/**
 * Configuración de idiomas disponibles en la plataforma.
 */
return [
    // Idiomas disponibles en la plataforma
    'available' => ['es', 'en'],

    // Idioma por defecto
    'default' => 'es',

    // Nombres de los idiomas para mostrar en la interfaz
    'names' => [
        'es' => 'Español',
        'en' => 'English',
    ],
];
```

---

## Paso 1.4 — Instalar y configurar Filament 5

```bash
composer require filament/filament:"^5.0"
```

### Crear Panel Admin (`/admin`)

```bash
php artisan filament:install --panels
```

Archivo: `laravel_project/app/Providers/Filament/AdminPanelProvider.php`

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // Solo usuarios con role superadmin o admin pueden acceder
            ->authGuard('web');
    }
}
```

### Crear Panel Usuario (`/panel`)

Archivo: `laravel_project/app/Providers/Filament/PanelUserProvider.php`

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PanelUserProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('panel')
            ->path('panel')
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Panel/Resources'), for: 'App\\Filament\\Panel\\Resources')
            ->discoverPages(in: app_path('Filament/Panel/Pages'), for: 'App\\Filament\\Panel\\Pages')
            ->discoverWidgets(in: app_path('Filament/Panel/Widgets'), for: 'App\\Filament\\Panel\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web');
    }
}
```

Registrar ambos providers en `laravel_project/bootstrap/providers.php`:

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\PanelUserProvider::class,
];
```

---

## Paso 1.5 — Instalar Tailwind CSS 4, Alpine.js y Vite

Tailwind y Alpine.js ya vienen preconfigurados con Laravel 13. Verificar:

Archivo: `laravel_project/package.json` — Confirmar que incluye:

```json
{
    "devDependencies": {
        "tailwindcss": "^4.0",
        "vite": "^6.0",
        "laravel-vite-plugin": "^1.0",
        "@tailwindcss/vite": "^4.0"
    }
}
```

Si Alpine.js no está incluido:

```bash
npm install alpinejs
```

Archivo: `laravel_project/resources/js/app.js` — Asegurar que Alpine está importado:

```js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
```

Ejecutar:

```bash
npm install
```

---

## Paso 1.6 — Instalar y configurar Vue 3 con Vite

```bash
npm install vue@3 @vitejs/plugin-vue
```

Archivo: `laravel_project/vite.config.js`

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
```

Archivo: `laravel_project/resources/js/app.js` — Actualizar para incluir Vue 3 junto con Alpine:

```js
import { createApp } from 'vue';
import Alpine from 'alpinejs';

// Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Vue 3
const vueApp = createApp({});

// Registrar componentes Vue globalmente
const components = import.meta.glob('./components/**/*.vue', { eager: true });
Object.entries(components).forEach(([path, component]) => {
    const name = path.split('/').pop().replace('.vue', '');
    vueApp.component(name, component.default);
});

// Montar Vue si existe el elemento #vue-app
const vueRoot = document.getElementById('vue-app');
if (vueRoot) {
    vueApp.mount('#vue-app');
}
```

Crear componente de ejemplo:

Archivo: `laravel_project/resources/js/components/ExampleComponent.vue`

```vue
<template>
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
        <p class="mt-2 text-gray-600">{{ message }}</p>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: 'Componente Vue de ejemplo',
    },
    message: {
        type: String,
        default: 'Vue 3 está funcionando correctamente en este proyecto Laravel.',
    },
});
</script>
```

---

## Paso 1.7 — Instalar Laravel Sanctum

Laravel 13 incluye Sanctum por defecto. Verificar:

```bash
composer show laravel/sanctum
```

Si no está instalado:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Archivo: `laravel_project/config/sanctum.php` — Verificar configuración por defecto.

Archivo: `laravel_project/app/Models/User.php` — Asegurar que usa el trait:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```

---

## Paso 1.8 — Instalar paquetes adicionales

```bash
# Generación de sitemaps
composer require spatie/laravel-sitemap

# Documentación de API
composer require --dev knuckleswtf/scribe
php artisan vendor:publish --tag=scribe-config

# Traducciones de modelos
composer require spatie/laravel-translatable

# Plugin de Media Library para Filament (gestión de imágenes con recorte)
composer require filament/spatie-laravel-media-library-plugin:"^5.0"
composer require spatie/laravel-media-library
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

# Laravel Breeze para autenticación web (vistas Blade)
composer require laravel/breeze --dev
php artisan breeze:install blade
```

Archivo: `laravel_project/config/scribe.php` — Configuración inicial:

```php
<?php

return [
    'title' => 'Skeleton Laravel Project API',
    'description' => 'Documentación de la API REST del proyecto skeleton Laravel.',
    'base_url' => env('APP_URL', 'http://localhost:8000'),
    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/v1/*'],
                'domains' => ['*'],
            ],
            'include' => [],
            'exclude' => [],
        ],
    ],
    'type' => 'static',
    'static' => [
        'output_path' => 'public/docs/api',
    ],
    'auth' => [
        'enabled' => true,
        'default' => false,
        'in' => 'bearer',
        'name' => 'Authorization',
        'use_value' => 'Bearer {token}',
        'placeholder' => '{token}',
        'extra_info' => 'Autenticación mediante token Bearer de Laravel Sanctum. Obtener token en POST /api/v1/auth/login.',
    ],
    // Resto de configuración por defecto de Scribe
];
```

---

## Paso 1.9 — Crear estructura de directorios

```bash
cd laravel_project

# Estructura de la aplicación
mkdir -p app/Actions
mkdir -p app/Console/Commands
mkdir -p app/Enums
mkdir -p app/Filament/Admin/Resources
mkdir -p app/Filament/Admin/Pages
mkdir -p app/Filament/Admin/Widgets
mkdir -p app/Filament/Panel/Resources
mkdir -p app/Filament/Panel/Pages
mkdir -p app/Filament/Panel/Widgets
mkdir -p app/Http/Controllers/Api/V1
mkdir -p app/Http/Controllers/Web
mkdir -p app/Http/Middleware
mkdir -p app/Http/Requests/Api/V1/Auth
mkdir -p app/Http/Requests/Web
mkdir -p app/Mail
mkdir -p app/Models
mkdir -p app/Policies
mkdir -p app/Services
mkdir -p app/Traits

# Directorios de vistas
mkdir -p resources/views/components
mkdir -p resources/views/layouts
mkdir -p resources/views/mail/layouts
mkdir -p resources/views/pages
mkdir -p resources/views/posts
mkdir -p resources/views/errors
mkdir -p resources/views/auth

# Componentes Vue
mkdir -p resources/js/components

# Traducciones
mkdir -p lang/es
mkdir -p lang/en

# Documentación y despliegue
mkdir -p docs/deploys
mkdir -p docs/planning/fases

# Tests
mkdir -p tests/Feature/Auth
mkdir -p tests/Feature/Api
mkdir -p tests/Feature/Web
mkdir -p tests/Unit/Services
mkdir -p tests/Unit/Models
```

Crear archivos `.gitkeep` en directorios vacíos para que Git los rastree:

```bash
touch app/Actions/.gitkeep
touch app/Enums/.gitkeep
touch app/Services/.gitkeep
touch app/Traits/.gitkeep
touch app/Policies/.gitkeep
touch docs/deploys/.gitkeep
```

---

## Paso 1.10 — Configurar filesystem, caché y colas

Archivo: `laravel_project/config/filesystems.php` — Verificar que el disco por defecto es `local` y que existe un disco `public`:

```php
'default' => env('FILESYSTEM_DISK', 'local'),

'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/private'),
        'throw' => false,
    ],
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
    // Preparado para S3 en el futuro
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
        'endpoint' => env('AWS_ENDPOINT'),
        'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        'throw' => false,
    ],
],
```

Archivo: `laravel_project/config/cache.php` — Verificar `file` como driver por defecto:

```php
'default' => env('CACHE_STORE', 'file'),
```

Archivo: `laravel_project/config/queue.php` — Verificar `sync` como driver por defecto:

```php
'default' => env('QUEUE_CONNECTION', 'sync'),
```

Crear enlace simbólico de storage:

```bash
php artisan storage:link
```

---

## Paso 1.11 — Copiar recursos del proyecto anterior

```bash
# Copiar scripts (bash)
cp -r ../old_laravel_project/scripts/ laravel_project/scripts/

# Copiar imágenes públicas
cp -r ../old_laravel_project/public/images/ laravel_project/public/images/
```

**Archivos que se copian de scripts/:**
- `exist_db_or_create.sh` — Script para crear la BD si no existe
- `functions.sh` — Funciones bash reutilizables
- `generate_env.sh` — Script para generar archivo .env
- `webhooks/` — Directorio de webhooks

**Archivos que se copian de public/images/:**
- `default/` — Imágenes por defecto
- `default_800x600.png` — Imagen placeholder 800x600
- `default_lazy.png` — Imagen para lazy loading
- `icons/` — Iconos del proyecto
- `logos/` — Logos en distintos tamaños (16x16, 32x32, 64x64, 180x180)
- `redes-sociales/` — Imágenes para redes sociales (rs-1200x1200.png)
- `users/` — Imágenes por defecto de usuarios

---

## Paso 1.12 — Crear archivos de traducción base

Archivo: `laravel_project/lang/es/messages.php`

```php
<?php

/**
 * Traducciones generales de la aplicación en español.
 */
return [
    'welcome' => 'Bienvenido',
    'home' => 'Inicio',
    'about' => 'Sobre nosotros',
    'contact' => 'Contacto',
    'blog' => 'Blog',
    'pages' => 'Páginas',
    'privacy' => 'Política de privacidad',
    'cookies' => 'Política de cookies',
    'login' => 'Iniciar sesión',
    'register' => 'Registrarse',
    'logout' => 'Cerrar sesión',
    'profile' => 'Perfil',
    'settings' => 'Configuración',
    'search' => 'Buscar',
    'read_more' => 'Leer más',
    'back' => 'Volver',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'delete' => 'Eliminar',
    'edit' => 'Editar',
    'create' => 'Crear',
    'update' => 'Actualizar',
    'published' => 'Publicado',
    'draft' => 'Borrador',
    'featured' => 'Destacado',
    'active' => 'Activo',
    'inactive' => 'Inactivo',
    'all_rights_reserved' => 'Todos los derechos reservados',
    'language' => 'Idioma',
    'spanish' => 'Español',
    'english' => 'Inglés',
    'no_results' => 'No se encontraron resultados',
    'contact_success' => 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.',
    'contact_error' => 'Hubo un error al enviar el mensaje. Inténtalo de nuevo.',
];
```

Archivo: `laravel_project/lang/en/messages.php`

```php
<?php

/**
 * General application translations in English.
 */
return [
    'welcome' => 'Welcome',
    'home' => 'Home',
    'about' => 'About us',
    'contact' => 'Contact',
    'blog' => 'Blog',
    'pages' => 'Pages',
    'privacy' => 'Privacy policy',
    'cookies' => 'Cookies policy',
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout',
    'profile' => 'Profile',
    'settings' => 'Settings',
    'search' => 'Search',
    'read_more' => 'Read more',
    'back' => 'Back',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'edit' => 'Edit',
    'create' => 'Create',
    'update' => 'Update',
    'published' => 'Published',
    'draft' => 'Draft',
    'featured' => 'Featured',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'all_rights_reserved' => 'All rights reserved',
    'language' => 'Language',
    'spanish' => 'Spanish',
    'english' => 'English',
    'no_results' => 'No results found',
    'contact_success' => 'Message sent successfully. We will get back to you soon.',
    'contact_error' => 'There was an error sending the message. Please try again.',
];
```

Archivo: `laravel_project/lang/es/validation.php` — Copiar las validaciones en español de Laravel (se genera con Breeze o manualmente). Incluir mensajes custom como:

```php
'custom' => [
    'email' => [
        'required' => 'El correo electrónico es obligatorio.',
        'email' => 'Introduce un correo electrónico válido.',
        'unique' => 'Este correo electrónico ya está registrado.',
    ],
    'password' => [
        'required' => 'La contraseña es obligatoria.',
        'min' => 'La contraseña debe tener al menos :min caracteres.',
        'confirmed' => 'Las contraseñas no coinciden.',
    ],
    'name' => [
        'required' => 'El nombre es obligatorio.',
    ],
],
```

Archivo: `laravel_project/lang/es/auth.php`

```php
<?php

return [
    'failed' => 'Las credenciales proporcionadas no son correctas.',
    'password' => 'La contraseña proporcionada no es correcta.',
    'throttle' => 'Demasiados intentos de inicio de sesión. Por favor, inténtelo de nuevo en :seconds segundos.',
];
```

Archivo: `laravel_project/lang/es/pagination.php`

```php
<?php

return [
    'previous' => '&laquo; Anterior',
    'next' => 'Siguiente &raquo;',
];
```

Archivo: `laravel_project/lang/es/passwords.php`

```php
<?php

return [
    'reset' => 'Tu contraseña ha sido restablecida.',
    'sent' => 'Te hemos enviado un enlace para restablecer tu contraseña.',
    'throttled' => 'Por favor, espera antes de intentarlo de nuevo.',
    'token' => 'El token de restablecimiento de contraseña no es válido.',
    'user' => 'No encontramos un usuario con ese correo electrónico.',
];
```

---

## Paso 1.13 — Generar key de aplicación

```bash
php artisan key:generate
```

---

## Checklist de verificación

- [ ] Proyecto Laravel 13 creado en `laravel_project/`
- [ ] `.env` configurado para PostgreSQL
- [ ] `config/app.php` con locale `es` y fallback `en`
- [ ] `config/locales.php` creado con idiomas disponibles
- [ ] Filament 5 instalado con dos paneles: Admin (`/admin`) y Usuario (`/panel`)
- [ ] `AdminPanelProvider.php` y `PanelUserProvider.php` creados y registrados
- [ ] Tailwind CSS 4 y Alpine.js configurados
- [ ] Vue 3 instalado con plugin Vite, componente de ejemplo creado
- [ ] `vite.config.js` configurado con Laravel, Vue y Tailwind
- [ ] Laravel Sanctum instalado y User model con `HasApiTokens`
- [ ] `spatie/laravel-sitemap` instalado
- [ ] `knuckleswtf/scribe` instalado y `config/scribe.php` configurado
- [ ] `spatie/laravel-translatable` instalado
- [ ] `filament/spatie-laravel-media-library-plugin` instalado
- [ ] Laravel Breeze instalado (vistas Blade)
- [ ] Estructura de directorios creada (Actions, Enums, Services, Traits, etc.)
- [ ] Filesystem, caché y colas configurados con drivers locales
- [ ] Storage link creado (`php artisan storage:link`)
- [ ] Scripts del proyecto anterior copiados a `scripts/`
- [ ] Imágenes del proyecto anterior copiadas a `public/images/`
- [ ] Archivos de traducción base creados (es/en)
- [ ] Key de aplicación generada
- [ ] `npm install` ejecutado correctamente
- [ ] `npm run build` ejecutado sin errores
