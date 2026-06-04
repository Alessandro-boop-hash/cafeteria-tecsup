FROM php:8.3-apache

RUN apt-get update && apt-get install -y zip unzip sqlite3 libsqlite3-dev
RUN docker-php-ext-install pdo pdo_sqlite

RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader

# 1. Migramos y sembramos (sin borrar la base de datos que ya copiaste)
RUN php artisan migrate --force
RUN php artisan db:seed --force
RUN php artisan storage:link

# 2. AL FINAL damos los permisos para que Laravel pueda escribir
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database /var/www/html/database/database.sqlite
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database /var/www/html/database/database.sqlite

EXPOSE 80