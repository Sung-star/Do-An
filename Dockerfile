# 1️⃣ Sử dụng image PHP có Apache sẵn
FROM php:8.2-apache

# 2️⃣ Cài các extension Laravel cần
RUN docker-php-ext-install pdo pdo_mysql

# 3️⃣ Copy toàn bộ project vào container
COPY . /var/www/html

# 4️⃣ Trỏ DocumentRoot về thư mục public
WORKDIR /var/www/html

# 5️⃣ Cấu hình Apache trỏ đến public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 6️⃣ Mở rewrite để Laravel hoạt động (route)
RUN a2enmod rewrite
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>" >> /etc/apache2/apache2.conf

# 7️⃣ Cổng Render sử dụng
EXPOSE 80
CMD ["apache2-foreground"]
