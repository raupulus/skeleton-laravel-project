# Skeleton Laravel Project

*Última actualización: 2026-08-26*

Plantilla base profesional para aplicaciones Laravel con arquitectura modular, robusta y lista para producción.
Incluye autenticación web y API, panel de administración Filament, sistema de contenidos bilingüe (posts, páginas, slides, secciones), configuraciones dinámicas, registro de auditoría de emails, SEO automatizado, Docker y suite de tests.

---

## Stack tecnológico

| Tecnología | Versión | Propósito en el proyecto |
|-----------|---------|--------------------------|
| **PHP** | 8.4 | Lenguaje base con tipado estricto, backed enums y readonly properties |
| **Laravel** | 13.x | Framework principal |
| **PostgreSQL** | 16.x | **Motor de base de datos obligatorio** (`DB_CONNECTION=pgsql`) |
| **Filament** | 5.x | Panel de administración (`/admin`) y panel de usuario (`/panel`) |
| **Tailwind CSS** | 4.x | Estilos frontend utilitarios configurados con `@theme` |
| **Alpine.js** | 3.x | Interactividad ligera, dropdowns y modales |
| **Vue 3** | 3.x | Preparado en el frontend para componentes enriquecidos |
| **Laravel Sanctum** | 4.x | Autenticación API con Bearer tokens personales |
| **spatie/laravel-translatable** | 6.x | Traducciones directas en campos de modelos |
| **spatie/laravel-sitemap** | 7.x | Generación automática del sitemap XML multi-idioma |
| **knuckleswtf/scribe** | 4.x | Documentación interactiva de la API REST (`/docs`) |

---

## Requisitos previos

- **PHP 8.4** o superior con extensiones: `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `curl`, `gd` / `imagick`, `fileinfo`, `xml`.
- **PostgreSQL 16** instalado y corriendo localmente o mediante Docker.
- **Composer 2.7+**
- **Node.js 20+** y **npm 10+**

---

## Instalación en Desarrollo Local

### Opción 1: Inicio Rápido Automatizado

```bash
# 1. Clonar el repositorio
git clone https://github.com/tuusuario/skeleton-laravel-project.git
cd skeleton-laravel-project

# 2. Configurar entorno inicial
cp .env.example .env

# 3. Ajustar credenciales de PostgreSQL en .env:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=skeleton_laravel
# DB_USERNAME=postgres
# DB_PASSWORD=tu_password

# 4. Instalar dependencias, generar clave, migrar y enlazar storage
php artisan project:install

# 5. Poblar con contenido corporativo de muestra
php artisan project:dummy

# 6. Iniciar entorno de desarrollo concurrente (servidor, vite, colas, logs)
composer run dev
```

### Opción 2: Instalación Manual Paso a Paso

```bash
# 1. Variables de entorno
cp .env.example .env

# 2. Dependencias PHP y JS
composer install
npm install

# 3. Clave y Storage
php artisan key:generate
php artisan storage:link

# 4. Base de datos (PostgreSQL)
php artisan migrate

# 5. Cargar datos corporativos de prueba
php artisan project:dummy

# 6. Compilar assets frontend
npm run build
# o para desarrollo interactivo:
npm run dev
```

---

## Despliegue con Docker

El proyecto incluye configuración Docker lista para desarrollo y pruebas de despliegue:

| Servicio | Imagen | Puerto | Descripción |
|----------|--------|--------|-------------|
| **app** | PHP 8.4-FPM personalizada | - | Aplicación Laravel |
| **nginx** | Alpine Nginx | 8000 | Servidor web y reverse proxy |
| **db** | `postgres:16-alpine` | 5432 | Base de datos PostgreSQL |
| **redis** | `redis:7-alpine` | 6379 | Caché y colas en segundo plano |

```bash
# 1. Iniciar los contenedores
cp .env.example .env
docker compose up -d

# 2. Ejecutar la instalación desatendida dentro del contenedor app
docker compose exec app php artisan project:install --force

# 3. Poblar datos corporativos
docker compose exec app php artisan project:dummy

# 4. Acceso web
# Aplicación: http://localhost:8000
# Panel Admin: http://localhost:8000/admin
```

---

## Despliegue en Servidor de Producción

Consulte las configuraciones de servidor en `docs/deploys/` (`nginx.conf`, `apache.conf`, `deploy.sh`).

### Guía de Despliegue Paso a Paso:

```bash
# 1. Clonar el código en el directorio del servidor
git clone https://github.com/tuusuario/skeleton-laravel-project.git /var/www/mi-proyecto
cd /var/www/mi-proyecto

