# Use official PHP with Apache
FROM php:8.4.1-apache

# Install system dependencies, Node.js & npm
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libzip-dev sqlite3 libsqlite3-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring zip exif pcntl bcmath gd opcache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot to /var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copy app files
COPY . /var/www/html

# Set working dir
WORKDIR /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Run composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Install npm dependencies & build frontend assets
RUN npm install && npm run build

# Cache configs and routes
RUN php artisan config:cache && php artisan route:cache

# Create storage link
RUN php artisan storage:link || true

# Copy opcache config
COPY docker/php.ini /usr/local/etc/php/conf.d/opcache.ini

# Expose port
EXPOSE 80
