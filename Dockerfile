FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite module if needed
RUN a2enmod rewrite