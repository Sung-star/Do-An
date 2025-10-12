#!/usr/bin/env bash
# Cài đặt dependency nếu chưa có
composer install --no-dev --optimize-autoloader
# Tạo cache Laravel
php artisan config:cache
php artisan route:clear
php artisan view:clear
# Chạy server Laravel
php artisan serve --host=0.0.0.0 --port=10000
