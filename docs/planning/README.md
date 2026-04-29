# Planificación del Proyecto — Skeleton Laravel Project

## Índice de fases

| Fase | Archivo | Descripción |
|------|---------|-------------|
| 01 | [01-setup-inicial.md](fases/01-setup-inicial.md) | Crear proyecto Laravel 13, instalar paquetes, configurar paneles Filament, Vue 3, Sanctum, estructura de directorios |
| 02 | [02-base-de-datos.md](fases/02-base-de-datos.md) | Enums PHP 8.4, migraciones de todas las tablas con comments en español |
| 03 | [03-modelos-y-relaciones.md](fases/03-modelos-y-relaciones.md) | Traits (HasSlug, HasStatus, HasSeo, BelongsToUser), modelos Eloquent, factories |
| 04 | [04-autenticacion-y-autorizacion.md](fases/04-autenticacion-y-autorizacion.md) | Breeze, Sanctum API auth, Policies, middleware SetLocale, guards Filament |
| 05 | [05-form-requests-y-validacion.md](fases/05-form-requests-y-validacion.md) | FormRequests para auth API, contacto y tokens con mensajes en español |
| 06 | [06-services-y-logica-de-negocio.md](fases/06-services-y-logica-de-negocio.md) | EmailService, SettingService, SitemapService, SeoService, helper setting() |
| 07 | [07-controladores-y-rutas.md](fases/07-controladores-y-rutas.md) | Controladores web y API, rutas web.php y api.php completas |
| 08 | [08-vistas-blade.md](fases/08-vistas-blade.md) | Layouts, meta tags SEO completos, componentes Blade, páginas, emails, Vue 3 |
| 09 | [09-panel-filament.md](fases/09-panel-filament.md) | Panel Admin (8 Resources + widgets) y Panel Usuario (perfil + tokens API) |
| 10 | [10-servicios-auxiliares.md](fases/10-servicios-auxiliares.md) | Mailables, Scribe API docs, notificaciones Filament |
| 11 | [11-seeders-y-datos-iniciales.md](fases/11-seeders-y-datos-iniciales.md) | Seeders idempotentes para todas las entidades con datos de ejemplo |
| 12 | [12-tests.md](fases/12-tests.md) | Tests auth web/API, policies, EmailService, SettingService, rutas públicas |
| 13 | [13-comando-sitemap.md](fases/13-comando-sitemap.md) | Comando sitemap:generate con hreflang y programación diaria |
| 14 | [14-optimizacion-y-pulido.md](fases/14-optimizacion-y-pulido.md) | Eager loading, caché, índices compuestos, comandos de producción |
| 15 | [15-acciones-adicionales.md](fases/15-acciones-adicionales.md) | .env examples, .gitignore, .aiignore, nginx/apache configs, git init |
| 16 | [16-comandos.md](fases/16-comandos.md) | Comandos project:install y project:clear |
| 17 | [17-documentacion.md](fases/17-documentacion.md) | PHPDoc en español, README.md, AGENTS.md |
| 18 | [18-dockerizar.md](fases/18-dockerizar.md) | Dockerfile multi-stage, docker-compose, volúmenes persistentes |

## Orden de ejecución

Las fases deben ejecutarse secuencialmente (01 → 18) ya que cada fase depende de las anteriores. Dentro de cada fase, los pasos también deben ejecutarse en orden.

## Resumen de entidades

| Entidad | Tabla | Traducible | CRUD Admin | API pública |
|---------|-------|-----------|------------|-------------|
| User | users | No | ✅ | Auth endpoints |
| Category | categories | ✅ (name, description) | ✅ | ✅ (index, show) |
| Page | pages | ✅ (title, content, excerpt, seo_*) | ✅ | ✅ (index, show) |
| Post | posts | ✅ (title, content, excerpt, seo_*) | ✅ | ✅ (index, show) |
| Slide | slides | ✅ (title, content) | ✅ | — |
| Section | sections | ✅ (title, description, content) | ✅ | — |
| Setting | settings | No | ✅ | — |
| SentEmail | sent_emails | No | ✅ (solo lectura) | — |
