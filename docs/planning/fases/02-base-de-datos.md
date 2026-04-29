# Fase 02 — Base de datos

## Resumen
En esta fase se crearán todas las migraciones del proyecto en orden de dependencias, los enums PHP 8.4 necesarios y se establecerán todas las restricciones de integridad. Cada migración incluye `->comment()` en español en todas las columnas.

**Dependencias**: Fase 01 completada.

---

## Paso 2.1 — Crear Enums PHP 8.4

### Enum de Roles

Archivo: `app/Enums/Role.php`

```php
<?php

namespace App\Enums;

/**
 * Enum que define los roles de usuario disponibles en la plataforma.
 */
enum Role: string
{
    case SuperAdmin = 'superadmin';
    case Admin = 'admin';
    case User = 'user';

    /**
     * Obtener la etiqueta legible del rol en español.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrador',
            self::Admin => 'Administrador',
            self::User => 'Usuario',
        };
    }

    /**
     * Comprobar si el rol tiene permisos de administración.
     */
    public function isAdmin(): bool
    {
        return in_array($this, [self::SuperAdmin, self::Admin]);
    }
}
```

### Enum de Estado de contenido

Archivo: `app/Enums/ContentStatus.php`

```php
<?php

namespace App\Enums;

/**
 * Enum que define los estados posibles de contenido (posts, páginas).
 */
enum ContentStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    /**
     * Obtener la etiqueta legible del estado en español.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Borrador',
            self::Published => 'Publicado',
        };
    }

    /**
     * Obtener el color asociado para Filament.
     */
    public function color(): string
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
        };
    }
}
```

### Enum de Estado de email enviado

Archivo: `app/Enums/EmailStatus.php`

```php
<?php

namespace App\Enums;

/**
 * Enum que define los estados posibles de un email enviado.
 */
enum EmailStatus: string
{
    case Sent = 'sent';
    case Failed = 'failed';

    /**
     * Obtener la etiqueta legible del estado.
     */
    public function label(): string
    {
        return match ($this) {
            self::Sent => 'Enviado',
            self::Failed => 'Fallido',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Sent => 'success',
            self::Failed => 'danger',
        };
    }
}
```

---

## Paso 2.2 — Migración: Modificar tabla `users`

Laravel crea por defecto la tabla users. Crear una migración para modificarla y añadir los campos necesarios.

Archivo: `database/migrations/0001_01_01_000000_create_users_table.php`

**Nota**: Si Laravel ya crea esta migración, modificarla. Si no, crear nueva migración de alteración.

