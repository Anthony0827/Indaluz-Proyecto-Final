#!/bin/bash
set -e
cd /var/www/html

echo "[entrypoint] Preparando aplicación Laravel..."

# Usar el .env de producción si no hay .env (el .env local se excluye del build)
if [ ! -f .env ] && [ -f .env.production ]; then
    cp .env.production .env
    echo "[entrypoint] .env.production -> .env"
fi

# Asegurar carpetas y permisos de storage
mkdir -p storage/framework/{sessions,views,cache,data} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Crear el fichero sqlite si la app usa sqlite y no existe
if grep -q "^DB_CONNECTION=sqlite" .env 2>/dev/null; then
    mkdir -p database
    [ -f database/database.sqlite ] || touch database/database.sqlite
    chown -R www-data:www-data database
fi

# Enlace simbólico de storage (imágenes subidas) — ignora si ya existe
php artisan storage:link 2>/dev/null || true

# Regenerar caches con la configuración actual del contenedor
php artisan config:clear || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Inicialización de datos (solo apps con AUTO_MIGRATE=1). Se ejecuta en el
# primer arranque y tras recrear el contenedor (marcador en el fs efímero).
if [ "${AUTO_MIGRATE:-0}" = "1" ] && [ ! -f storage/.initialized ]; then
    echo "[entrypoint] Migrando y sembrando datos demo..."
    php artisan migrate --force --seed || true
    touch storage/.initialized
fi

echo "[entrypoint] Listo. Arrancando servicios..."
exec "$@"
