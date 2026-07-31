#!/bin/sh
set -e

cd /var/www/html

if [ -f composer.json ] && [ ! -d vendor ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

if [ ! -L public/storage ]; then
    php artisan storage:link --no-interaction 2>/dev/null || true
fi

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

exec "$@"