Reemplazar la migración de users por defecto con:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de usuarios del sistema.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Tabla de usuarios registrados en la plataforma');

            $table->id()->comment('Identificador único del usuario');
            $table->string('name', 255)->comment('Nombre completo del usuario');
            $table->string('email', 255)->unique()->comment('Correo electrónico único del usuario');
            $table->timestamp('email_verified_at')->nullable()->comment('Fecha y hora de verificación del email');
            $table->string('password')->comment('Contraseña del usuario (hash bcrypt)');
            $table->string('role', 20)->default('user')->comment('Rol del usuario: superadmin, admin, user');
            $table->string('avatar', 512)->nullable()->comment('Ruta de la imagen de avatar del usuario');
            $table->boolean('is_active')->default(true)->comment('Indica si el usuario está activo en la plataforma');
            $table->rememberToken()->comment('Token para recordar la sesión del usuario');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica del usuario');

            $table->index('role', 'idx_users_role');
            $table->index('is_active', 'idx_users_is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

---

## Paso 2.3 — Migración: Tabla `password_reset_tokens`

Archivo: `database/migrations/0001_01_01_000001_create_password_reset_tokens_table.php`

Esta migración ya la crea Laravel por defecto. Mantenerla tal cual.

---

## Paso 2.4 — Migración: Tabla `sessions`

Archivo: `database/migrations/0001_01_01_000002_create_sessions_table.php`

Esta migración ya la crea Laravel por defecto. Mantenerla tal cual.

---

## Paso 2.5 — Migración: Tabla `cache`

Archivo: `database/migrations/0001_01_01_000003_create_cache_table.php`

Esta migración ya la crea Laravel por defecto. Mantenerla para uso futuro.

---

## Paso 2.6 — Migración: Tabla `personal_access_tokens` (Sanctum)

Archivo: `database/migrations/0001_01_01_000004_create_personal_access_tokens_table.php`

Esta migración la publica Sanctum. Si no existe, publicarla con:

```bash
php artisan vendor:publish --tag=sanctum-migrations
```

---

## Paso 2.7 — Migración: Tabla `categories`

Archivo: `database/migrations/2025_01_01_000010_create_categories_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de categorías compartidas entre páginas y posts.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->comment('Categorías compartidas entre páginas y posts');

            $table->id()->comment('Identificador único de la categoría');
            $table->string('slug', 255)->unique()->comment('Slug URL único de la categoría');
            $table->json('name')->comment('Nombre de la categoría (traducible: es, en)');
            $table->json('description')->nullable()->comment('Descripción de la categoría (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen de la categoría');
            $table->boolean('is_active')->default(true)->comment('Indica si la categoría está activa');
            $table->integer('order')->default(0)->comment('Orden de visualización de la categoría');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');

            $table->index('is_active', 'idx_categories_is_active');
            $table->index('order', 'idx_categories_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
```

---

## Paso 2.8 — Migración: Tabla `pages`

Archivo: `database/migrations/2025_01_01_000020_create_pages_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de páginas estáticas del sitio.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->comment('Páginas estáticas editables desde el backend');

            $table->id()->comment('Identificador único de la página');
            $table->string('slug', 255)->unique()->comment('Slug URL único de la página');
            $table->json('title')->comment('Título de la página (traducible: es, en)');
            $table->json('content')->nullable()->comment('Contenido completo de la página (traducible: es, en)');
            $table->json('excerpt')->nullable()->comment('Extracto o resumen de la página (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen principal de la página');
            $table->string('status', 20)->default('draft')->comment('Estado de la página: draft, published');
            $table->boolean('is_active')->default(true)->comment('Indica si la página está activa');
            $table->boolean('featured')->default(false)->comment('Indica si la página está destacada');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade')->comment('Usuario que creó la página');
            $table->json('seo_title')->nullable()->comment('Título SEO de la página (traducible: es, en)');
            $table->json('seo_description')->nullable()->comment('Descripción SEO de la página (traducible: es, en)');
            $table->json('seo_keywords')->nullable()->comment('Palabras clave SEO de la página (traducible: es, en)');
            $table->timestamp('published_at')->nullable()->comment('Fecha y hora de publicación');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');

            $table->index('status', 'idx_pages_status');
            $table->index('is_active', 'idx_pages_is_active');
            $table->index('featured', 'idx_pages_featured');
            $table->index('user_id', 'idx_pages_user_id');
            $table->index('published_at', 'idx_pages_published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
```

---

## Paso 2.9 — Migración: Tabla pivot `category_page`

Archivo: `database/migrations/2025_01_01_000021_create_category_page_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla pivot entre categorías y páginas.
     */
    public function up(): void
    {
        Schema::create('category_page', function (Blueprint $table) {
            $table->comment('Tabla pivot que relaciona categorías con páginas');

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la categoría');
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la página');

            $table->primary(['category_id', 'page_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_page');
    }
};
```

---

## Paso 2.10 — Migración: Tabla `posts`

Archivo: `database/migrations/2025_01_01_000030_create_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de posts/artículos del blog.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('Posts o artículos del blog de la plataforma');

            $table->id()->comment('Identificador único del post');
            $table->string('slug', 255)->unique()->comment('Slug URL único del post');
            $table->json('title')->comment('Título del post (traducible: es, en)');
            $table->json('content')->nullable()->comment('Contenido completo del post (traducible: es, en)');
            $table->json('excerpt')->nullable()->comment('Extracto o resumen del post (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen principal del post');
            $table->string('status', 20)->default('draft')->comment('Estado del post: draft, published');
            $table->boolean('is_active')->default(true)->comment('Indica si el post está activo');
            $table->boolean('featured')->default(false)->comment('Indica si el post está destacado');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade')->comment('Usuario que creó el post');
            $table->json('seo_title')->nullable()->comment('Título SEO del post (traducible: es, en)');
            $table->json('seo_description')->nullable()->comment('Descripción SEO del post (traducible: es, en)');
            $table->json('seo_keywords')->nullable()->comment('Palabras clave SEO del post (traducible: es, en)');
            $table->timestamp('published_at')->nullable()->comment('Fecha y hora de publicación del post');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');

            $table->index('status', 'idx_posts_status');
            $table->index('is_active', 'idx_posts_is_active');
            $table->index('featured', 'idx_posts_featured');
            $table->index('user_id', 'idx_posts_user_id');
            $table->index('published_at', 'idx_posts_published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

---

## Paso 2.11 — Migración: Tabla pivot `category_post`

Archivo: `database/migrations/2025_01_01_000031_create_category_post_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla pivot entre categorías y posts.
     */
    public function up(): void
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->comment('Tabla pivot que relaciona categorías con posts');

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la categoría');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade')->onUpdate('cascade')->comment('ID del post');

            $table->primary(['category_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
```

---

## Paso 2.12 — Migración: Tabla `slides`

Archivo: `database/migrations/2025_01_01_000040_create_slides_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de slides/banners agrupados por zona.
     */
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->comment('Slides multimedia agrupados por zona para carruseles y galerías');

            $table->id()->comment('Identificador único del slide');
            $table->json('title')->nullable()->comment('Título del slide (traducible: es, en)');
            $table->json('content')->nullable()->comment('Texto descriptivo del slide (traducible: es, en)');
            $table->string('image', 512)->comment('Ruta de la imagen principal del slide (formato 16:9, obligatorio)');
            $table->string('image_vertical', 512)->nullable()->comment('Ruta de la imagen vertical del slide (formato 8:12, opcional)');
            $table->string('url', 512)->nullable()->comment('URL de destino al hacer clic en el slide');
            $table->string('zone', 100)->comment('Zona/grupo al que pertenece el slide (agrupa slides del mismo carrusel)');
            $table->integer('order')->default(0)->comment('Orden de visualización dentro de la zona');
            $table->boolean('is_active')->default(true)->comment('Indica si el slide está activo');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');

            $table->index('zone', 'idx_slides_zone');
            $table->index('is_active', 'idx_slides_is_active');
            $table->index('order', 'idx_slides_order');
            $table->index(['zone', 'is_active', 'order'], 'idx_slides_zone_active_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
```

---

## Paso 2.13 — Migración: Tabla `sections`

Archivo: `database/migrations/2025_01_01_000050_create_sections_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de secciones dinámicas para zonas del frontend.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->comment('Secciones dinámicas para rellenar zonas del frontend desde el backend');

            $table->id()->comment('Identificador único de la sección');
            $table->string('slug', 255)->unique()->comment('Slug URL único de la sección');
            $table->string('zone', 100)->comment('Zona/página a la que pertenece (home, about, contact...)');
            $table->json('title')->nullable()->comment('Título de la sección (traducible: es, en)');
            $table->json('description')->nullable()->comment('Descripción breve de la sección (traducible: es, en)');
            $table->json('content')->nullable()->comment('Contenido completo de la sección (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen de la sección');
            $table->integer('order')->default(0)->comment('Orden de visualización dentro de la zona');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');

            $table->index('zone', 'idx_sections_zone');
            $table->index('order', 'idx_sections_order');
            $table->index(['zone', 'order'], 'idx_sections_zone_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
```

---

## Paso 2.14 — Migración: Tabla `settings`

Archivo: `database/migrations/2025_01_01_000060_create_settings_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de configuración general de la plataforma.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->comment('Configuración general de la plataforma en formato clave-valor');

            $table->id()->comment('Identificador único del setting');
            $table->string('key', 255)->unique()->comment('Clave única del setting');
            $table->string('display_name', 255)->comment('Nombre legible del setting para mostrar en el panel');
            $table->text('value')->nullable()->comment('Valor del setting');
            $table->text('details')->nullable()->comment('Detalles o descripción adicional del setting (opciones para selects, etc.)');
            $table->string('type', 50)->default('text')->comment('Tipo de campo: text, textarea, image, select, checkbox, radio, number');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->string('group', 100)->default('general')->comment('Grupo al que pertenece: general, seo, social, contact');
            $table->timestamps();

            $table->index('group', 'idx_settings_group');
            $table->index('order', 'idx_settings_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
```

---

## Paso 2.15 — Migración: Tabla `sent_emails`

Archivo: `database/migrations/2025_01_01_000070_create_sent_emails_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración: Tabla de registro de emails enviados por la plataforma.
     */
    public function up(): void
    {
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->comment('Registro de todos los emails enviados por la plataforma');

            $table->id()->comment('Identificador único del registro de email');
            $table->string('to', 512)->comment('Dirección de email del destinatario');
            $table->string('from', 512)->comment('Dirección de email del remitente');
            $table->string('subject', 512)->comment('Asunto del email');
            $table->text('body')->comment('Cuerpo/contenido del email en HTML');
            $table->string('mailable_class', 255)->comment('Nombre completo de la clase Mailable utilizada');
            $table->string('status', 20)->default('sent')->comment('Estado del envío: sent, failed');
            $table->text('error_message')->nullable()->comment('Mensaje de error si el envío falló');
            $table->json('metadata')->nullable()->comment('Datos adicionales en JSON (adjuntos, headers, etc.)');
            $table->timestamps();

            $table->index('status', 'idx_sent_emails_status');
            $table->index('to', 'idx_sent_emails_to');
            $table->index('created_at', 'idx_sent_emails_created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
```

---

## Paso 2.16 — Ejecutar migraciones

```bash
php artisan migrate
```

Verificar que todas las tablas se han creado correctamente:

```bash
php artisan db:show
php artisan db:table users
php artisan db:table categories
php artisan db:table pages
php artisan db:table posts
php artisan db:table slides
php artisan db:table sections
php artisan db:table settings
php artisan db:table sent_emails
```

---

## Checklist de verificación

- [ ] Enum `Role` creado en `app/Enums/Role.php` con valores: superadmin, admin, user
- [ ] Enum `ContentStatus` creado en `app/Enums/ContentStatus.php` con valores: draft, published
- [ ] Enum `EmailStatus` creado en `app/Enums/EmailStatus.php` con valores: sent, failed
- [ ] Migración `users` con campos: name, email, password, role, avatar, is_active, email_verified_at, soft_deletes
- [ ] Migración `categories` con campos traducibles (json) y slug único
- [ ] Migración `pages` con campos traducibles, SEO, user_id FK, status, featured
- [ ] Migración `category_page` pivot con FK cascade
- [ ] Migración `posts` con misma estructura que pages + published_at
- [ ] Migración `category_post` pivot con FK cascade
- [ ] Migración `slides` con image obligatorio, image_vertical opcional, zone para agrupar
- [ ] Migración `sections` con slug único, zone para agrupar, campos traducibles
- [ ] Migración `settings` con key único, group, type
- [ ] Migración `sent_emails` con todos los campos de registro de email
- [ ] Todas las columnas tienen `->comment()` en español
- [ ] Todos los índices creados correctamente
- [ ] Foreign keys con `onDelete` y `onUpdate` explícitos
- [ ] `php artisan migrate` ejecutado sin errores
