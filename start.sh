#!/bin/bash

echo "🧹 Clearing old caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "🔗 Creating storage symlink..."
php artisan storage:link || true

echo "🧽 Fixing permissions..."
chmod -R 775 storage bootstrap/cache

echo "⚙️ Rebuilding caches..."
php artisan route:cache || true
php artisan config:cache || true
php artisan view:cache || true

# Xóa cache phân trang cũ
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/views/*

# Chờ DB Railway khởi động
echo "⏳ Waiting for database to be ready..."
sleep 10

# Chạy migrate + seed
php artisan migrate --force
php artisan db:seed --class=ProductsTableSeeder --force
php artisan db:seed --class=ReviewSeeder --force

echo "🚀 Starting Laravel app on Railway..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
