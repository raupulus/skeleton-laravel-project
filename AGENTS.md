# AGENTS.md — Guía completa del proyecto para agentes de IA

*Última actualización: 2026-08-26*

Este archivo proporciona el contexto y las directrices obligatorias del proyecto para que los agentes de IA
puedan trabajar de forma autónoma, consistente y precisa. Léelo completamente antes de realizar cualquier modificación.

---

## 1. Descripción del proyecto

**Skeleton Laravel Project** es una plantilla base para aplicaciones Laravel con arquitectura modular, robusta y lista para producción. Incluye autenticación web y API, panel de administración Filament, sistema de contenidos (posts, páginas, slides, secciones), configuraciones dinámicas, registro de auditoría de emails, internacionalización (ES/EN), SEO automatizado, Docker y tests automatizados.

---

## 2. Stack tecnológico

- **PHP 8.4** — Tipado estricto en parámetros y retornos, backed enums, readonly properties, typed properties.
- **Laravel 13** — Framework principal.
- **Base de datos — PostgreSQL** — **OBLIGATORIO**: La base de datos que se usará es SIEMPRE PostgreSQL (`DB_CONNECTION=pgsql`). No utilizar MySQL ni SQLite salvo en tests en memoria si aplica.
- **Filament 5** — Panel admin (`/admin`) y panel de usuario (`/panel`). Completamente traducido al español.
- **Tailwind CSS 4** — Motor de estilos CSS utilitarios configurado con `@theme` en `resources/css/app.css`.
- **Alpine.js 3** — Interactividad reactiva ligera y modales.
- **Vue 3** — Preparado en el frontend para componentes enriquecidos (no requerido en producción aún).
- **Laravel Sanctum** — Autenticación API mediante Bearer tokens personales.
- **spatie/laravel-translatable** — Gestión de traducciones en campos de modelos Eloquent.
- **spatie/laravel-sitemap** — Generación automatizada de sitemaps XML.
- **knuckleswtf/scribe** — Documentación de la API REST accesible en `/docs`.

---

## 3. Control de versiones y Exclusiones Git (`.gitignore`)

Los siguientes directorios y archivos están estrictamente excluidos del repositorio git y **NUNCA** deben añadirse al control de versiones:
- `node_modules/`, `vendor/`, `template/` (y `/template`).
- Entornos y secretos: `.env`, `.env.backup`, `.env.production` (solo se versionan `.env.example` y `.env.example.production`, sin contraseñas ni datos privados).
- Carpetas internas y de agentes: `.junie/`, `docs/planning/`, `pnpm-store/`, `docs/auditorias/`.
- IDEs y editores: `.idea/`, `.vscode/`, `*.sublime-*`, `.DS_Store`, `Thumbs.db`.
- Logs y cachés: `/storage/logs/*.log`, `bootstrap/cache/*.php`, `storage/framework/cache/`.
- Artefactos generados: `public/build/`, `public/sitemap.xml`, `public/docs/api/`, `.scribe/endpoints.cache/`.

### ⚠️ Política de commits — OBLIGATORIO
- **Commits atómicos o agrupados por funcionalidad**: cada commit debe agrupar únicamente cambios relacionados que compartan un mismo contexto (una funcionalidad, un fix, una refactorización, una actualización de dependencias, la documentación de un módulo...). Se cierra el commit de un contexto **antes** de pasar al siguiente.
- **Nada de commits inútiles**: no crear commits triviales o fragmentados sin contexto propio (p. ej. "fix typo" seguido de "fix typo 2", o un commit por archivo), ni commits "cajón de sastre" que mezclen funcionalidades distintas.
- **Separar estilo de lógica**: los cambios masivos de formato (Pint) van en un commit propio, sin mezclarse con cambios funcionales.
- **Cada commit debe dejar el proyecto estable**: los tests (`composer check`) deben pasar tras cada commit.
- **Mensaje descriptivo en español**: primera línea breve en imperativo/presente que resuma el contexto (≤ 72 caracteres) y, si aporta valor, un cuerpo con viñetas explicando el qué y el porqué.
- **Código, tests y documentación juntos**: si un cambio funcional requiere actualizar tests o `docs/info/`, se incluyen en el mismo commit de esa funcionalidad.

