# Skeleton Laravel Project

Plantilla base para proyectos Laravel con arquitectura completa lista para producción.
Incluye autenticación, panel admin (Filament), API REST, blog, páginas, traducciones, SEO y más.

---

## Stack tecnológico

| Tecnología | Versión | Uso |
|-----------|---------|-----|
| PHP | 8.4 | Lenguaje del servidor |
| Laravel | 13.x | Framework PHP |
| Filament | 5.x | Panel de administración |
| Vue 3 | 3.x | Componentes frontend (preparado) |
| Tailwind CSS | 4.x | Estilos frontend |
| Alpine.js | 3.x | Interactividad ligera |
| Sanctum | 4.x | Autenticación API |
| spatie/laravel-translatable | 6.x | Traducciones de modelos |
| spatie/laravel-sitemap | 7.x | Generación de sitemap |
| knuckleswtf/scribe | 4.x | Documentación API |

---

## Instalación y desarrollo local

### Requisitos previos
- PHP 8.4+
- Composer 2+
- Node.js 20+
- npm 10+

### Inicio rápido

```bash
# 1. Clonar el repositorio
git clone https://github.com/tuusuario/skeleton-laravel-project.git
cd skeleton-laravel-project

# 2. Instalar el proyecto completo con un comando
php artisan project:install

# 3. Iniciar servidor de desarrollo
php artisan serve
# En otra terminal:
npm run dev
```

### Instalación manual paso a paso

```bash
# 1. Copiar variables de entorno
cp .env.example .env

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Generar clave de aplicación
php artisan key:generate

# 5. Crear enlace simbólico de storage
php artisan storage:link

# 6. Ejecutar migraciones y seeders
php artisan migrate
php artisan db:seed

# 7. Compilar assets
npm run build
# O en modo desarrollo:
npm run dev
```

### Con Docker

El proyecto incluye una configuración Docker completa con los siguientes servicios:

| Servicio | Descripción |
|----------|-------------|
| **app** | PHP 8.4-FPM con la aplicación Laravel |
| **nginx** | Servidor web Nginx como reverse proxy |
| **db** | PostgreSQL 16 para la base de datos |
| **redis** | Redis para caché y colas (opcional) |

```bash
# 1. Copiar variables de entorno
cp .env.example .env

# 2. Iniciar contenedores
docker compose up -d

# 3. Ejecutar instalación dentro del contenedor
docker compose exec app php artisan project:install --force

# 4. Acceder al contenedor (para comandos adicionales)
docker compose exec app bash
```

Variables de entorno configurables para Docker:
- `STORAGE_PATH` — Ruta del storage persistente (default: `./storage`)
- `DB_DATABASE` — Nombre de la base de datos (default: `skeleton_laravel`)
- `DB_USERNAME` / `DB_PASSWORD` — Credenciales PostgreSQL

Para producción existe un `.env.example.production` preconfigurado.

---

## Acceso a los paneles

| Panel | URL | Credenciales por defecto |
|-------|-----|-------------------------|
| Panel Admin | http://localhost:8000/admin | admin@example.com / password |
| Panel Usuario | http://localhost:8000/panel | maria@example.com / password |
| Sitio web | http://localhost:8000 | — |
| Docs API | http://localhost:8000/docs | — |

---

## Roles de usuario

| Role | Panel Admin | Panel Usuario | API | Frontend |
|------|------------|---------------|-----|----------|
| superadmin | ✅ Acceso total | ✅ | ✅ | ✅ |
| admin | ✅ Acceso total | ✅ | ✅ | ✅ |
| user | ❌ | ✅ (perfil + tokens) | ✅ | ✅ |

Los roles se definen como un enum PHP (`App\Enums\Role`) con valores: `superadmin`, `admin`, `user`.

---

## Modelos y relaciones

