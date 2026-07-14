# Use official PHP with Apache
FROM php:8.2-apache

# Install required extensions
RUN apt-get update \
    && apt-get install -y libzip-dev zip unzip \
    && docker-php-ext-install mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copy app
COPY . /var/www/html
WORKDIR /var/www/html

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
