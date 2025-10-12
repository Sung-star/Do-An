#!/usr/bin/env bash
set -e

echo "🚀 Bắt đầu deploy Laravel trên Railway..."

# Nếu chưa có .env, tạo mới từ .env.example
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Cài các thư viện PHP
composer install --no-dev --optimize-autoloader

# Dọn cache cũ
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 🟢 Load lại biến môi trường và cache cấu hình
php artisan config:cache

# 🟢 Chạy migrate để đảm bảo DB hoạt động (bạn có thể bỏ nếu sợ)
php artisan migrate --force || true

# Chạy server
php artisan serve --host=0.0.0.0 --port=$PORT
