# ─────────────────────────────────────────────────────────────────
# Imagen Laravel reutilizable (ERP e Indaluz)
# nginx + php-fpm + supervisor (scheduler + queue para el auto-reset demo)
# Build:  docker build -t laravel-demo --build-arg PHP_VERSION=8.3 .
# ─────────────────────────────────────────────────────────────────
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-fpm-bookworm

# Paquetes del sistema + extensiones PHP típicas de Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx supervisor git unzip libzip-dev libpng-dev libjpeg-dev \
        libfreetype6-dev libonig-dev libxml2-dev sqlite3 libsqlite3-dev \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo pdo_mysql pdo_sqlite mbstring zip exif pcntl bcmath gd intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiamos primero composer.* para cachear dependencias
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction || true

# Copiamos el resto del código
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && composer dump-autoload --optimize

# Permisos de storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Config de nginx, supervisor y arranque
COPY docker/nginx.conf     /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/app.conf
COPY docker/entrypoint.sh  /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/app.conf", "-n"]
