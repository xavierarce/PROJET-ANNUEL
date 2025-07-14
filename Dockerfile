# Dockerfile
FROM php:8.2-apache

# Enable PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (to leverage Docker layer cache)
COPY ./src/composer.json ./src/composer.lock ./

# Run composer install
RUN composer install --no-dev --optimize-autoloader

# Then copy the rest of the app
COPY ./src /var/www/html

# Set Apache public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]
