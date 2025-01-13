FROM php:8.1-apache

# Default workdir
WORKDIR /var/www/html

# Copy mantis scripts
COPY mantis /var/www/html

# Change file permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Enable mod rewrite
RUN a2enmod rewrite

# Increase file upload size to 20M
RUN echo "upload_max_filesize = 20M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/uploads.ini

# Install extensions
RUN set -xe \
    && apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev libpq-dev libxml2-dev libldap-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd mysqli pgsql soap ldap \
    && rm -rf /var/lib/apt/lists/*

# Expose port 80 for the traffic
EXPOSE 80

# Use the default Apache startup command
CMD ["apache2-foreground"]