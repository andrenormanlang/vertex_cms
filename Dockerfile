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

# Install PHP extensions necessary for Laravel
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# Clear apt cache to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application source code to the container's working directory
COPY . /var/www

# Ensure correct ownership for Laravel files
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 755 /var/www/public

# Remove default Nginx configuration to prevent conflicts
RUN rm /etc/nginx/conf.d/default.conf

# Copy custom Nginx and Supervisor configurations into the container
COPY ./docker-compose/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker-compose/supervisord/supervisord.conf /etc/supervisord.conf

# Expose port 80 for Nginx (web server)
EXPOSE 80

# Start Supervisor to manage both Nginx and PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
