FROM composer:1.9.0 AS composer
FROM php:7.3-fpm



RUN apt-get update && \
    apt-get install -y \
    git \
    zlib1g-dev \
    libzip-dev \
    libpq-dev

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install zip

WORKDIR /app
