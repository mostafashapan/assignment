# Use the official PHP image as the base
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/* # Clean up to reduce image size

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy custom Apache configuration file
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Copy the application code and Composer files
COPY public/ /var/www/html/public/
COPY src/ /var/www/html/src/
COPY composer.json /var/www/html/
COPY .env /var/www/html/

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy any remaining application code (excluding files already copied)
COPY . /var/www/html/

# Set the permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/public

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
