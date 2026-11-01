# Documentación técnica de módulos

*Última actualización: 2026-11-01*

Este directorio contiene la documentación técnica viva y detallada de cada módulo implementado en la plataforma. Cada archivo describe el objetivo, la arquitectura, los archivos involucrados, los campos, las relaciones, qué es editable desde el panel y el comportamiento de un módulo concreto.

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
| [SettingService y Helpers](servicio-settings.md) | `servicio-settings.md` | Acceso cacheado a configuración y helpers globales (`setting`, `media_url`, `storage_image`, `format_date`) |
| [SitemapService](servicio-sitemap.md) | `servicio-sitemap.md` | Generación automática del sitemap XML |

### Estándares y Constructor Modular

| Documento | Archivo | Descripción |
|-----------|---------|-------------|
| [Plantilla Oficial de Módulos](_MODULE_TEMPLATE.md) | `_MODULE_TEMPLATE.md` | Estructura obligatoria de 7 puntos para documentar nuevos módulos |
| [Constructor Modular de Contenido](content_builder.md) | `content_builder.md` | Especificación técnica de bloques dinámicos (Page / Post Builder) |

### Infraestructura, Diseño y UI

| Módulo | Archivo | Descripción |
|--------|---------|-------------|
| [Catálogo de Componentes UI](COMPONENTS.md) | `COMPONENTS.md` | Catálogo de componentes Blade reutilizables y directrices |
| [Guía de Diseño y Estilos](DESIGN.md) | `DESIGN.md` | Tokens Tailwind CSS v4, layout, tipografía y esquema de color |
| [Autenticación y autorización](autenticacion.md) | `autenticacion.md` | Auth web por sesión, API (Sanctum), policies y guards |
| [Traducciones](traducciones.md) | `traducciones.md` | Sistema i18n: archivos de idioma, modelos traducibles, middleware |
| [Panel Admin Filament](panel-admin.md) | `panel-admin.md` | Panel de administración con todos los Resources |
| [Panel Usuario Filament](panel-usuario.md) | `panel-usuario.md` | Panel de usuario con perfil y tokens API |
| [API REST](api-rest.md) | `api-rest.md` | Endpoints públicos y autenticados de la API v1 |
| [Integración de APIs](apis/README.md) | `apis/README.md` | Arquitectura de consumo de APIs externas |
| [Frontend público](frontend.md) | `frontend.md` | Vistas Blade, layout, componentes y páginas públicas |
| [Traits](traits.md) | `traits.md` | Traits reutilizables: HasSlug, HasStatus, HasSeo, BelongsToUser |
| [Enums](enums.md) | `enums.md` | Enums PHP: Role, ContentStatus, EmailStatus |
| [Comandos Artisan](commands.md) | `commands.md` | Comandos personalizados: project:install, project:clear, project:dummy, sitemap:generate, manual:generate-pdf |
| [Acciones Admin](acciones-admin.md) | `acciones-admin.md` | Acciones del panel admin (Sitemap, Caché, Logs) |


