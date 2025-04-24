# Dùng PHP image có Apache
FROM php:8.1-apache

# Copy toàn bộ code vào thư mục web
COPY . /var/www/html/

# Bật mod_rewrite nếu có routing
RUN a2enmod rewrite

# Thiết lập thư mục làm việc là public
WORKDIR /var/www/html/public/

# Mở cổng 80 để web hoạt động
EXPOSE 80
