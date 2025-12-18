FROM php:8.3-cli

# Instala extensões necessárias para Laravel (pdo_mysql, mbstring, etc.)
RUN apt-get update \
	&& apt-get install -y \
		git \
		unzip \
		libzip-dev \
		libonig-dev \
	&& docker-php-ext-install pdo_mysql mbstring zip \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

# Copia o Composer da imagem oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Instala dependências do PHP (Laravel)
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress || true

# Copia o restante da aplicação
COPY . .

# Garante que storage e bootstrap tenham permissões adequadas
RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 8000

# Comando padrão:
# - roda migrations em modo force (útil em Railway)
# - inicia o servidor na porta definida pela variável PORT (Railway) ou 8000 por padrão
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]

