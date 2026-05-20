# AGENTS.md — Guía completa del proyecto para agentes de IA

Este archivo proporciona el contexto completo del proyecto para que los agentes de IA puedan trabajar
de forma autónoma y precisa. Léelo completamente antes de hacer cualquier modificación.

---

## Descripción del proyecto

**Skeleton Laravel Project** es una plantilla base de Laravel que proporciona una arquitectura completa
y lista para usar como punto de partida de nuevos proyectos. Incluye autenticación web y API,
panel de administración Filament, sistema de contenido (posts/páginas), traducciones, SEO, y más.

---

## Stack tecnológico

- **PHP 8.4** — Usar backed enums, readonly properties, typed properties, return types en todos los métodos
- **Laravel 13** — Framework principal
- **Filament 5** — Panel admin (`/admin`) y panel usuario (`/panel`)
- **Vue 3** — Preparado en el frontend (no usar en producción todavía, solo preparado)
- **Tailwind CSS 4** — Estilos del frontend
- **Alpine.js 3** — Interactividad ligera
- **Laravel Sanctum** — Autenticación API con tokens
- **spatie/laravel-translatable** — Traducciones de campos en modelos
- **spatie/laravel-sitemap** — Generación de sitemap XML
- **knuckleswtf/scribe** — Documentación API automática

---

## Convenciones del código

### Idioma
- **Código (clases, métodos, variables)**: Inglés
- **Comentarios**: Español
- **Mensajes de validación**: Español
- **Comentarios de migraciones**: Español

### Estilo
- PSR-12 estrictamente
- Tipado completo en todos los métodos (return types, parameter types)
- DocBlocks en todos los métodos públicos con @param, @return
- Nunca usar `var`, siempre `string`, `int`, `bool`, `array`, `void`, etc.

### ⚠️ URLs en vistas Blade — OBLIGATORIO
**NUNCA escribir URLs hardcodeadas en vistas Blade.** Usar siempre los helpers de Laravel:

```blade
{{-- ✅ CORRECTO --}}
<a href="{{ route('home') }}">Inicio</a>
<a href="{{ route('blog.show', $post->slug) }}">Ver post</a>
<a href="{{ route('filament.admin.pages.dashboard') }}">Panel Admin</a>
<a href="{{ route('filament.panel.pages.dashboard') }}">Panel Usuario</a>
<form action="{{ route('contact.store') }}" method="POST">
<img src="{{ asset('images/logo.png') }}">
<img src="{{ asset('storage/' . $model->image) }}">

{{-- ❌ INCORRECTO — NUNCA hacer esto --}}
<a href="/">Inicio</a>
<a href="/admin">Panel Admin</a>
<a href="/panel">Panel Usuario</a>
<a href="/blog/mi-post">Ver post</a>
```

**Helpers disponibles:**
- `route('nombre.ruta')` — Para rutas nombradas (web y Filament)
- `url('/ruta')` — Solo si la ruta NO tiene nombre
- `asset('ruta/archivo')` — Para archivos estáticos en `public/`
- `asset('storage/...')` — Para archivos subidos en `storage/app/public/`

**Rutas de paneles Filament:**
- Panel Admin: `route('filament.admin.pages.dashboard')`
- Panel Usuario: `route('filament.panel.pages.dashboard')`

### ⚠️ Textos en vistas Blade — OBLIGATORIO (traducciones frontend)
**NUNCA escribir textos hardcodeados en las vistas Blade.** Todos los textos visibles para el usuario deben ser traducibles:

**Dos tipos de textos:**
1. **Textos estáticos de la UI** (labels, botones, títulos fijos) → Usar `__('messages.key')`
2. **Contenido dinámico de modelos** (posts, pages, sections) → Usar `$model->getTranslation('campo', app()->getLocale())`

```blade
{{-- ✅ CORRECTO — Texto estático con archivos de idioma --}}
<h2>{{ __('messages.home_features_title') }}</h2>
<a href="{{ route('blog.index') }}">{{ __('messages.read_more') }}</a>
<p>{{ __('messages.no_results') }}</p>

{{-- ✅ CORRECTO — Contenido de modelo traducible (Spatie) --}}
<h3>{{ $post->getTranslation('title', app()->getLocale()) }}</h3>
<p>{{ $section->getTranslation('description', app()->getLocale()) }}</p>

{{-- ❌ INCORRECTO — NUNCA hacer esto --}}
<h2>Todo lo que necesitas</h2>
<a href="{{ route('blog.index') }}">Leer más</a>
<p>No se encontraron resultados</p>
```

