FROM php:8.1-apache

RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install Ratchet (WebSocket lib)
RUN composer require cboden/ratchet