### Enlaces simbólicos de configuración unificada
- Los directorios `.claude` y `.github` deben ser enlaces simbólicos apuntando a `.agents`:
  ```bash
  ln -s .agents .claude && ln -s .agents .github
  ```
- El archivo `CLAUDE.md` debe ser un enlace simbólico directo apuntando a `AGENTS.md`:
  ```bash
  ln -s AGENTS.md CLAUDE.md
  ```

---

## 4. Roles y Permisos de la Plataforma

La plataforma implementa tres roles definidos mediante el enum respaldado `App\Enums\Role`:

| Rol | Valor (`role`) | Acceso Panel Admin (`/admin`) | Acceso Panel Usuario (`/panel`) | API REST | Propósito |
|-----|----------------|-------------------------------|---------------------------------|----------|-----------|
| **SuperAdmin** | `superadmin` | Sí (Total) | Sí | Sí | Control total del sistema, configuración, logs y auditoría |
| **Admin** | `admin` | Sí (Gestión) | Sí | Sí | Gestión de contenidos (posts, páginas, categorías, slides, secciones) |
| **User** | `user` | No | Sí (si `is_active = true`) | Sí | Usuario registrado general; gestiona su perfil y sus tokens de API |

> El método `canAccessPanel(Panel $panel)` en `App\Models\User` restringe el acceso al panel admin únicamente a usuarios con rol `superadmin` o `admin` y estado `is_active = true`.

---

## 5. Convenciones de Código y Estándares Obligatorios

### Idioma
- **Código (clases, métodos, propiedades, variables, rutas)**: Inglés estrictamente.
- **Comentarios y explicaciones**: Español.
- **Mensajes de validación y UI**: Español.
- **Comentarios de migraciones**: Español.

### Estilo y Calidad
- **PSR-12 estrictamente**: Formatear con Laravel Pint (`composer run pint`).
- **Tipado estricto**: Todas las funciones, métodos y propiedades deben contar con tipos nativos PHP (return types y parameter types sin excepción). Nunca usar `var`, siempre `string`, `int`, `bool`, `array`, `void`, etc.
- **Documentación PHPDoc**:
  - Todos los modelos Eloquent deben documentarse con `@property`, `@method` y relaciones en la cabecera de la clase.
  - Todos los métodos públicos deben contener DocBlocks completos con `@param` y `@return`.
  - Todas las migraciones deben estar comentadas explicando el propósito de tablas y columnas.
- **Tests automatizados obligatorios**: Toda funcionalidad o módulo nuevo implementado debe disponer de tests automatizados que la validen (`php artisan test --compact` o `composer check`).

### ⚠️ URLs y Rutas Dinámicas — OBLIGATORIO
**NUNCA escribir URLs hardcodeadas en vistas Blade ni controladores.**
- Usar siempre helpers de rutas nombradas: `route('home')`, `route('contact')`, `route('filament.admin.pages.dashboard')`.
- Las rutas de login y los paneles Filament deben ser totalmente dinámicas para poder desplegarse en cualquier dominio, subdominio o subdirectorio sin fallos de redirección.
- Las imágenes y assets subidos deben enlazarse dinámicamente:
  ```blade
  <img src="{{ Storage::disk('public')->url($model->image) }}" alt="{{ $model->title }}">
  ```
  O para archivos estáticos en `public/`:
  ```blade
  <img src="{{ asset('images/logo.png') }}" alt="Logo">
  ```

### ⚠️ Textos y Traducciones en Vistas Blade — OBLIGATORIO
**NUNCA escribir textos hardcodeados en vistas Blade.**
1. **Textos estáticos de interfaz**: Usar `__('messages.key')` o `__('Log in')` (vía `lang/es.json` y `lang/{es,en}/messages.php`).
2. **Contenido dinámico de modelos**: Usar `$model->getTranslation('campo', app()->getLocale())`.
3. El idioma por defecto es español (`es`), fallback en inglés (`en`). La zona horaria en `config/app.php` es siempre `UTC`; el frontend muestra las fechas formateadas en español (`d/m/Y`) o según la configuración local del usuario.