**Archivos de traducción:**
- `lang/es/messages.php` — Español (idioma por defecto)
- `lang/en/messages.php` — Inglés
- Añadir la key en AMBOS archivos siempre

**Secciones dinámicas (tabla `sections`):**
- Las secciones se cargan en el controlador y se pasan a la vista
- El componente `<x-section-block>` renderiza el contenido traducido automáticamente
- El contenido es editable desde Filament Admin → Secciones
- Agrupadas por `zone` (home, about, contact...)

**Cambio de idioma:**
- Ruta: `/lang/{locale}` (ej: `/lang/en`)
- Middleware `SetLocale` persiste el idioma en sesión
- El componente `<x-language-switcher />` genera los botones de cambio

### ⚠️ Widgets de Dashboard — OBLIGATORIO para nuevos módulos

Cuando se **cree un nuevo módulo** de la plataforma, se debe crear un **widget para el dashboard del panel admin** con un resumen adecuado del módulo. El tipo de widget debe seleccionarse según el tipo de módulo:

- **Módulos con datos cuantificables** (usuarios, posts, páginas) → `StatsOverviewWidget` o `ChartWidget`
- **Módulos con listados recientes** (emails, logs) → `TableWidget`
- **Módulos informativos** → Widget de información con enlaces

**Excepciones** (NO crear widget para): Categorías, Configuraciones (Settings), Slides, módulos auxiliares sin interés estadístico.

Los widgets se crean en: `app/Filament/Admin/Widgets/`

### ⚠️ Traducciones en la intranet (Filament) — OBLIGATORIO

Cuando se **creen o modifiquen** campos/módulos en la intranet (tanto panel admin como panel usuario), **es obligatorio** que:

1. Todos los **labels de campos** del formulario usen `->label(__('filament.campo'))` con traducciones en `lang/es/filament.php` y `lang/en/filament.php`
2. Todos los **labels de columnas** de tabla usen `->label(__('filament.campo'))`
3. Los **títulos de módulo** (`$modelLabel`, `$pluralModelLabel`) y los **navigation groups** también deben ser traducibles usando métodos dinámicos (`getModelLabel()`, `getPluralModelLabel()`, `getNavigationGroup()`)
4. Los **placeholders**, **helper texts** y **mensajes de validación** del formulario deben estar traducidos

**Archivos de traducción de Filament:**
- `lang/es/filament.php` — Español (labels, títulos, grupos de navegación)
- `lang/en/filament.php` — Inglés

---

### ⚠️ Campos de imagen con cropper — OBLIGATORIO

Todos los campos de imagen en formularios de Filament **deben** usar la clase helper `App\Filament\Components\ImageCropField`:

```php
use App\Filament\Components\ImageCropField;

// Posts, Pages, Secciones, Categorías — imagen principal 16:9
ImageCropField::make16x9('image', 'directorio'),

// Slides — imagen vertical 8:12
ImageCropField::make8x12('image_vertical', 'slides'),

// Usuarios — avatar 4:3
ImageCropField::make4x3('avatar', 'avatars'),
```

**Proporciones estándar del proyecto:**

| Proporción | Uso | Método |
|-----------|-----|--------|
| 16:9 | Imagen principal de posts, pages, sections, slides, categories | `make16x9()` |
| 8:12 | Imagen vertical de slides | `make8x12()` |
| 4:3 | Avatar de usuarios | `make4x3()` |

**NUNCA** usar `FileUpload::make()` directamente para imágenes. Siempre usar `ImageCropField`.

**Proporción por defecto:** Si no se indica explícitamente otra proporción, **todos los campos de imagen deben usar `make16x9()` (16:9)** como relación de aspecto predeterminada.

Los métodos internamente usan `imageAspectRatio()` + `automaticallyCropImagesToAspectRatio()` + `imageEditorAspectRatioOptions()` de Filament 5 para forzar el ratio tanto en el editor como en la validación.

### ⚠️ Campos con sugerencias libres (datalist) — Patrón estándar

Los campos `zone` (Slides, Secciones) y `group` (Configuraciones) permiten seleccionar un valor existente O escribir uno nuevo:

```php
Forms\Components\TextInput::make('zone')
    ->label(__('filament.zone'))
    ->required()
    ->datalist(fn () => Model::query()
        ->select('zone')
        ->distinct()
        ->whereNotNull('zone')
        ->pluck('zone')
        ->toArray()
    ),
```

Este patrón muestra sugerencias al escribir pero permite valores libres. Usar cuando el conjunto de valores posibles no está cerrado.

---

