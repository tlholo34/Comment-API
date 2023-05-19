FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application files to the container
COPY . .

# Install any necessary dependencies
# For example, installing PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && composer install --no-scripts --no-autoloader --prefer-dist
# Set up Apache configuration if needed
# For example, enabling mod_rewrite for Laravel's routing
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN php artisan key:generate

RUN composer dump-autoload \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose the necessary port for your application
EXPOSE 80

# Specify the command to run when the container starts
# For example, starting the Apache web server
CMD ["apache2-foreground"]
