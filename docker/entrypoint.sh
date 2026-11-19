#!/bin/sh
set -e
cd /var/www/html

# Clave de la aplicación (solo si no existe)
if ! grep -q '^APP_KEY=base64' .env; then
    php artisan key:generate --force
fi

# Esperar a que MySQL acepte conexiones
echo "Esperando a MySQL en $DB_HOST:$DB_PORT..."
until mysqladmin ping -h"$DB_HOST" -P"$DB_PORT" -u"$DB_USERNAME" -p"$DB_PASSWORD" --skip-ssl --silent; do
    sleep 2
done

# Migraciones, enlace de storage y cachés
php artisan migrate --force
php artisan storage:link || true
php artisan optimize
chown -R www-data:www-data storage bootstrap/cache

exec "$@"
