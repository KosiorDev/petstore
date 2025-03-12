# Use an official PHP image with FPM and necessary extensions
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    git \
    unzip \
    curl \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql zip exif pcntl \
    && docker-php-source delete

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Copy custom php.ini
#COPY php.ini /usr/local/etc/php/php.ini

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]
