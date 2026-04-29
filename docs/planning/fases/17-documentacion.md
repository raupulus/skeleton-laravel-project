# Fase 17 — Documentación

## Resumen
En esta fase se revisará y completará la documentación del proyecto: PHPDoc en modelos, métodos y migraciones en español, README.md completo y archivo AGENTS.md.

**Dependencias**: Fases 01-16 completadas.

---

## Paso 17.1 — Revisar PHPDoc en modelos

Verificar que todos los modelos en `app/Models/` tienen:
- Comentario de clase en español describiendo el propósito
- `@property` annotations para cada campo (tipo y descripción)
- Comentarios en español en todos los métodos (relaciones, scopes, helpers)

Ejemplo para `User.php`:

```php
/**
 * Modelo de usuario de la plataforma.
 *
 * Gestiona los usuarios registrados, sus roles y permisos.
 * Implementa autenticación con Sanctum y acceso a paneles Filament.
 *
 * @property int $id Identificador único
 * @property string $name Nombre completo
 * @property string $email Correo electrónico
 * @property Role $role Rol del usuario
 * @property bool $is_active Indica si está activo
 * @property string|null $avatar Ruta del avatar
 * @property \Carbon\Carbon|null $email_verified_at Fecha de verificación
 * @property \Carbon\Carbon $created_at Fecha de creación
 * @property \Carbon\Carbon $updated_at Fecha de actualización
 * @property \Carbon\Carbon|null $deleted_at Fecha de eliminación lógica
 */
```

Aplicar el mismo patrón a: `Category`, `Page`, `Post`, `Slide`, `Section`, `Setting`, `SentEmail`.

---

## Paso 17.2 — Revisar PHPDoc en Services y Traits

Verificar que todos los archivos en `app/Services/`, `app/Traits/`, `app/Mail/`, `app/Http/Controllers/` tienen:
- Comentario de clase en español
- Comentarios `@param` y `@return` en todos los métodos públicos
- Descripción del propósito de cada método en español

---

## Paso 17.3 — Revisar migraciones

Verificar que todas las migraciones en `database/migrations/` tienen:
- Comentario PHPDoc en la clase describiendo la tabla
- `->comment()` en español en TODAS las columnas y en la tabla (`$table->comment()`)

---

## Paso 17.4 — README.md

Archivo: `laravel_project/README.md`

