#!/bin/sh

# Discover packages & upgrade filament components
php artisan package:discover --ansi
php artisan filament:upgrade

# Cache configurations for production speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations and seed automatically on startup
php artisan migrate --force
php artisan db:seed --force

# Fix permissions after caching
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start the Apache server
apache2-foreground
