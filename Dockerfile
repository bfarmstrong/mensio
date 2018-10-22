#
# Build step to install dependencies
#
FROM composer:1.7 as vendor

COPY database/ database/

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

#
# Build step to install frontend dependencies
#
FROM node:carbon as frontend

RUN mkdir -p /app/public
COPY package.json webpack.mix.js yarn.lock /app/
COPY resources/ /app/resources/

WORKDIR /app

RUN yarn install && yarn production

#
# Final build step to create the production image
#
FROM php:7.2-apache-stretch

# Install the missing extensions
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        curl \
        libfreetype6-dev \
        libjpeg-dev \
        libmcrypt-dev \
        libmemcached-dev \
        libpng-dev \
        libpq-dev \
        libssl-dev \
        libz-dev && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-configure gd \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# Configure Apache to work with Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Copy the source files over to the image
COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --chown=www-data:www-data --from=frontend /app/public/css/ /var/www/html/public/css/
COPY --chown=www-data:www-data --from=frontend /app/public/js/ /var/www/html/public/js/
COPY --chown=www-data:www-data --from=frontend /app/mix-manifest.json /var/www/html/mix-manifest.json
