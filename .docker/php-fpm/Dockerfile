FROM php:7.4-fpm

WORKDIR /var/www

# Install PHP extensions.
RUN docker-php-ext-install \
        opcache

# Add base production PHP configuration file.
COPY ./.docker/php-fpm/php.ini /usr/local/etc/php

# Add PHP-FPM pool configuration.
COPY ./.docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy source into container.
COPY public /var/www/public
