FROM php:8.1-apache

# Cài đặt các extension cần thiết (nếu có)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Bật rewrite module
RUN a2enmod rewrite

# Copy source vào container
COPY . /var/www/html/

# Set thư mục làm việc là public
WORKDIR /var/www/html/public

# Cấu hình Apache để trỏ tới thư mục public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Cho phép Apache đọc lại .htaccess
RUN echo '<Directory /var/www/html/public>\n\tAllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf
