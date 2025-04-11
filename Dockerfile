FROM php:8.3-fpm-alpine

# Instala extensões e dependências
RUN apk update && apk add --no-cache \
    libpq-dev \
    unzip \
    curl \
    bash \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos da aplicação (serão sobrescritos pelo volume, mas serve pro build)
COPY . .

# Script de inicialização
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Permissões de cache
RUN mkdir -p storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

CMD ["/entrypoint.sh"]