### ⚠️ Backend Filament — Traducciones y Formularios
1. **Traducción integral**: Todos los labels de formulario, columnas de tabla, badges, acciones y títulos (`getModelLabel()`, `getPluralModelLabel()`, `getNavigationGroup()`) deben usar `__('filament.key')` con correspondencia exacta en `lang/es/filament.php` y `lang/en/filament.php`.
2. **Subida de imágenes con editor**: Todo campo `FileUpload` en Filament se implementará con cropper/editor por defecto (`->imageEditor()`), preferentemente utilizando la clase helper `App\Filament\Components\ImageCropField`:
   - 16:9 (`make16x9()`): Imagen principal de posts, páginas, secciones, slides, categorías.
   - 8:12 (`make8x12()`): Imagen vertical de slides.
   - 4:3 (`make4x3()`): Avatares de usuario.
3. **Validación permisiva pero segura**: Gestionar los errores de validación mediante notificaciones nativas de Filament (`Notification::make()->danger()->send()`), sin generar bloques HTML crudos.

### ⚠️ Formularios Públicos, Rate Limiting y Google reCAPTCHA v3
- **Rate limiting activo**: Todos los formularios públicos de la web (contacto, login, registro, recuperación de contraseña, newsletter, etc.) deben incluir protección contra abuso mediante `throttle:10,1` en su ruta POST.
- **Protección Google reCAPTCHA v3**:
  - Implementada mediante la regla `App\Rules\Recaptcha`.
  - **Comprobación condicional**: Si las claves `RECAPTCHA_SITE_KEY` o `RECAPTCHA_SECRET_KEY` no están definidas en el `.env`, la validación se ignora automáticamente para permitir desarrollo local y tests sin bloqueos.
  - **Sin honeypots**: No crear campos honeypot a menos que se solicite explícitamente.
  - En la vista Blade, incluir el componente invisible `<x-recaptcha-script action="nombre_accion" />`.

---

## 6. Catálogo de Componentes UI Reutilizables

Consulte la especificación completa en [COMPONENTS.md](docs/info/COMPONENTS.md).

> **DIRECTRIZ DE REUTILIZACIÓN**: Se prohíbe maquetar botones, inputs, modales, alertas o dropdowns con clases Tailwind manuales si ya existe un componente Blade equivalente en `resources/views/components/`:
> - Botones: `<x-primary-button>`, `<x-secondary-button>`, `<x-danger-button>`
> - Formulario: `<x-text-input>`, `<x-input-label>`, `<x-input-error>`, `<x-recaptcha-script>`
> - Mensajes: `<x-flash-messages>`, `<x-auth-session-status>`
> - Navegación: `<x-nav-link>`, `<x-responsive-nav-link>`, `<x-dropdown>`, `<x-modal>`, `<x-language-switcher>`
> - Contenido: `<x-post-card>`, `<x-section-block>`, `<x-slide-carousel>`, `<x-pagination>`

---

## 7. Catálogo de Comandos Propios

Consulte la especificación detallada en [commands.md](docs/info/commands.md).

| Comando | Función Principal |
|---------|-------------------|
| `php artisan project:install {--force}` | Instalación guiada o desatendida del entorno, migraciones, seeders y assets |
| `php artisan project:clear {--force}` | Limpieza profunda de cachés, reinicio de colas, rotación segura de `APP_KEY` y `composer dump-autoload` |
| `php artisan project:dummy {--fresh}` | Inserción de datos corporativos de muestra en todos los módulos (para clientes y desarrollo) |
| `php artisan sitemap:generate` | Generación de `public/sitemap.xml` con alternates hreflang para todas las rutas públicas |
| `php artisan manual:generate-pdf` | Compilación de los manuales Markdown a PDFs corporativos |

---

## 8. Protocolo de Planificación con Checklists

Cuando se planifique una tarea, fase o módulo nuevo en el proyecto:
1. Toda fase o módulo debe comenzar con una **descripción clara del objetivo**.
2. Toda fase o módulo debe finalizar con un **checklist de verificación** (`- [ ] Tarea...`).
3. Un elemento del checklist **solo se marcará como verificado (`[x]`) cuando se haya comprobado y ejecutado en el sistema real** que la funcionalidad se cumple perfectamente.

Las dudas de implementación o planificación se registran en `docs/planning/dudas/` agrupadas, numeradas, con hueco para responder y control de estado (`[ ] Pendiente` | `[x] Resuelta` | `[ ] Ignorada`).

