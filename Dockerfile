FROM php:8.2-fpm-alpine

# Install system dependencies & Nginx
RUN apk add --no-cache \
    nginx \
    curl \
    ca-certificates \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    postgresql-dev

# Install PHP extensions for Laravel, MySQL, PostgreSQL & OPcache
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip opcache

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Configure PHP upload limits (20MB) & OPcache for high performance
RUN echo "upload_max_filesize = 20M" > /usr/local/etc/php/conf.d/custom.ini && \
    echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.enable = 1" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.enable_cli = 1" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.memory_consumption = 128" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.interned_strings_buffer = 8" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.max_accelerated_files = 10000" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.revalidate_freq = 0" >> /usr/local/etc/php/conf.d/custom.ini && \
    echo "opcache.validate_timestamps = 0" >> /usr/local/etc/php/conf.d/custom.ini

# Set permissions for storage, cache, and public upload directories
RUN mkdir -p /var/www/public/images/rooms && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
