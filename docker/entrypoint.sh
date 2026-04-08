#!/bin/bash
set -e

echo "========================================"
echo "  Lembah Entry VMS — Docker Entrypoint  "
echo "========================================"

# Create .env from example if it doesn't exist
if [ ! -f /var/www/html/.env ]; then
    echo ">>> Creating .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Generate app key if not set
if grep -q "APP_KEY=$" /var/www/html/.env || grep -q "APP_KEY=base64:$" /var/www/html/.env; then
    echo ">>> Generating application key..."
    php artisan key:generate --force
fi

# Wait for MySQL to be ready
echo ">>> Waiting for MySQL..."
max_tries=30
counter=0
until mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent 2>/dev/null; do
    counter=$((counter + 1))
    if [ $counter -gt $max_tries ]; then
        echo ">>> ERROR: MySQL did not become ready in time!"
        break
    fi
    echo ">>> MySQL not ready yet... retrying ($counter/$max_tries)"
    sleep 2
done

echo ">>> Running migrations..."
php artisan migrate --force

echo ">>> Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Setting file permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Create supervisor log directory
mkdir -p /var/log/supervisor

echo "========================================"
echo "  System Online — Launching Services    "
echo "========================================"

exec "$@"
