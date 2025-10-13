# Dockerfile - build Laravel app on Railway
FROM php:8.3-apache

# Cài các extension cần thiết
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cài Node.js (v18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy toàn bộ project
WORKDIR /var/www/html
COPY . .

# Cài dependencies
RUN composer install --no-dev --optimize-autoloader && npm install && npm run build

# Cấp quyền cho Laravel
RUN chmod -R 777 storage bootstrap/cache

# Cấu hình Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
COPY ./docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
