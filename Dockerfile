# 1. Use PHP with Apache
FROM php:8.2-apache

# 2. Install Linux libraries
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# 3. Install PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Enable Apache Mod Rewrite
RUN a2enmod rewrite

# 5. Install Node.js & NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Set Working Directory
WORKDIR /var/www/html

# 8. Copy Project Files
COPY . .

# 9. Install Backend Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Install Frontend Dependencies & Build
RUN npm install
RUN npm run build

# 11. Set Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 12. Update Apache Config (CORRECTED PART)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 13. Expose Port 80
EXPOSE 80