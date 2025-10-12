#!/usr/bin/env bash
set -e

echo "🚀 Bắt đầu deploy Laravel trên Railway..."

# Cài các thư viện PHP
composer install --no-dev --optimize-autoloader

# Tạo cache và migrate DB
php artisan key:generate --force
php artisan config:cache
php artisan route:clear
php artisan view:clear

# Nếu bạn có DB, hãy bật dòng này:
# php artisan migrate --force

# Chạy Laravel
php artisan serve --host=0.0.0.0 --port=$PORT
