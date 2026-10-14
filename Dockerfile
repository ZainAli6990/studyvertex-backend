FROM php:8.3-cli

# Laravel's required PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libsqlite3-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite zip bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chmod -R 775 storage bootstrap/cache \
    && mkdir -p database && touch database/database.sqlite

# Render sets $PORT at runtime; Laravel's built-in server serves the app.
CMD php artisan config:cache && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