| Modelo | Tabla | Traducible | Relaciones principales |
|--------|-------|-----------|----------------------|
| User | users | No | hasMany(Page, Post), HasApiTokens, SoftDeletes |
| Post | posts | Sí (title, content, excerpt, seo_*) | belongsTo(User), belongsToMany(Category), SoftDeletes |
| Page | pages | Sí (title, content, excerpt, seo_*) | belongsTo(User), belongsToMany(Category), SoftDeletes |
| Category | categories | Sí (name, description) | belongsToMany(Post, Page), SoftDeletes |
| Slide | slides | Sí (title, content) | SoftDeletes |
| Section | sections | Sí (title, description, content) | SoftDeletes |
| Setting | settings | No | — |
| SentEmail | sent_emails | No | — |

**Traits compartidos:** `HasSlug` (slug auto desde title), `HasStatus` (scopes draft/published), `HasSeo` (accessors meta tags), `BelongsToUser` (auto-asigna user_id al crear).

---

## Estructura del proyecto

```
skeleton-laravel-project/
├── app/
│   ├── Console/Commands/     # project:install, project:clear, sitemap:generate, manual:generate-pdf
│   ├── Enums/                # Role, ContentStatus, EmailStatus
│   ├── Filament/
│   │   ├── Admin/            # Panel Admin: Resources, Pages, Widgets
│   │   └── Panel/            # Panel Usuario: Pages (perfil, tokens), Widgets
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/V1/       # Controladores REST API
│   │   │   └── Web/          # Controladores frontend
│   │   ├── Middleware/       # SetLocale, SecurityHeaders
│   │   ├── Resources/        # API Resources (UserResource)
│   │   └── Requests/         # FormRequests con validación
│   ├── Mail/                  # Mailables: WelcomeMail, ContactMail, GenericMail
│   ├── Models/                # User, Post, Page, Category, Slide, Section, Setting, SentEmail
│   ├── Policies/              # Autorización por modelo
│   ├── Services/              # EmailService, SeoService, SettingService, SitemapService
│   └── Traits/                # HasSlug, HasStatus, HasSeo, BelongsToUser
├── database/
│   ├── factories/            # Factories para tests
│   ├── migrations/           # Migraciones con comentarios en español
│   └── seeders/              # Seeders idempotentes con datos de ejemplo
├── docs/
│   ├── deploys/              # nginx.conf, apache.conf, deploy.sh
│   ├── info/                 # Documentación técnica de cada módulo
│   ├── manual/               # Manuales de usuario (admin, user_backend, user)
│   └── planning/             # Planificación completa del proyecto
├── docker/                   # Configuración de contenedores
├── resources/
│   ├── js/
│   │   ├── app.js            # Entry point con Vue 3
│   │   └── components/       # Componentes Vue
│   └── views/
│       ├── components/       # Componentes Blade reutilizables
│       ├── layouts/          # Layout principal y parciales
│       ├── mail/             # Templates de email
│       └── (pages, posts, errors...)
├── routes/
│   ├── api.php               # Rutas API v1
│   └── web.php               # Rutas web públicas
└── tests/
    ├── Feature/              # Tests de integración
    └── Unit/                 # Tests unitarios
```

---

## API REST

La API está versionada en `/api/v1` y documentada con Scribe.

### Generar documentación

```bash
php artisan scribe:generate
# Accesible en: http://localhost:8000/docs
```

### Endpoints principales

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | /api/v1/auth/register | Registro de usuario |
| POST | /api/v1/auth/login | Inicio de sesión |
| POST | /api/v1/auth/logout | Cierre de sesión |
| POST | /api/v1/auth/forgot-password | Solicitar reset de contraseña |
| POST | /api/v1/auth/reset-password | Resetear contraseña |
| GET | /api/v1/auth/user | Datos del usuario autenticado |
| GET | /api/v1/posts | Listado de posts (público) |
| GET | /api/v1/posts/{slug} | Detalle de post (público) |
| GET | /api/v1/pages | Listado de páginas (público) |
| GET | /api/v1/pages/{slug} | Detalle de página (público) |
| GET | /api/v1/categories | Listado de categorías (público) |
| GET | /api/v1/categories/{slug} | Detalle de categoría (público) |
| GET | /api/v1/user/tokens | Mis tokens API |
| POST | /api/v1/user/tokens | Crear token |
| DELETE | /api/v1/user/tokens/{id} | Eliminar token |

