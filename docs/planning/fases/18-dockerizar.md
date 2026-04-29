# Fase 18 — Dockerizar

## Resumen
En esta fase se preparará la dockerización del proyecto con Docker y Docker Compose, configurando PHP-FPM, Nginx, PostgreSQL y volúmenes para storage persistente.

**Dependencias**: Fases 01-17 completadas.

---

## Paso 18.1 — Dockerfile

Archivo: `laravel_project/Dockerfile`

```dockerfile
# Etapa 1: Build de assets
FROM node:22-alpine AS node-builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources/ resources/
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# Etapa 2: Dependencias PHP
FROM composer:latest AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Etapa 3: Imagen final
FROM php:8.4-fpm-alpine

# Instalar extensiones PHP necesarias
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    mbstring \
    intl \
    opcache \
    pcntl \
    bcmath

# Configuración de PHP para producción
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# Copiar dependencias desde builders
COPY --from=composer-builder /app/vendor vendor/
COPY --from=node-builder /app/public/build public/build/

# Copiar código del proyecto
COPY . .

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Exponer puerto PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
```

---

## Paso 18.2 — Docker Compose

Archivo: `laravel_project/docker-compose.yml`

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: ${APP_CONTAINER_NAME:-skeleton-app}
    restart: unless-stopped
    volumes:
      - ${STORAGE_PATH:-./storage}:/var/www/html/storage
      - ./public/images:/var/www/html/public/images
    environment:
      - APP_ENV=${APP_ENV:-production}
      - APP_DEBUG=${APP_DEBUG:-false}
      - APP_URL=${APP_URL:-http://localhost}
      - DB_CONNECTION=pgsql
      - DB_HOST=db
      - DB_PORT=5432
      - DB_DATABASE=${DB_DATABASE:-skeleton_laravel}
      - DB_USERNAME=${DB_USERNAME:-postgres}
      - DB_PASSWORD=${DB_PASSWORD:-secret}
      - CACHE_DRIVER=${CACHE_DRIVER:-file}
      - QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
      - SESSION_DRIVER=${SESSION_DRIVER:-file}
    depends_on:
      db:
        condition: service_healthy
    networks:
      - skeleton-network

  nginx:
    image: nginx:stable-alpine
    container_name: ${NGINX_CONTAINER_NAME:-skeleton-nginx}
    restart: unless-stopped
    ports:
      - "${NGINX_PORT:-80}:80"
    volumes:
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:ro
      - ./public:/var/www/html/public:ro
      - ${STORAGE_PATH:-./storage}/app/public:/var/www/html/storage/app/public:ro
    depends_on:
      - app
    networks:
      - skeleton-network

  db:
    image: postgres:17-alpine
    container_name: ${DB_CONTAINER_NAME:-skeleton-db}
    restart: unless-stopped
    environment:
      POSTGRES_DB: ${DB_DATABASE:-skeleton_laravel}
      POSTGRES_USER: ${DB_USERNAME:-postgres}
      POSTGRES_PASSWORD: ${DB_PASSWORD:-secret}
    volumes:
      - db-data:/var/lib/postgresql/data
    ports:
      - "${DB_PORT:-5432}:5432"
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U ${DB_USERNAME:-postgres}"]
      interval: 5s
      timeout: 5s
      retries: 5
    networks:
      - skeleton-network

volumes:
  db-data:
    driver: local

networks:
  skeleton-network:
    driver: bridge
```

---

## Paso 18.3 — Archivos de configuración Docker

### Nginx para Docker

Archivo: `docker/nginx/default.conf`

```nginx
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    location ~* \.(jpg|jpeg|gif|png|css|js|ico|svg|woff|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml text/javascript;
}
```

### PHP config

Archivo: `docker/php/php.ini`

```ini
; Configuración PHP para producción
upload_max_filesize = 20M
post_max_size = 25M
memory_limit = 256M
max_execution_time = 60

; OPcache
opcache.enable = 1
opcache.memory_consumption = 128
opcache.max_accelerated_files = 10000
opcache.validate_timestamps = 0

; Zona horaria
date.timezone = Europe/Madrid
```

---

## Paso 18.4 — `.dockerignore`

Archivo: `laravel_project/.dockerignore`

```
.git
.gitignore
.env
.env.*
!.env.example
node_modules
vendor
tests
docs
storage/logs/*
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
storage/debugbar/*
.idea
.vscode
*.md
!README.md
docker-compose.yml
```

---

## Paso 18.5 — Variables de entorno para despliegue

El `docker-compose.yml` usa variables de entorno que facilitan la configuración para CI/CD:

| Variable | Default | Descripción |
|----------|---------|-------------|
| `APP_CONTAINER_NAME` | skeleton-app | Nombre del contenedor de la app |
| `NGINX_CONTAINER_NAME` | skeleton-nginx | Nombre del contenedor Nginx |
| `DB_CONTAINER_NAME` | skeleton-db | Nombre del contenedor de BD |
| `NGINX_PORT` | 80 | Puerto expuesto de Nginx |
| `DB_PORT` | 5432 | Puerto expuesto de PostgreSQL |
| `DB_DATABASE` | skeleton_laravel | Nombre de la base de datos |
| `DB_USERNAME` | postgres | Usuario de la BD |
| `DB_PASSWORD` | secret | Contraseña de la BD |
| `STORAGE_PATH` | ./storage | Ruta del storage montado |
| `APP_URL` | http://localhost | URL de la aplicación |
| `CACHE_DRIVER` | file | Driver de caché |
| `QUEUE_CONNECTION` | sync | Driver de colas |

---

## Paso 18.6 — Ejecutar y verificar

```bash
# Construir y levantar
docker compose up -d --build

# Ejecutar migraciones y seeders dentro del contenedor
docker compose exec app php artisan migrate --seed --force

# Generar key
docker compose exec app php artisan key:generate

# Verificar
docker compose exec app php artisan about
```

---

## Checklist de verificación

- [ ] `Dockerfile` multi-stage: node builder, composer builder, PHP-FPM final
- [ ] `docker-compose.yml` con servicios: app (PHP-FPM), nginx, db (PostgreSQL)
- [ ] Storage montado como volumen externo
- [ ] Datos de PostgreSQL en volumen persistente
- [ ] `docker/nginx/default.conf` creado
- [ ] `docker/php/php.ini` con configuración de producción
- [ ] `.dockerignore` creado
- [ ] Variables de entorno configurables para CI/CD
- [ ] `docker compose up -d --build` funciona sin errores
- [ ] Migraciones y seeders ejecutados correctamente en contenedor
- [ ] Aplicación accesible en http://localhost
