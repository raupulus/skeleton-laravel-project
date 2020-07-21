## Plantilla de Aplicación para Laravel

Creado por Raúl Caro Pastorino

## Instalación

git clone https://gitlab.com/fryntiz/laravel-skeleton.git laravel-skeleton

- Editar .env
- Crear Base de datos (postgresql)

cd /var/www/public/nombredominio
sudo -u postgres createdb -O web -T template1 nombreapp
cp .env.example.production .env
nano .env

composer install --no-dev
php artisan migrate
php artisan db:seed
php artisan key:generate

#ln -s $PWD/storage/app/public $PWD/public/storage
php artisan storage:link

npm install --production

sudo chown -R www-data:www-data /var/www/web/nombredominio
sudo find /var/www/web/nombredominio/ -type f -exec chmod 644 {} \;
sudo find /var/www/web/nombredominio/ -type d -exec chmod 775 {} \;

sudo mkdir /var/log/apache2/nombredominio
sudo cp /var/www/web/api-fryntiz/nombredominio.conf /etc/apache2/sites-available/
sudo a2ensite nombredominio.conf

echo '127.0.0.1       nombredominio' | sudo tee -a /etc/hosts
echo '127.0.0.1       www.nombredominio' | sudo tee -a /etc/hosts

sudo systemctl reload apache2

sudo certbot --authenticator webroot --installer apache \
    -w /var/www/web/nombredominio/public \
    -d www.nombredominio -d nombredominio

sudo certbot certonly --webroot -w /var/www/web/nombredominio/public \
    -d www.nombredominio -d nombredominio
