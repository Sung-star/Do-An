#!/usr/bin/env bash
set -e

echo "🚀 Bắt đầu deploy Laravel trên Railway..."

# Nếu chưa có .env, tạo mới từ .env.example
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Cài các thư viện PHP
composer install --no-dev --optimize-autoloader

# Dọn cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build cache config mới
php artisan config:cache

# Chạy Laravel server (Railway sẽ tự gán biến $PORT)
php artisan serve --host=0.0.0.0 --port=$PORT
