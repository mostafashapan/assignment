FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

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

# Copy SQL initialization script and init-db.php
COPY products.sql /var/www/html/
COPY init-db.php /var/www/html/

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set the permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/public

# Expose port 80
EXPOSE 80

# Start Apache server with entrypoint script
ENTRYPOINT ["entrypoint.sh"]
