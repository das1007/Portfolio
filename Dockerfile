FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev ca-certificates libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache

RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

CMD php -S 0.0.0.0:$PORT -t public
