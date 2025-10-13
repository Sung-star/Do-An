#!/bin/bash

echo "🧹 Clearing old caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan storage:link
echo "⚙️ Rebuilding caches..."
php artisan route:cache
php artisan config:cache

echo "🚀 Starting Laravel app..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
