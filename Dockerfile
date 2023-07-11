FROM php:8.1-apache

# Install necessary extensions
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Copy your PHP application code
COPY src/ /var/www/html/

# Set the Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Enable Apache rewrite module
RUN a2enmod rewrite

# Restart Apache
RUN service apache2 restart
