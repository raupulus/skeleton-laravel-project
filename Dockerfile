# Imagen base de PHP 8.4 con FPM para desarrollo y producción
FROM php:8.4-fpm-alpine

# Instalar dependencias del sistema, Node.js/pnpm y extensiones PHP requeridas por Laravel
RUN apk add --no-cache \
        bash \
        curl \
        git \
        icu-dev \
        libpng-dev \
        libxml2-dev \
        nodejs \
        npm \
        oniguruma-dev \
        postgresql-dev \
        unzip \
        zip \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-install \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo \
        pdo_pgsql \
        xml \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && npm install -g pnpm

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuración de PHP para producción
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto (excluyendo lo del .dockerignore)
COPY . .

# Instalar dependencias PHP y compilar assets frontend con pnpm
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && pnpm install --frozen-lockfile \
    && pnpm run build

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
