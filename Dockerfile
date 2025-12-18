FROM php:8.3-cli

# Install PHP extensions required by Laravel (pdo_mysql, mbstring, zip, etc.)
RUN apt-get update \
	&& apt-get install -y \
		git \
		unzip \
		libzip-dev \
		libonig-dev \
	&& docker-php-ext-install pdo_mysql mbstring zip \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

# Copy Composer from the official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies (Laravel), using app folder as source
COPY damas-tech-app/composer.json damas-tech-app/composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress || true

# Copy the rest of the application code
COPY damas-tech-app/. .

# Ensure storage and bootstrap/cache have proper permissions
RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 8000

# Default command:
# - runs migrations in force mode (useful for Railway)
# - starts the server on the PORT env var (Railway) or 8000 by default
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
