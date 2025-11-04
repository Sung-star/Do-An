# ------------------------------
# ✅ PHP + Apache cho Laravel
# ------------------------------
FROM php:8.2-apache

# Cài extension cần thiết cho Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copy toàn bộ mã nguồn vào container
COPY . /var/www/html

# Đặt thư mục làm việc
WORKDIR /var/www/html

# Thay đổi DocumentRoot để Apache trỏ vào public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Bật module rewrite để Laravel hoạt động
RUN a2enmod rewrite

# Cho phép .htaccess override cấu hình
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" >> /etc/apache2/apache2.conf

# Phân quyền cho storage và cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Mở cổng 80 cho Render
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]
