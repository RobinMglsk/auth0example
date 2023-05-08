FROM php:8.1.18-apache

RUN apt-get update; \
    apt-get install -y git zip unzip libpq-dev libzip-dev; \
    a2enmod rewrite;

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf; \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY src /var/www/html
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80