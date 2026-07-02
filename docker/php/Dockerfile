FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Script to ensure composer dependencies are installed on container startup
ENTRYPOINT ["sh", "-c", "composer install --no-interaction --optimize-autoloader && php-fpm"]
