#!/bin/sh
set -e

# Configure port for Render ($PORT is provided by Render, default 10000)
RENDER_PORT="${PORT:-10000}"
echo "Configuring Nginx to listen on port ${RENDER_PORT}..."
sed -i "s/PORT_PLACEHOLDER/${RENDER_PORT}/g" /etc/nginx/http.d/default.conf

# SQLite Database handling
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    DB_DIR=$(dirname "$DB_PATH")

    if [ ! -d "$DB_DIR" ]; then
        echo "Creating database directory: $DB_DIR"
        mkdir -p "$DB_DIR"
    fi

    if [ ! -f "$DB_PATH" ]; then
        echo "Creating SQLite database file at: $DB_PATH"
        touch "$DB_PATH"
    fi

    chown -R www-data:www-data "$DB_DIR"
    chmod -R 775 "$DB_DIR"
    chmod 664 "$DB_PATH"
fi

# Ensure storage & bootstrap/cache permissions
echo "Setting permissions for storage and bootstrap/cache..."
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage symlink
php /var/www/html/artisan storage:link --force || true

# Run database migrations
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "Running database migrations..."
    php /var/www/html/artisan migrate --force || echo "Migration warning or skipped."
fi

# Cache config, routes, and views if in production
if [ "${APP_ENV:-production}" = "production" ]; then
    echo "Optimizing Laravel configuration and routes..."
    php /var/www/html/artisan config:cache || true
    php /var/www/html/artisan route:cache || true
    php /var/www/html/artisan view:cache || true
fi

echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
