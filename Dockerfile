FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy the application code to the container
COPY . /var/www

# Set the correct permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

#EXPOSE 9000
#
## Set the default command to run php-fpm as root
#CMD ["php-fpm"]
