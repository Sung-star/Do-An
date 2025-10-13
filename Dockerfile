# Dockerfile - Build Laravel app for Railway
FROM php:8.3-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js (v18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy project files
WORKDIR /var/www/html
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader && npm install && npm run build

# Set permissions for Laravel
RUN chmod -R 777 storage bootstrap/cache

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
COPY ./docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 8080

# Start Apache
CMD ["apache2-foreground"]
