#!/bin/bash

echo "🧹 Clearing old caches..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo "🔗 Creating storage symlink..."
php artisan storage:link

echo "⚙️ Rebuilding caches..."
php artisan route:cache
php artisan config:cache
php artisan view:cache

echo "🚀 Starting Laravel app with Apache..."
vendor/bin/heroku-php-apache2 public/