## Estructura de directorios clave

```
app/
├── Console/Commands/     # project:install, project:clear, sitemap:generate, manual:generate-pdf
├── Enums/                # Role (superadmin,admin,user), ContentStatus (draft,published), EmailStatus (sent,failed)
├── Filament/Admin/       # Panel admin — Resources: User,Page,Post,Category,Slide,Section,Setting,SentEmail
├── Filament/Admin/Pages/ # Acciones: RegenerateSitemap, ClearCache, ViewLogs
├── Filament/Admin/Widgets/ # StatsOverview, PostsChart, LatestEmails, LogDownload
├── Filament/Components/  # ImageCropField (helper de croppers reutilizable)
├── Filament/Panel/       # Panel usuario — Pages: EditProfile, ApiTokens
├── Http/Controllers/Api/V1/  # AuthController, TokenController, PostApiController, PageApiController, CategoryApiController
├── Http/Controllers/Web/     # HomeController, PostController, PageController, ContactController, StaticPageController, LanguageController, LogDownloadController
├── Http/Middleware/     # SetLocale, SecurityHeaders
├── Http/Requests/       # Todos los FormRequests con validación y mensajes en español
├── Mail/                # WelcomeMail, ContactMail, GenericMail
├── Models/              # User, Category, Page, Post, Slide, Section, Setting, SentEmail
├── Policies/            # Una policy por modelo, solo admins tienen acceso
├── Services/            # EmailService, SeoService, SettingService, SitemapService
└── Traits/              # HasSlug, HasStatus, HasSeo, BelongsToUser
```

---

## ⚠️ Documentación técnica de módulos — OBLIGATORIO mantener actualizada

La documentación técnica de cada módulo se encuentra en `docs/info/`. **Es obligatorio actualizarla cuando se modifique un módulo existente o se cree uno nuevo.**

### Índice de módulos (`docs/info/`)

| Archivo | Módulo |
|---------|--------|
| [usuarios.md](docs/info/usuarios.md) | Gestión de usuarios, roles y autenticación |
| [posts.md](docs/info/posts.md) | Sistema de blog con artículos traducibles |
| [paginas.md](docs/info/paginas.md) | Páginas de contenido estático/dinámico |
| [categorias.md](docs/info/categorias.md) | Taxonomía compartida entre posts y páginas |
| [slides.md](docs/info/slides.md) | Carruseles de imágenes agrupados por zona |
| [secciones.md](docs/info/secciones.md) | Bloques de contenido dinámico del frontend |
| [configuracion.md](docs/info/configuracion.md) | Ajustes globales del sistema (key-value) |
| [emails-enviados.md](docs/info/emails-enviados.md) | Registro de auditoría de emails |
| [servicio-email.md](docs/info/servicio-email.md) | EmailService — envío centralizado de emails |
| [servicio-seo.md](docs/info/servicio-seo.md) | SeoService — gestión dinámica de meta tags SEO |
| [servicio-settings.md](docs/info/servicio-settings.md) | SettingService — acceso cacheado a configuración |
| [servicio-sitemap.md](docs/info/servicio-sitemap.md) | SitemapService — generación del sitemap XML |
| [autenticacion.md](docs/info/autenticacion.md) | Auth web (Breeze), API (Sanctum), policies, guards |
| [traducciones.md](docs/info/traducciones.md) | Sistema i18n: archivos de idioma, modelos traducibles |
| [panel-admin.md](docs/info/panel-admin.md) | Panel de administración Filament |
| [panel-usuario.md](docs/info/panel-usuario.md) | Panel de usuario con perfil y tokens API |
| [api-rest.md](docs/info/api-rest.md) | Endpoints públicos y autenticados de la API v1 |
| [frontend.md](docs/info/frontend.md) | Vistas Blade, layout, componentes y páginas |
| [traits.md](docs/info/traits.md) | HasSlug, HasStatus, HasSeo, BelongsToUser |
| [enums.md](docs/info/enums.md) | Role, ContentStatus, EmailStatus |
| [comandos.md](docs/info/comandos.md) | Comandos Artisan personalizados |
| [acciones-admin.md](docs/info/acciones-admin.md) | Acciones del panel admin (Sitemap, Caché, Logs) |

### Reglas de actualización de `docs/info/`

1. **Al modificar un módulo existente** (nuevos campos, nuevas relaciones, cambios en lógica, nuevas rutas, etc.), actualizar el archivo `.md` correspondiente en `docs/info/` reflejando los cambios.

