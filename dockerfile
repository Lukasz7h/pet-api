# Download PHP image from FPM
FROM php:8.3-fpm

# Installation of dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation of PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql zip

# Composer Installation
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.4.4 --install-dir=/usr/local/bin --filename=composer

# Choose work directory
WORKDIR /var/www

# Copy files into app
COPY . .

# Set a permissions
RUN chown -R www-data:www-data /var/www

# Swap user at www-data
USER www-data

# Installation of app dependencies
RUN composer install --no-dev --optimize-autoloader
RUN composer require guzzlehttp/guzzle:^7.0

# Restore root user privileges
USER root
RUN chmod -R 755 /var/www/storage

# Set a port
EXPOSE 8000

# Commend liable for launch app from image
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