---

## Servicios

### EmailService
```php
// Enviar email y registrarlo automáticamente en sent_emails
$emailService->send(new WelcomeMail($user), $user->email, 'Bienvenido');
```

### SettingService
```php
// Obtener un setting (con caché de 1 hora)
app(SettingService::class)->get('site_title', 'Default');
// O usar el helper global:
setting('site_title', 'Default');
```

### SeoService
```php
// Configurar SEO desde un controlador
$seo->setTitle('Título')->setDescription('Descripción')->setType('article');
// O cargar desde un modelo:
$seo->fromModel($post);
```

### SitemapService
```php
// Generar sitemap desde línea de comandos
php artisan sitemap:generate
// Resultado en: public/sitemap.xml
```

---

## Comandos Artisan personalizados

```bash
# Instalar el proyecto completo (con confirmaciones)
php artisan project:install

# Limpiar toda la caché
php artisan project:clear

# Generar sitemap.xml
php artisan sitemap:generate

# Generar PDFs de manuales de usuario
php artisan manual:generate-pdf
```

---

## Internacionalización (i18n)

El proyecto soporta español (por defecto) e inglés.

- Los archivos de traducción se encuentran en `lang/es/` y `lang/en/`
- Los modelos de contenido (Post, Page, Slide, Section, Category) usan `spatie/laravel-translatable`
- El idioma se puede cambiar desde el selector en el frontend: `/lang/es` o `/lang/en`
- Los formularios de Filament muestran tabs por idioma para editar traducciones
- El middleware `SetLocale` persiste el idioma seleccionado en sesión

### Uso en vistas Blade

```blade
{{-- Textos estáticos de la UI — archivos de idioma --}}
<h2>{{ __('messages.home_features_title') }}</h2>

{{-- Contenido de modelos traducibles (Spatie) --}}
<h3>{{ $post->getTranslation('title', app()->getLocale()) }}</h3>
```

### Cambio de idioma

El componente `<x-language-switcher />` genera los botones de cambio de idioma (ES/EN) en la barra de navegación.

---

## Vue 3 — Integración

Vue 3 está preparado en el proyecto. Para añadir nuevos componentes:

```javascript
// resources/js/app.js — el componente se auto-registra si está en la carpeta components/
// Ejemplo de componente: resources/js/components/MiComponente.vue
```

```blade
{{-- Usar en Blade --}}
<div id="app">
    <mi-componente></mi-componente>
</div>
```

---

## Tests

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar un grupo específico
php artisan test --filter=AuthApiTest

