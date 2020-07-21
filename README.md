## Plantilla de Aplicación para Laravel

Creado por Raúl Caro Pastorino

## Obtener aplicación

```bash
git clone https://gitlab.com/fryntiz/laravel-skeleton.git laravel-skeleton
cd /var/www/public/nombredominio
```

- Editar .env
- Crear Base de datos (postgresql)

## Crear usuario postgresql

En caso de no tener usuario postgresql crear así con tu usuaio:

```bash
sudo -u postgres createuser -P user_name
sudo -u postgres createdb fryntiz -O user_name
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE db_name to user_name"
```

## Crear Base de datos

Ahora crea la base de datos para este proyecto

```bash
sudo -u postgres createdb -O user_name -T template1 db_name
```

## Añadir variables de entorno

```bash
cp .env.example.production .env
nano .env
```

## Instalar dependencias nodejs

```bash
npm install --production
```

## Instalar dependencias php composer

```bash
composer install --no-dev
```

## Ejecutar migraciones

```bash
php artisan migrate
```

## Ejecutar Seeders

```bash
php artisan db:seed
```

## Generar claves para acceso por API

```bash
php artisan key:generate
```

## Crear enlace simbólico para el storage

```bash
#ln -s $PWD/storage/app/public $PWD/public/storage
php artisan storage:link
```

## Generar assets transpilados con npm

```bash
npm run prod
```

## Preparar apache

```bash
sudo chown -R www-data:www-data /var/www/public/nombredominio
sudo find /var/www/public/nombredominio/ -type f -exec chmod 644 {} \;
sudo find /var/www/public/nombredominio/ -type d -exec chmod 775 {} \;

sudo mkdir /var/log/apache2/nombredominio
sudo cp /var/www/public/api-fryntiz/nombredominio.conf /etc/apache2/sites-available/
sudo a2ensite nombredominio.conf

echo '127.0.0.1       nombredominio' | sudo tee -a /etc/hosts
echo '127.0.0.1       www.nombredominio' | sudo tee -a /etc/hosts

sudo systemctl reload apache2
```

## Instalar certificado

```bash
sudo certbot --authenticator webroot --installer apache \
    -w /var/www/public/nombredominio/public \
    -d www.nombredominio -d nombredominio

sudo certbot certonly --webroot -w /var/www/public/nombredominio/public \
    -d www.nombredominio -d nombredominio
```
