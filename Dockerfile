# Use official PHP image with Apache
FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy project files to Apache document root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Set recommended PHP.ini settings
COPY --from=php:8.2-apache /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80 