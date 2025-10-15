CMD ["sh", "start.sh"]

# PHP với FPM
FROM php:8.2-fpm

# Cài đặt các package cần thiết
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Sao chép project
WORKDIR /var/www/html
COPY . .

# Cài composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Cài các thư viện PHP
RUN composer install --no-dev --optimize-autoloader

# Phân quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Tạo storage symlink
RUN php artisan storage:link || true

# Cổng web
EXPOSE 8000

# ✅ Khởi chạy Laravel + migrate + seed tự động
CMD php artisan migrate --force && \
    php artisan db:seed --class=ReviewSeeder --force && \
    php artisan serve --host=0.0.0.0 --port=8000
