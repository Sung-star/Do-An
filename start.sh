#!/bin/bash

echo "🧹 Clearing old caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "🔗 Creating storage symlink..."
php artisan storage:link || true

echo "⚙️ Rebuilding caches..."
php artisan route:cache || true
php artisan config:cache || true
php artisan view:cache || true
# Chạy migrate (nếu chưa có bảng)
php artisan migrate --force

# Chạy seed (nếu cần)
php artisan db:seed --class=ReviewSeeder --force
echo "🚀 Starting Laravel app on Railway..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