# 2. Preparar el entorno de producción
cp .env.example.production .env

# 3. Configurar en .env los valores reales:
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://tudominio.com
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_DATABASE=nombre_bd_prod
# DB_USERNAME=usuario_bd_prod
# DB_PASSWORD=contrasena_fuerte
# RECAPTCHA_SITE_KEY=clave_publica_google
# RECAPTCHA_SECRET_KEY=clave_secreta_google

# 4. Instalar dependencias optimizadas
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# 5. Clave de cifrado y Storage
php artisan key:generate --force
php artisan storage:link

# 6. Migraciones de base de datos
php artisan migrate --force

# 7. Caché y optimización de Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

# 8. Generar sitemap inicial
php artisan sitemap:generate

# 9. Configurar permisos de almacenamiento
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Automatización con `deploy.sh`:

Para despliegues continuos posteriores, puede utilizar el script incluido:
```bash
bash docs/deploys/deploy.sh
```

---

## Scripts de Calidad y Formateo (Composer)

El archivo `composer.json` provee atajos estandarizados para validación de código:

```bash
# Formatear el código con Laravel Pint
composer run pint

# Comprobar si el código cumple los estándares PSR-12 sin modificarlo
composer run pint:test

# Verificación completa (formato + tests automatizados compactos)
composer run check
```

---

## Catálogo de Comandos Artisan Propios

| Comando | Descripción |
|---------|-------------|
| `php artisan project:install {--force}` | Instalación paso a paso o desatendida del proyecto |
| `php artisan project:clear {--force}` | Limpieza integral de cachés, colas, rotación segura de `APP_KEY` y recomposición de autoload |
| `php artisan project:dummy {--fresh}` | Inserción de datos corporativos de muestra en todos los módulos (Users, Settings, Categories, Pages, Posts, Slides, Sections, SentEmails) |
| `php artisan sitemap:generate` | Genera `public/sitemap.xml` con alternates hreflang para todas las páginas y artículos publicados |
| `php artisan manual:generate-pdf` | Compila los manuales de usuario Markdown a PDFs corporativos |

Especificación detallada de cada comando en [docs/info/commands.md](docs/info/commands.md).

---

## Seguridad y Formularios Públicos

- **Rate Limiting**: Todos los formularios públicos (`/contact`, `/login`, `/register`, `/forgot-password`, `/reset-password`) tienen activado rate limiting estricto (`throttle:10,1`).
- **Google reCAPTCHA v3**: Integrado en formularios públicos mediante la regla `App\Rules\Recaptcha`.
  - **Comprobación condicional**: Si las variables `RECAPTCHA_SITE_KEY` o `RECAPTCHA_SECRET_KEY` no están definidas en `.env`, la validación se ignora automáticamente para permitir desarrollo local y tests sin bloqueos.
  - Sin campos honeypot innecesarios.

---

## Paneles Filament

- **Panel Administrador (`/admin`)**:
  - Acceso restringido a usuarios con rol `admin` o `superadmin` e `is_active = true`.
  - Gestión integral de usuarios, categorías, páginas, artículos de blog, carruseles de diapositivas, secciones dinámicas, configuraciones y auditoría de emails enviados.
  - Acciones de mantenimiento integradas: regenerar sitemap, limpiar caché y visualizador de logs.
- **Panel de Usuario (`/panel`)**:
  - Acceso para usuarios con rol `user` e `is_active = true`.
  - Gestión de perfil de usuario y generación/revocación de tokens personales de API (Sanctum).

---

## Documentación Técnica y Manuales

Toda la documentación técnica del proyecto se mantiene viva y actualizada bajo `docs/`:

- **[Índice de Módulos Técnicos](docs/info/README.md)**: Explicación de modelos, servicios, controladores y paneles.
- **[Catálogo de Componentes UI](docs/info/COMPONENTS.md)**: Componentes Blade normalizados (`<x-primary-button>`, `<x-text-input>`, `<x-modal>`, etc.).
- **[Guía de Diseño Visual](docs/info/DESIGN.md)**: Esquema de colores, tipografía Figtree y Tailwind CSS v4.
- **[Comandos Artisan](docs/info/commands.md)**: Documentación exhaustiva de comandos propios y su ejecución periódica.
- **[Manuales de Usuario](docs/manual/)**: Documentación orientada al cliente final con PDFs descargables (`admin.pdf`, `user_backend.pdf`, `user.pdf`).

---

## Licencia

Este proyecto es software de código abierto bajo la licencia [MIT](LICENSE).
