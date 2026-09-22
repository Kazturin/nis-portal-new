# ==============================================================================
# Stage 1: Build PHP dependencies (for vendor files)
# ==============================================================================
FROM composer:2 AS composer_stage
WORKDIR /app

COPY composer.json composer.lock ./

RUN --mount=type=cache,target=/tmp/cache \
    composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# ==============================================================================
# Stage 2: Build frontend assets
# ==============================================================================
FROM node:22-alpine AS frontend_builder
WORKDIR /app

COPY package*.json vite.config.js ./
RUN --mount=type=cache,target=/root/.npm \
    npm ci --no-audit --no-fund

COPY resources/ ./resources/
COPY app/ ./app/
COPY --from=composer_stage /app/vendor ./vendor

RUN npm run build

# ==============================================================================
# Stage 3: Production image with FrankenPHP
# ==============================================================================
FROM dunglas/frankenphp:1.4-php8.4-alpine AS production

ENV OS_LOCAL=linux \
    PHP_INI_DIR=/usr/local/etc/php

# Install system dependencies and PHP extensions (cached in early layer)
RUN apk add --no-cache curl \
    && install-php-extensions \
        pcntl \
        bcmath \
        gd \
        intl \
        pdo_mysql \
        zip \
        opcache \
        redis \
        exif

# Copy Composer binary from composer_stage
COPY --from=composer_stage /usr/bin/composer /usr/bin/composer

# Copy configuration files
COPY docker/php/php-prod.ini $PHP_INI_DIR/conf.d/99-production.ini
COPY docker/frankenphp/Caddyfile /etc/frankenphp/Caddyfile

WORKDIR /var/www

# Prepare directory structure with proper permissions
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 1. Copy application source code (ignoring dev/test files via .dockerignore)
COPY --chown=www-data:www-data . .

# 2. Copy production vendor dependencies from composer_stage
COPY --chown=www-data:www-data --from=composer_stage /app/vendor ./vendor

# 3. Copy compiled frontend assets from frontend_builder
COPY --chown=www-data:www-data --from=frontend_builder /app/public/build ./public/build

# Optimize autoloader with application classes
RUN composer dump-autoload --optimize --no-dev

# Setup Octane / FrankenPHP worker script if not present
RUN if [ ! -f public/frankenphp-worker.php ]; then \
    php artisan octane:install --server=frankenphp --force; \
    fi

# Generate Laravel optimizations
RUN php artisan storage:link \
    && php artisan view:cache \
    && php artisan filament:cache-components \
    && (php artisan icons:cache || true)

# Finalize permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80 443 8000

ENTRYPOINT ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile", "--adapter", "caddyfile"]