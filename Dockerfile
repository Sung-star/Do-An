# ---------- BƯỚC 1: Build Laravel ----------
FROM composer:2 AS build

WORKDIR /app
COPY . /app

# Cài các thư viện PHP cần thiết
RUN composer install --no-dev --optimize-autoloader

# ---------- BƯỚC 2: Tạo image chạy ứng dụng ----------
FROM php:8.2-apache

# Cài các extension cần thiết cho Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copy mã Laravel từ image build
COPY --from=build /app /var/www/html

# Thiết lập quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy file cấu hình Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Bật rewrite module cho Laravel route
RUN a2enmod rewrite

EXPOSE 8080

CMD ["apache2-foreground"]