# Con cobertura (requiere Xdebug)
php artisan test --coverage
```

---

## Seeders y datos de ejemplo

Los seeders son **idempotentes** (usan `firstOrCreate`, se pueden ejecutar varias veces sin duplicar datos).

```bash
php artisan db:seed
```

| Seeder | Datos creados |
|--------|--------------|
| UserSeeder | admin@example.com (superadmin) + editor@example.com (admin) + 10 usuarios |
| CategorySeeder | 5 categorías con traducciones es/en |
| SettingSeeder | 12 configuraciones (general, contact, social, seo) |
| PageSeeder | 10 páginas con traducciones (8 published, 2 draft) |
| PostSeeder | 10 posts con traducciones (8 published, 2 draft) |
| SlideSeeder | 10 slides en 3 zonas (home, about, services) |
| SectionSeeder | 7 secciones en 3 zonas (home, about, contact) |

> ⚠️ Los seeders **no deben ejecutarse en producción** ya que contienen credenciales por defecto. Existe una guarda automática que lo impide.

---

## Documentación técnica de módulos

El directorio `docs/info/` contiene documentación técnica detallada de cada módulo implementado en la plataforma. Cada archivo describe el objetivo, la arquitectura, los archivos involucrados, los campos, las relaciones y el comportamiento de un módulo concreto.

**→ [Índice completo de módulos](docs/info/README.md)**

### Modelos y datos

| Módulo | Descripción |
|--------|-------------|
| [Usuarios](docs/info/usuarios.md) | Gestión de usuarios, roles y autenticación |
| [Posts](docs/info/posts.md) | Sistema de blog con artículos traducibles |
| [Páginas](docs/info/paginas.md) | Páginas de contenido estático/dinámico traducibles |
| [Categorías](docs/info/categorias.md) | Taxonomía compartida entre posts y páginas |
| [Slides](docs/info/slides.md) | Carruseles de imágenes agrupados por zona |
| [Secciones](docs/info/secciones.md) | Bloques de contenido dinámico del frontend |
| [Configuración](docs/info/configuracion.md) | Ajustes globales del sistema (key-value) |
| [Emails enviados](docs/info/emails-enviados.md) | Registro de auditoría de emails |

### Servicios e infraestructura

| Módulo | Descripción |
|--------|-------------|
| [EmailService](docs/info/servicio-email.md) | Envío centralizado de emails con registro automático |
| [SeoService](docs/info/servicio-seo.md) | Gestión dinámica de meta tags SEO |
| [SettingService](docs/info/servicio-settings.md) | Acceso cacheado a la configuración del sistema |
| [SitemapService](docs/info/servicio-sitemap.md) | Generación automática del sitemap XML |
| [Autenticación](docs/info/autenticacion.md) | Auth web (Breeze), API (Sanctum), policies y guards |
| [Traducciones](docs/info/traducciones.md) | Sistema i18n: archivos de idioma, modelos traducibles |
| [Panel Admin](docs/info/panel-admin.md) | Panel de administración Filament |
| [Panel Usuario](docs/info/panel-usuario.md) | Panel de usuario con perfil y tokens API |
| [API REST](docs/info/api-rest.md) | Endpoints públicos y autenticados |
| [Frontend](docs/info/frontend.md) | Vistas Blade, layout, componentes y páginas |
| [Traits](docs/info/traits.md) | HasSlug, HasStatus, HasSeo, BelongsToUser |
| [Enums](docs/info/enums.md) | Role, ContentStatus, EmailStatus |
| [Comandos](docs/info/comandos.md) | project:install, project:clear, sitemap:generate, manual:generate-pdf |

---

## Documentación de usuario (Manuales)

El proyecto incluye manuales de uso completos en formato Markdown y PDF dentro de `docs/manual/`, organizados por rol:

| Directorio | PDF generado | Descripción |
|-----------|-------------|-------------|
| `docs/manual/admin/` | `docs/manual/admin.pdf` | Manual del administrador — gestión completa del backoffice |
| `docs/manual/user_backend/` | `docs/manual/user_backend.pdf` | Manual del panel de usuario — perfil y tokens API |
| `docs/manual/user/` | `docs/manual/user.pdf` | Manual del usuario — navegación por el frontend público |

Cada directorio contiene un archivo Markdown por módulo/funcionalidad con explicaciones detalladas de cada apartado, campos de formularios, flujos de trabajo y preguntas frecuentes.

### Generar los PDFs

```bash
php artisan manual:generate-pdf
```

Este comando lee los archivos `.md` de cada subdirectorio en `docs/manual/` y genera un PDF por cada rol con portada, secciones separadas y estilos profesionales.

---

## Despliegue en producción

Ver la guía completa en `docs/deploys/`:

```bash
# Con nginx
sudo cp docs/deploys/nginx.conf /etc/nginx/sites-available/mi-proyecto
sudo ln -s /etc/nginx/sites-available/mi-proyecto /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# Script de despliegue
bash docs/deploys/deploy.sh
```

---

## Licencia

MIT