Las auditorías de código solicitadas se documentan en `docs/auditorias/` (directorio excluido en `.gitignore`).

---

## 9. ⚠️ Protocolo de Documentación Técnica Viva (`docs/info/`)

La documentación de cada módulo se encuentra en `docs/info/`. **Es obligatorio por protocolo mantenerla actualizada ante cualquier cambio en el código.**

### Reglas de Mantenimiento de Documentación:
1. **Fecha de actualización obligatoria**: **TODO** archivo de documentación dentro de `docs/` en cualquier subdirectorio debe llevar obligatoriamente la fecha de actualización (`*Última actualización: YYYY-MM-DD*`) para auditar su vigencia.
2. **Modificación de módulos**: Al modificar campos, relaciones, lógica o rutas de un módulo, actualizar su respectivo archivo `.md` en `docs/info/`.
3. **Nuevos módulos**: Crear su archivo `.md` en `docs/info/`, añadirlo al índice `docs/info/README.md` y a la tabla de `AGENTS.md`.
4. **Diseño visual**: Todo lo referente a tokens Tailwind CSS v4, layout y paleta se documenta en `docs/info/DESIGN.md`.
5. **Componentes UI**: Se documentan exhaustivamente en `docs/info/COMPONENTS.md`.
6. **APIs**:
   - Cómo nuestra app consume o integra APIs de terceros se documenta en `docs/info/apis/`.
   - La documentación oficial externa del proveedor se sitúa en `docs/apis/` como referencia.
   - Cada archivo en `docs/info/apis/` debe enlazar a la documentación oficial en `docs/apis/`.
7. **Plantilla oficial**: Para documentar cualquier nuevo módulo, usar como base la plantilla obligatoria `docs/info/_MODULE_TEMPLATE.md`.

> 💡 **Directriz de Lectura Dirigida y Economía de Tokens**: Al trabajar en un módulo o funcionalidad específica (ej. noticias, páginas, usuarios), el agente debe consultar **únicamente** el archivo técnico correspondiente en `docs/info/[modulo].md` y la guía de diseño en `docs/info/DESIGN.md` en caso de tocar el frontend/vistas. No debe leer el resto de archivos de `docs/info/` a menos que sea estrictamente necesario para resolver una relación cruzada entre modelos.

### Tabla Índice de Documentación Técnica (`docs/info/`)

| Archivo | Módulo |
|---------|--------|
| [_MODULE_TEMPLATE.md](docs/info/_MODULE_TEMPLATE.md) | Plantilla oficial obligatoria de 7 puntos para documentar nuevos módulos |
| [content_builder.md](docs/info/content_builder.md) | Especificación técnica del constructor modular de bloques (Page / Post Builder) |
| [COMPONENTS.md](docs/info/COMPONENTS.md) | Catálogo de componentes Blade UI reutilizables y directrices |
| [DESIGN.md](docs/info/DESIGN.md) | Especificación de diseño, esquema Tailwind CSS v4 y layout |
| [commands.md](docs/info/commands.md) | Especificación completa de comandos Artisan personalizados |
| [apis/README.md](docs/info/apis/README.md) | Arquitectura y consumo de APIs externas en la aplicación |
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
| [acciones-admin.md](docs/info/acciones-admin.md) | Acciones del panel admin (Sitemap, Caché, Logs) |


---

## 10. Estructura Completa de Directorios del Proyecto

> ⚠️ **Nota para agentes**: Esta estructura debe mantenerse actualizada si se añaden o eliminan directorios relevantes.

