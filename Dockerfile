# Use the official PHP image as a base image
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies including Nginx and Supervisor
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application source code
COPY . /var/www

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy Nginx and Supervisor configurations into the container
COPY ./docker-compose/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker-compose/supervisord/supervisord.conf /etc/supervisord.conf

# Expose port for Nginx (web server)
EXPOSE 8080

# Start Supervisor to run both Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
