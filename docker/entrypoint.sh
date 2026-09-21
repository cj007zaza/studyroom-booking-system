#!/bin/sh
set -e

# Run migrations and seed database automatically if DB_HOST is set
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database connection..."
    php artisan migrate --force --seed || true
fi

# Optimize Laravel for production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx web server..."
exec nginx -g "daemon off;"
