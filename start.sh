#!/usr/bin/env bash
set -e

echo "🚀 Bắt đầu deploy Laravel trên Railway..."

# Nếu chưa có .env, tạo mới từ .env.example
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Cài các thư viện PHP
composer install --no-dev --optimize-autoloader


# Dọn sạch cache (quan trọng)
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build lại cache config mới sau khi Railway inject env
php artisan config:cache

# Chạy Laravel server
php artisan serve --host=0.0.0.0 --port=$PORT
