# syntax=docker/dockerfile:1

# =========================================================
# 1. Shared PHP base
# =========================================================
FROM php:8.4-fpm-bookworm AS php-base

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        gosu \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# =========================================================
# 2. Dev image (S088 — bind mounts, assets built separately)
# =========================================================
FROM php-base AS dev

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]

# =========================================================
# 3. Install PHP dependencies (production build)
# =========================================================
FROM php-base AS composer-build

ENV APP_ENV=production \
    APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --no-progress

COPY . .

RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --classmap-authoritative \
    && php artisan package:discover --ansi

# =========================================================
# 4. Build Vite / frontend assets
# =========================================================
FROM node:22-alpine AS frontend-build

WORKDIR /var/www/html

COPY --from=composer-build /var/www/html /var/www/html

RUN npm ci \
    && npm run build \
    && rm -rf node_modules

# =========================================================
# 5. Final PHP production image
# =========================================================
FROM php-base AS app-production

WORKDIR /var/www/html

COPY --from=composer-build /var/www/html /var/www/html
COPY --from=frontend-build /var/www/html/public/build /var/www/html/public/build

COPY docker/php/entrypoint.prod.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && ln -sfn \
        /var/www/html/storage/app/public \
        /var/www/html/public/storage \
    && chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]

# =========================================================
# 6. Final Docker Nginx image (production)
# =========================================================
FROM nginx:1.27-alpine AS nginx-production

COPY docker/nginx/default.prod.conf /etc/nginx/conf.d/default.conf
COPY --from=frontend-build /var/www/html/public /var/www/html/public
