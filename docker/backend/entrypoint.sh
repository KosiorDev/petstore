#!/bin/bash

# Check if storage and bootstrap/cache directories exist and set permissions
if [ ! -d "/var/www/html/storage" ]; then
    mkdir -p /var/www/html/storage
fi

if [ ! -d "/var/www/html/bootstrap/cache" ]; then
    mkdir -p /var/www/html/bootstrap/cache
fi

# Check if the permissions are already set correctly
CURRENT_USER=$(stat -c "%U" /var/www/html)
CURRENT_GROUP=$(stat -c "%G" /var/www/html)
if [ "$CURRENT_USER" != "www-data" ] || [ "$CURRENT_GROUP" != "www-data" ]; then
    chown -R www-data:www-data /var/www/html
fi

# Ensure the storage and bootstrap/cache directories have the correct permissions
STORAGE_PERMISSIONS=$(stat -c "%a" /var/www/html/storage)
CACHE_PERMISSIONS=$(stat -c "%a" /var/www/html/bootstrap/cache)
if [ "$STORAGE_PERMISSIONS" != "755" ]; then
    chmod -R 755 /var/www/html/storage
fi
if [ "$CACHE_PERMISSIONS" != "755" ]; then
    chmod -R 755 /var/www/html/bootstrap/cache
fi

# Check if vendor directory exists, if not, install Composer dependencies
if [ ! -d "/var/www/html/vendor" ]; then
    composer install --optimize-autoloader --no-dev
fi

# Run the main container command
exec "$@"
