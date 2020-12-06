FROM php:7.4.13-fpm

ENV DEBIAN_FRONTEND noninteractive

# install basic tools and php-related libraries
RUN apt-get update && apt-get install -y \
  gnupg2 \
  sudo \
  curl \
  unzip \
  git \
  gettext-base \
  libssl-dev \
  zlib1g-dev \
  libcurl4-gnutls-dev \
  libzip-dev \
  libpng-dev \
  libonig-dev \ 
  libpq-dev

# install & configure php extensions
RUN pecl install xdebug-2.9.8 \
  && docker-php-ext-enable xdebug \
  && docker-php-ext-install -j$(nproc) opcache zip curl pdo_mysql mbstring gd \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# configure php
ARG PHP_ENV=dev
ADD ./ /app
WORKDIR /app

COPY ./docker/src/php/$PHP_ENV/php.ini /usr/local/etc/php/php.ini
COPY ./docker/src/php/$PHP_ENV/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini
COPY ./docker/src/php/$PHP_ENV/xdebug2.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app

# build backend
RUN cp .env.example .env \
  && composer install \
  && php artisan key:generate \
  && chmod -c -R 777 storage \
  && chmod -R 777 bootstrap/cache \
  && php artisan optimize:clear
