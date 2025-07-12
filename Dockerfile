FROM php:8.1-apache

RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy your full source code including vendor from local
COPY ./src/ ./