```
skeleton-laravel-project/
├── .agents/                      # Configuración centralizada de agentes y automatizaciones
├── .claude -> .agents            # Enlace simbólico a .agents
├── .github -> .agents            # Enlace simbólico a .agents
├── CLAUDE.md -> AGENTS.md        # Enlace simbólico a AGENTS.md
├── AGENTS.md                     # Directrices maestras del proyecto
├── README.md                     # Documentación de instalación y despliegue
├── app/
│   ├── Console/Commands/         # ProjectInstall, ProjectClear, ProjectDummy, GenerateSitemap, GenerateManualPdf
│   ├── Enums/                    # Role (superadmin, admin, user), ContentStatus, EmailStatus
│   ├── Filament/
│   │   ├── Admin/                # Panel Admin (/admin): Resources, Pages, Widgets
│   │   │   ├── Pages/            # ClearCache, RegenerateSitemap, ViewLogs
│   │   │   ├── Resources/        # User, Post, Page, Category, Slide, Section, Setting, SentEmail
│   │   │   └── Widgets/          # StatsOverviewWidget, PostsChartWidget, LatestEmailsWidget, LogDownloadWidget
│   │   ├── Components/           # ImageCropField (helper de imágenes con croppers estándar)
│   │   └── Panel/                # Panel Usuario (/panel): EditProfile, ApiTokens, WelcomeWidget
│   ├── Http/
│   │   ├── Controllers/          # Controladores Web, Auth y API v1
│   │   ├── Middleware/           # SetLocale, SecurityHeaders
│   │   └── Requests/             # FormRequests (ContactRequest, LoginRequest, etc.)
│   ├── Mail/                     # ContactMail, WelcomeMail, GenericMail
│   ├── Models/                   # User, Post, Page, Category, Slide, Section, Setting, SentEmail
│   ├── Policies/                 # Políticas de autorización por modelo
│   ├── Providers/
│   │   └── Filament/             # AdminPanelProvider (/admin), PanelUserProvider (/panel)
│   ├── Rules/                    # Reglas de validación personalizadas (Recaptcha)
│   ├── Services/                 # EmailService, SeoService, SettingService, SitemapService
│   └── Traits/                   # HasSlug, HasStatus, HasSeo, BelongsToUser
├── bootstrap/                    # Arranque del framework y configuración de proveedores
├── config/                       # Archivos de configuración (app, database, services, etc.)
├── database/
│   ├── factories/                # Factorías de modelos para tests
│   ├── migrations/               # Migraciones comentadas de PostgreSQL
│   └── seeders/                  # UserSeeder, SettingSeeder, CategorySeeder, PageSeeder, PostSeeder, SlideSeeder, SectionSeeder
├── docs/
│   ├── apis/                     # Documentación técnica oficial externa de APIs
│   ├── auditorias/               # Auditorías solicitadas de código (gitignored)
│   ├── deploys/                  # Configuraciones de Nginx, Apache y script deploy.sh
│   ├── info/                     # Documentación técnica viva de módulos, DESIGN.md, COMPONENTS.md, commands.md
│   │   └── apis/                 # Documentación de integración de APIs en la aplicación
│   ├── manual/                   # Manuales de usuario Markdown (admin, user, user_backend) y PDFs generados
│   └── planning/                 # Historial de planificación y dudas/ (gitignored)
│       └── dudas/                # Registro de dudas y decisiones técnicas
├── lang/                         # Archivos de idioma es/, en/ y lang/es.json
├── public/                       # Punto de entrada público index.php, imágenes, logos y storage/
├── resources/
│   ├── css/                      # app.css con Tailwind CSS v4 (@theme)
│   ├── js/                       # app.js y componentes
│   └── views/                    # Plantillas Blade (auth/, components/, layouts/, posts/, pages/, etc.)
├── routes/                       # web.php, auth.php, api.php, console.php
└── tests/                        # Tests Feature y Unit (Auth, Web, Admin, Api, Services)
```

---

## 11. Mapa Completo de Rutas

### Rutas Web Públicas
- `GET  /` (`home`): Portada principal del sitio con carrusel, secciones dinámicas y novedades.
- `GET  /blog` (`blog.index`): Listado paginado de posts publicados con filtro de categorías.
- `GET  /blog/{slug}` (`blog.show`): Vista detallada de un artículo de blog.
- `GET  /pages/{slug}` (`pages.show`): Vista de página de contenido dinámico o legal.
- `GET  /contact` (`contact`): Formulario de contacto con rate limiting y reCAPTCHA v3.
- `POST /contact` (`contact.send`): Envío del formulario de contacto (`throttle:10,1`).
- `GET  /about` (`about`): Página institucional Sobre Nosotros.
- `GET  /privacy` (`privacy`): Política de privacidad.
- `GET  /cookies` (`cookies`): Política de cookies.
- `GET  /lang/{locale}` (`language.switch`): Cambio de idioma activo en sesión.
- `GET  /admin/logs/download/{filename}` (`admin.logs.download`): Descarga segura de archivo de log (solo admin).