```markdown
# Skeleton Laravel Project

Plantilla base para proyectos Laravel con arquitectura completa lista para usar.

## Stack tecnológico

- PHP 8.4 + Laravel 13
- Filament 5 (dos paneles: Admin y Usuario)
- Tailwind CSS 4 + Alpine.js + Vue 3
- PostgreSQL
- Laravel Sanctum (API auth)

## Requisitos

- PHP >= 8.4
- Composer >= 2.x
- Node.js >= 20.x
- PostgreSQL >= 16
- Extensiones PHP: pdo_pgsql, mbstring, xml, curl, zip, gd

## Instalación rápida

1. Clonar el repositorio
2. Ejecutar el comando de instalación:

\```bash
php artisan project:install
\```

O manualmente:

\```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run build
\```

3. Iniciar el servidor:

\```bash
php artisan serve
\```

## Accesos por defecto

| URL | Tipo | Credenciales |
|-----|------|-------------|
| http://localhost:8000 | Frontend | — |
| http://localhost:8000/admin | Panel Admin | admin@example.com / password |
| http://localhost:8000/panel | Panel Usuario | (cualquier usuario) / password |
| http://localhost:8000/docs/api | Documentación API | — |

## Estructura del proyecto

- `app/Models/` — Modelos Eloquent
- `app/Services/` — Servicios de lógica de negocio
- `app/Traits/` — Traits compartidos (HasSlug, HasStatus, HasSeo, BelongsToUser)
- `app/Enums/` — Enums PHP 8.4 (Role, ContentStatus, EmailStatus)
- `app/Filament/Admin/` — Resources y pages del panel admin
- `app/Filament/Panel/` — Resources y pages del panel usuario
- `app/Http/Controllers/Api/V1/` — Controladores API
- `app/Http/Controllers/Web/` — Controladores web

## Módulos incluidos

- **Autenticación** — Web (Breeze) + API (Sanctum) con tests
- **Páginas** — CRUD con traducciones es/en, SEO, categorías
- **Posts/Blog** — CRUD con traducciones, categorías, publicación
- **Categorías** — Compartidas entre pages y posts
- **Slides** — Carruseles agrupados por zona con recorte de imagen
- **Secciones** — Contenido dinámico por zonas del frontend
- **Settings** — Configuración key-value con helper `setting()`
- **Emails** — Envío con registro automático en BD
- **Tokens API** — Gestión de tokens Sanctum por usuario

## Traducciones

El proyecto soporta español (por defecto) e inglés. Los modelos de contenido usan `spatie/laravel-translatable`.

## Vue 3

Vue 3 está integrado con Vite. Para añadir componentes:
1. Crear el archivo `.vue` en `resources/js/components/`
2. Se registra automáticamente como componente global
3. Usar `<nombre-componente />` dentro de un elemento con `id="vue-app"`

## Comandos útiles

\```bash
php artisan project:install     # Instalar proyecto
php artisan project:clear       # Limpiar cachés
php artisan sitemap:generate    # Generar sitemap
php artisan scribe:generate     # Generar documentación API
php artisan test                # Ejecutar tests
\```

## Tests

\```bash
php artisan test
\```

## Despliegue en producción

1. Copiar `.env.example.production` a `.env` y configurar
2. `composer install --optimize-autoloader --no-dev`
3. `npm install && npm run build`
4. `php artisan migrate --force`
5. `php artisan optimize`
6. Configurar servidor web (ver `docs/deploys/`)

## Licencia

Ver archivo LICENSE.
```

---

## Paso 17.5 — AGENTS.md

Archivo: `laravel_project/AGENTS.md`

```markdown
# AGENTS.md — Información del proyecto para agentes de IA

## Descripción del proyecto

Skeleton Laravel Project es una plantilla base para crear proyectos Laravel.
Incluye autenticación, panel admin con Filament, API REST, sistema de contenido
(pages, posts), slides, secciones dinámicas, settings y registro de emails.

## Stack

- PHP 8.4, Laravel 13, Filament 5, Tailwind CSS 4, Alpine.js, Vue 3, PostgreSQL, Laravel Sanctum

## Convenciones de código

- **Idioma del código**: Inglés (variables, métodos, clases)
- **Idioma de documentación**: Español (comentarios, PHPDoc, migraciones)
- **Estilo**: PSR-12
- **Modelos**: Usar traits HasSlug, HasStatus, HasSeo, BelongsToUser según aplique
- **Enums**: PHP 8.4 backed enums en app/Enums/
- **Services**: Lógica de negocio en app/Services/
- **Traducciones**: spatie/laravel-translatable para modelos de contenido

## Estructura clave

- Dos paneles Filament: Admin (/admin) y Panel (/panel)
- API versionada: /api/v1/
- Frontend: Blade + Tailwind + Alpine.js + Vue 3
- Todos los emails via EmailService (registrados en sent_emails)
- Settings accesibles con helper setting('key')

## Testing

- Tests en tests/Feature/ y tests/Unit/
- Ejecutar: php artisan test
- Base de datos de test: SQLite in-memory

## Módulos

Users, Categories, Pages, Posts, Slides, Sections, Settings, SentEmails

## Roles

superadmin, admin, user (enum App\Enums\Role)
```

---

## Paso 17.6 — Documentar Vue 3 en README

Ya incluido en el Paso 17.4.

---

## Checklist de verificación

- [ ] Todos los modelos tienen PHPDoc completo con @property en español
- [ ] Todos los métodos públicos de Services, Controllers, Traits documentados en español
- [ ] Todas las migraciones tienen PHPDoc y ->comment() en español
- [ ] README.md completo con: instalación, accesos, estructura, módulos, comandos, despliegue
- [ ] AGENTS.md creado con información del proyecto para agentes IA
- [ ] Documentación de Vue 3 incluida en README
