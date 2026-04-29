# Documentación técnica de módulos

Este directorio contiene la documentación técnica detallada de cada módulo implementado en la plataforma. Cada archivo describe el objetivo, la arquitectura, los archivos involucrados, los campos, las relaciones y el comportamiento de un módulo concreto.

## Índice de módulos

### Modelos y datos

| Módulo | Archivo | Descripción |
|--------|---------|-------------|
| [Usuarios](usuarios.md) | `usuarios.md` | Gestión de usuarios, roles y autenticación |
| [Posts](posts.md) | `posts.md` | Sistema de blog con artículos traducibles |
| [Páginas](paginas.md) | `paginas.md` | Páginas de contenido estático/dinámico traducibles |
| [Categorías](categorias.md) | `categorias.md` | Taxonomía compartida entre posts y páginas |
| [Slides](slides.md) | `slides.md` | Carruseles de imágenes agrupados por zona |
| [Secciones](secciones.md) | `secciones.md` | Bloques de contenido dinámico del frontend |
| [Configuración](configuracion.md) | `configuracion.md` | Ajustes globales del sistema (key-value) |
| [Emails enviados](emails-enviados.md) | `emails-enviados.md` | Registro de auditoría de emails |

### Servicios

| Módulo | Archivo | Descripción |
|--------|---------|-------------|
| [EmailService](servicio-email.md) | `servicio-email.md` | Envío centralizado de emails con registro automático |
| [SeoService](servicio-seo.md) | `servicio-seo.md` | Gestión dinámica de meta tags SEO |
| [SettingService](servicio-settings.md) | `servicio-settings.md` | Acceso cacheado a la configuración del sistema |
| [SitemapService](servicio-sitemap.md) | `servicio-sitemap.md` | Generación automática del sitemap XML |

### Infraestructura

| Módulo | Archivo | Descripción |
|--------|---------|-------------|
| [Autenticación y autorización](autenticacion.md) | `autenticacion.md` | Auth web (Breeze), API (Sanctum), policies y guards |
| [Traducciones](traducciones.md) | `traducciones.md` | Sistema i18n: archivos de idioma, modelos traducibles, middleware |
| [Panel Admin Filament](panel-admin.md) | `panel-admin.md` | Panel de administración con todos los Resources |
| [Panel Usuario Filament](panel-usuario.md) | `panel-usuario.md` | Panel de usuario con perfil y tokens API |
| [API REST](api-rest.md) | `api-rest.md` | Endpoints públicos y autenticados de la API v1 |
| [Frontend público](frontend.md) | `frontend.md` | Vistas Blade, layout, componentes y páginas públicas |
| [Traits](traits.md) | `traits.md` | Traits reutilizables: HasSlug, HasStatus, HasSeo, BelongsToUser |
| [Enums](enums.md) | `enums.md` | Enums PHP: Role, ContentStatus, EmailStatus |
| [Comandos Artisan](comandos.md) | `comandos.md` | Comandos personalizados: project:install, project:clear, sitemap:generate, manual:generate-pdf |
