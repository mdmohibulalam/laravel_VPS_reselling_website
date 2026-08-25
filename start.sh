#!/bin/sh

# Cache configurations for production speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically on startup
php artisan migrate --force

# Fix permissions after caching
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start the Apache server
apache2-foreground
