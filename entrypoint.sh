#!/bin/sh

cd /var/www/html

# Verifica se a pasta vendor existe
if [ ! -d "vendor" ]; then
    echo "Instalando dependências com Composer..."
    composer install --no-dev --optimize-autoloader
fi

# Garante permissões corretas para Laravel
chown -R www-data:www-data storage bootstrap/cache

# Sobe o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000