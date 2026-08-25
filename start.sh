#!/bin/sh

# Cache configurations for production speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically on startup
php artisan migrate --force

# Start the Apache server
apache2-foreground
