#!/bin/bash
# Script de despliegue en producción para Skeleton Laravel Project
# Uso: bash docs/deploys/deploy.sh
# Requiere: git, composer, npm, php 8.4

set -e

echo "=== Iniciando despliegue ==="

# 1. Activar modo mantenimiento
php artisan down --retry=60

# 2. Actualizar código fuente
git pull origin main

# 3. Instalar dependencias PHP (sin dev)
composer install --no-dev --optimize-autoloader

# 4. Instalar dependencias JS y compilar assets
npm ci
npm run build

# 5. Ejecutar migraciones pendientes
php artisan migrate --force

# 6. Limpiar y regenerar cachés
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

# 7. Regenerar sitemap
php artisan sitemap:generate

# 8. Reiniciar worker de colas (si se usa)
# php artisan queue:restart

# 9. Desactivar modo mantenimiento
php artisan up

echo "=== Despliegue completado ==="
