# Stage 1: Build PHP dependencies (for vendor files)

FROM php:8.4-alpine AS composer_stage
WORKDIR /app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pcntl bcmath gd intl pdo_mysql zip opcache redis exif

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Stage 2: Build frontend assets

FROM node:22-alpine AS frontend_builder
WORKDIR /app

COPY package*.json vite.config.js ./
RUN npm ci --no-audit --no-fund

COPY resources/ ./resources/
COPY app/ ./app/
COPY --from=composer_stage /app/vendor ./vendor

RUN npm run build


# Stage 3: Production image with FrankenPHP

FROM dunglas/frankenphp:1.4-php8.4-alpine AS production

ENV OS_LOCAL=linux
ENV PHP_INI_DIR=/usr/local/etc/php
ENV FRANKENPHP_CONFIG="worker ./public/index.php"

RUN apk add --no-cache curl

RUN install-php-extensions \
    pcntl \
    bcmath \
    gd \
    intl \
    pdo_mysql \
    zip \
    opcache \
    redis \
    exif

COPY docker/php/php-prod.ini $PHP_INI_DIR/conf.d/99-production.ini
WORKDIR /var/www
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/logs \
    bootstrap/cache

COPY --from=composer_stage /app/vendor ./vendor

COPY . .

COPY --from=frontend_builder /app/public/build ./public/build

# COPY docker/frankenphp/Caddyfile /etc/frankenphp/Caddyfile

RUN if [ ! -f public/frankenphp-worker.php ]; then \
    php artisan octane:install --server=frankenphp --force; \
    fi

RUN php artisan storage:link \
    && php artisan view:cache \
    && php artisan filament:cache-components \
    && (php artisan icons:cache || true)

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public

RUN rm -rf \
    .git \
    .github \
    node_modules \
    tests \
    docker \
    .env.example \
    phpunit.xml \
    phpstan.neon \
    vite.config.js \
    package*.json \
    README.md \
    .editorconfig

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000", "--workers=4", "--max-requests=5000"]