2. **Al crear un módulo nuevo**, crear un nuevo archivo `.md` en `docs/info/` con la misma estructura (resumen, archivos, campos, relaciones, rutas, etc.) y añadirlo al índice en `docs/info/README.md` y a la tabla de este archivo.

3. **Al eliminar un módulo**, eliminar el archivo `.md` correspondiente y quitarlo de los índices.

4. Cada archivo en `docs/info/` debe contener:
   - Resumen breve del módulo (1-2 frases) al inicio
   - Archivos principales involucrados (modelo, controlador, resource, vistas, etc.)
   - Campos del modelo con tipos y descripciones
   - Relaciones, scopes y métodos relevantes
   - Rutas (web y API) si aplica
   - Configuración Filament si aplica

---

## Modelos y relaciones

### User
- Roles: `superadmin`, `admin`, `user` (enum PHP backed string)
- Campos: name, email, password, role, avatar, is_active
- Traits: HasApiTokens, SoftDeletes
- Relaciones: hasMany(Page), hasMany(Post), hasMany(tokens via Sanctum)
- Panel admin (`/admin`): solo superadmin/admin
- Panel usuario (`/panel`): todos los usuarios activos

### Post / Page
- Campos traducibles: title, content, excerpt, seo_title, seo_description, seo_keywords
- Traits: BelongsToUser (user_id auto), HasSlug, HasStatus, HasSeo, HasTranslations, SoftDeletes
- Estados: draft, published
- Relaciones: belongsToMany(Category), belongsTo(User)
- user_id se asigna automáticamente al crear (NO aparece en formularios)

### Category
- Campos traducibles: name, description
- Traits: HasSlug, HasTranslations, SoftDeletes
- Relaciones: belongsToMany(Post), belongsToMany(Page)

### Slide
- Campos traducibles: title, content
- Agrupados por `zone` (home, about, services...)
- Imagen principal 16:9 (obligatoria), imagen vertical 8:12 (opcional)

### Section
- Campos traducibles: title, description, content
- Agrupadas por `zone` (home, about, contact...)
- Usadas para contenido dinámico del frontend

### Setting
- Patrón key-value
- Acceso vía helper global `setting('clave', 'default')`
- Cacheadas 1 hora por SettingService

### SentEmail
- Registro automático de todos los emails enviados por EmailService
- Estados: sent, failed

---

## Paneles Filament

### Panel Admin (`/admin`)
- **Acceso**: role=admin o role=superadmin + is_active=true
- Resources: UserResource, PageResource, PostResource, CategoryResource,
  SlideResource, SectionResource, SettingResource, SentEmailResource
- Pages: RegenerateSitemap, ClearCache, ViewLogs
- Navigation Groups (en este orden): Contenido, Media, Frontend, Sistema, Acciones
- **Búsqueda global** habilitada en Posts, Páginas, Usuarios, Categorías
- **Alertas de cambios no guardados** activadas
- **Soft Deletes** con TrashedFilter y acciones restaurar/eliminar permanente en todos los recursos con SoftDeletes

### Panel Usuario (`/panel`)
- **Acceso**: cualquier usuario con is_active=true
- Pages: EditProfile (perfil propio), ApiTokens (gestión de tokens propios)

---

## API REST (`/api/v1`)

### Endpoints públicos (sin autenticación)
- `GET /api/v1/posts` — Listado paginado de posts
- `GET /api/v1/posts/{slug}` — Detalle de post
- `GET /api/v1/pages` — Listado paginado de páginas
- `GET /api/v1/pages/{slug}` — Detalle de página
- `GET /api/v1/categories` — Listado de categorías

### Endpoints de autenticación (sin auth)
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `POST /api/v1/auth/forgot-password`
- `POST /api/v1/auth/reset-password`

### Endpoints autenticados (Bearer token)
- `GET /api/v1/auth/user`
- `POST /api/v1/auth/logout`
- `GET /api/v1/user/tokens`
- `POST /api/v1/user/tokens`
- `DELETE /api/v1/user/tokens/{id}`

---

## Traducciones

### Idiomas disponibles
- Español (`es`) — Por defecto
- Inglés (`en`) — Fallback

### Archivos de traducción
- `lang/es/messages.php` — Mensajes del frontend
- `lang/en/messages.php` — Mensajes en inglés
- `lang/es/auth.php`, `lang/en/auth.php` — Mensajes de autenticación

### Cambiar idioma
- Frontend: `/lang/es` o `/lang/en`
- Persistido en sesión por el middleware SetLocale

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

---

## Tests

Ejecutar con: `php artisan test`

