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
php artisan event:cache || true

# Ensure public images directory and storage permissions
mkdir -p /var/www/public/images/rooms
chown -R www-data:www-data /var/www/public /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/public /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx web server..."
exec nginx -g "daemon off;"
