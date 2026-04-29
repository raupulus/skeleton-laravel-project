# Fase 15 — Acciones adicionales

## Resumen
En esta fase se crearán archivos de entorno, se configurarán .gitignore y .aiignore, se crearán configuraciones de servidores web y se inicializará el repositorio Git.

**Dependencias**: Fases 01-14 completadas.

---

## Paso 15.1 — Archivos de entorno

### `.env.example` (desarrollo)

Archivo: `laravel_project/.env.example`

```env
APP_NAME="Skeleton Laravel Project"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=skeleton_laravel
DB_USERNAME=postgres
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,localhost:8000
```

### `.env.example.production` (producción)

Archivo: `laravel_project/.env.example.production`

```env
APP_NAME="Skeleton Laravel Project"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://example.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=skeleton_laravel_prod
DB_USERNAME=app_user
DB_PASSWORD=CHANGE_ME_STRONG_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

SANCTUM_STATEFUL_DOMAINS=example.com
```

---

## Paso 15.2 — `.gitignore`

Archivo: `laravel_project/.gitignore`

```gitignore
# Laravel
/vendor
/node_modules
/public/build
/public/hot
/public/storage
/storage/*.key
/storage/app/public/*
!/storage/app/public/.gitkeep
.env
.env.backup
.env.production
.env.testing
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log

# IDE y editores
.idea/
.vscode/
*.swp
*.swo
*~
.DS_Store
Thumbs.db

# Documentación generada
/public/docs/api

# Logs
storage/logs/*.log

# Debugbar
storage/debugbar/

# Coverage
coverage/
.phpunit.result.cache

# Sitemap generado
/public/sitemap.xml
```

---

## Paso 15.3 — `.aiignore`

Archivo: `laravel_project/.aiignore`

```
# Archivos con información confidencial
.env
.env.*
!.env.example
!.env.example.production

# Credenciales
auth.json
storage/*.key

# Dependencias (demasiado grandes, no útiles para IA)
vendor/
node_modules/

# Logs y caché
storage/logs/
storage/framework/cache/
storage/framework/sessions/
storage/framework/views/
storage/debugbar/

# Build artifacts
public/build/
public/hot

# Base de datos
*.sql
*.sqlite
```

---

## Paso 15.4 — Configuraciones de servidor web

### Nginx

Archivo: `docs/deploys/nginx.conf`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name example.com www.example.com;
    root /var/www/laravel_project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Caché de assets estáticos
    location ~* \.(jpg|jpeg|gif|png|css|js|ico|xml|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Gzip
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
}
```

### Apache

Archivo: `docs/deploys/apache.conf`

```apache
<VirtualHost *:80>
    ServerName example.com
    ServerAlias www.example.com
    DocumentRoot /var/www/laravel_project/public

    <Directory /var/www/laravel_project/public>
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>

    # Headers de seguridad
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"

    ErrorLog ${APACHE_LOG_DIR}/laravel-error.log
    CustomLog ${APACHE_LOG_DIR}/laravel-access.log combined

    # Compresión
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/plain text/css application/json application/javascript text/xml application/xml text/javascript
    </IfModule>

    # Caché de assets
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType image/jpg "access plus 30 days"
        ExpiresByType image/jpeg "access plus 30 days"
        ExpiresByType image/gif "access plus 30 days"
        ExpiresByType image/png "access plus 30 days"
        ExpiresByType text/css "access plus 30 days"
        ExpiresByType application/javascript "access plus 30 days"
    </IfModule>
</VirtualHost>
```

---

## Paso 15.5 — Inicializar repositorio Git

```bash
cd laravel_project
git init
git add .
git commit -m "Initial Commit"
```

---

## Checklist de verificación

- [ ] `.env.example` creado con configuración para desarrollo (PostgreSQL, file drivers, mailpit)
- [ ] `.env.example.production` creado con configuración para producción (redis, SMTP real, debug off)
- [ ] `.gitignore` actualizado descartando IDEs, editores, logs, .env, vendor, node_modules
- [ ] `.aiignore` creado descartando credenciales, vendor, logs, caché
- [ ] `docs/deploys/nginx.conf` creado con configuración completa (gzip, caché, seguridad)
- [ ] `docs/deploys/apache.conf` creado con configuración completa
- [ ] Repositorio Git inicializado con commit "Initial Commit"