### Rutas de Autenticación Web (Breeze)
- `GET  /login` (`login`): Pantalla de inicio de sesión.
- `POST /login`: Procesamiento de login (`throttle:10,1`, reCAPTCHA v3).
- `POST /logout` (`logout`): Cierre de sesión y revocación.
- `GET  /register` (`register`): Pantalla de registro de usuario.
- `POST /register`: Registro de nuevo usuario (`throttle:10,1`, reCAPTCHA v3).
- `GET  /forgot-password` (`password.request`): Solicitud de recuperación de contraseña.
- `POST /forgot-password` (`password.email`): Envío del enlace de recuperación (`throttle:10,1`, reCAPTCHA v3).
- `GET  /reset-password/{token}` (`password.reset`): Formulario de restablecimiento.
- `POST /reset-password` (`password.store`): Procesamiento de nueva contraseña (`throttle:10,1`, reCAPTCHA v3).
- `GET  /verify-email` (`verification.notice`): Aviso de verificación de email.
- `GET  /verify-email/{id}/{hash}` (`verification.verify`): Confirmación de email firmado.
- `POST /email/verification-notification` (`verification.send`): Reenvío de confirmación.

### Rutas Panel Admin Filament (`/admin`)
- `GET  /admin` (`filament.admin.pages.dashboard`): Dashboard del administrador con estadísticas y widgets.
- `GET  /admin/login` (`filament.admin.auth.login`): Login específico del panel admin.
- `POST /admin/logout` (`filament.admin.auth.logout`): Cierre de sesión de administración.
- CRUDs de Administración:
  - `/admin/users`: Listado, creación y edición de usuarios.
  - `/admin/posts`: Gestión de artículos de blog y traducciones.
  - `/admin/pages`: Gestión de páginas y metadatos SEO.
  - `/admin/categories`: Gestión de categorías compartidas.
  - `/admin/slides`: Gestión de carruseles de imágenes por zona.
  - `/admin/sections`: Gestión de bloques dinámicos de contenido.
  - `/admin/settings`: Ajustes clave-valor globales de la plataforma.
  - `/admin/sent-emails`: Auditoría de emails enviados y errores.
- Acciones de Sistema:
  - `/admin/clear-cache`: Limpieza de caché desde la intranet.
  - `/admin/regenerate-sitemap`: Regeneración manual de `sitemap.xml`.
  - `/admin/view-logs`: Explorador y visor de logs del sistema.

### Rutas Panel Usuario Filament (`/panel`)
- `GET  /panel` (`filament.panel.pages.dashboard`): Dashboard del usuario con bienvenida y resumen de tokens.
- `GET  /panel/edit-profile` (`filament.panel.pages.edit-profile`): Edición de datos del perfil y contraseña propia.
- `GET  /panel/api-tokens` (`filament.panel.pages.api-tokens`): Creación y revocación de tokens API personales Sanctum.
- `GET  /panel/login`: Login de usuarios al panel.
- `GET  /panel/register`: Registro directo desde el panel.

### Rutas API REST (`/api/v1`)
- **Públicas**:
  - `GET  /api/v1/posts`: Listado de posts publicados.
  - `GET  /api/v1/posts/{slug}`: Detalle de post.
  - `GET  /api/v1/pages`: Listado de páginas.
  - `GET  /api/v1/pages/{slug}`: Detalle de página.
  - `GET  /api/v1/categories`: Taxonomía y categorías.
  - `POST /api/v1/auth/register`: Registro de usuario vía API.
  - `POST /api/v1/auth/login`: Obtención de Bearer token.
  - `POST /api/v1/auth/forgot-password`: Recuperación de password vía API.
  - `POST /api/v1/auth/reset-password`: Restablecimiento de password vía API.
- **Autenticadas (Bearer token)**:
  - `GET    /api/v1/auth/user`: Datos del usuario autenticado.
  - `POST   /api/v1/auth/logout`: Revocación del token activo.
  - `GET    /api/v1/user/tokens`: Listado de tokens propios.
  - `POST   /api/v1/user/tokens`: Generación de nuevo token API.
  - `DELETE /api/v1/user/tokens/{tokenId}`: Eliminación de token.
- **Documentación API**:
  - `GET  /docs`: Documentación interactiva de la API (Scribe).
