FROM  php:7.1-fpm

LABEL maintainer="hudo.assenco@gmail.com"

RUN apt-get update && \
    apt-get install -y \
      git \
      unzip

RUN docker-php-ext-install pdo pdo_mysql

# Allow Composer to be run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /opt/apps/laravel
