FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev libpng-dev libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/src

COPY ./src .

RUN chown -R www-data:www-data /var/www/src/storage /var/www/src/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]