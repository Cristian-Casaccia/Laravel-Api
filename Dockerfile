FROM php:8.2-apache

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        git \
        gnupg2 \
        curl \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libxml2-dev \
        unzip

# Enable mod_rewrite and other Apache modules
RUN a2enmod rewrite headers

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo_mysql zip

# # Install PhpMyAdmin
# RUN curl -sSL https://www.phpmyadmin.net/downloads/phpMyAdmin-latest-all-languages.tar.gz | tar xvz -C /var/www/html --strip-components=1

# # Copy the custom phpMyAdmin configuration file
# COPY config.inc.php /var/www/html/config.inc.php

# Set Apache DocumentRoot for Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache configuration to use the correct DocumentRoot
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set the ServerName directive to avoid warning messages
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy application code to the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install Composer (using the official script and bypassing GPG check)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies with Composer
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 to access the application
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