- `tests/Feature/Auth/` — Autenticación web (Breeze)
- `tests/Feature/Api/` — Autenticación y tokens API
- `tests/Feature/Web/` — Rutas públicas del frontend
- `tests/Unit/Services/` — Tests de SettingService, EmailService

---

## Comandos útiles para desarrollo

```bash
# Limpiar toda la caché
php artisan project:clear

# Generar sitemap
php artisan sitemap:generate

# Instalar/configurar el proyecto
php artisan project:install

# Regenerar documentación API
php artisan scribe:generate

# Generar PDFs de los manuales de usuario
php artisan manual:generate-pdf

# Ver todas las rutas
php artisan route:list

# Ejecutar tests
php artisan test
```

---

## ⚠️ Documentación de usuario — OBLIGATORIO mantener actualizada

Cuando se **cree, modifique o elimine** un módulo o funcionalidad de la plataforma, **es obligatorio actualizar la documentación de usuario** en `docs/manual/`. Los manuales están pensados para el cliente final y deben reflejar fielmente el estado actual del sistema.

### Estructura de la documentación

```
docs/manual/
├── admin/              # Manual del administrador (panel /admin)
│   ├── 00-introduccion.md
│   ├── 01-dashboard.md
│   ├── 02-usuarios.md
│   ├── 03-paginas.md
│   ├── 04-posts.md
│   ├── 05-categorias.md
│   ├── 06-slides.md
│   ├── 07-secciones.md
│   ├── 08-configuracion.md
│   └── 09-emails-enviados.md
├── user_backend/       # Manual del panel de usuario (panel /panel)
│   ├── 00-introduccion.md
│   ├── 01-dashboard.md
│   ├── 02-mi-perfil.md
│   └── 03-tokens-api.md
├── user/               # Manual del usuario frontend (web pública)
│   ├── 00-introduccion.md
│   ├── 01-pagina-principal.md
│   ├── 02-blog.md
│   ├── 03-paginas.md
│   ├── 04-contacto.md
│   ├── 05-sobre-nosotros.md
│   ├── 06-autenticacion.md
│   ├── 07-cambio-idioma.md
│   ├── 08-paginas-legales.md
│   └── 09-api.md
├── admin.pdf           # PDF generado (no editar)
├── user_backend.pdf    # PDF generado (no editar)
└── user.pdf            # PDF generado (no editar)
```

### Reglas de actualización

1. **Identificar a qué roles afecta el cambio.** Un módulo puede afectar a uno o varios directorios:
   - Cambios en el panel admin (`/admin`) → actualizar `docs/manual/admin/`
   - Cambios en el panel de usuario (`/panel`) → actualizar `docs/manual/user_backend/`
   - Cambios en el frontend público o la API → actualizar `docs/manual/user/`

2. **Si se añade un nuevo módulo**, crear un nuevo archivo `.md` siguiendo la numeración existente (ej: `10-nuevo-modulo.md`) y añadirlo al índice del archivo `00-introduccion.md` correspondiente.

3. **Si se elimina un módulo**, eliminar el archivo `.md` correspondiente y quitarlo del índice.

4. **Si se modifica un módulo existente** (nuevos campos, cambios en formularios, nuevas columnas en listados, nuevos filtros, etc.), actualizar el archivo `.md` correspondiente con los cambios.

5. **Contenido de cada archivo**: cada manual de módulo del backend debe incluir:
   - Objetivo del módulo
   - Descripción de todas las columnas del listado
   - Descripción de todos los campos del formulario (tipo, obligatoriedad, propósito)
   - Filtros y búsquedas disponibles
   - Acciones disponibles
   - Preguntas frecuentes relevantes

6. **Regenerar los PDFs** tras actualizar la documentación:
   ```bash
   php artisan manual:generate-pdf
   ```

---

## Seeders — Datos de ejemplo

Ejecutar: `php artisan db:seed`

| Seeder | Datos creados |
|--------|--------------|
| UserSeeder | admin@example.com (superadmin) + editor@example.com (admin) + 10 usuarios |
| CategorySeeder | 5 categorías con traducciones es/en |
| SettingSeeder | 12 configuraciones (general, contact, social, seo) |
| PageSeeder | 10 páginas con traducciones (8 published, 2 draft) |
| PostSeeder | 10 posts con traducciones (8 published, 2 draft) |
| SlideSeeder | 10 slides en 3 zonas (home, about, services) |
| SectionSeeder | 7 secciones en 3 zonas (home, about, contact) |

Todos los seeders son **idempotentes** (usan `firstOrCreate`, se pueden ejecutar varias veces sin duplicar datos).
