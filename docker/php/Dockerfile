FROM php:7.1.30-fpm-stretch

RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        zlib1g-dev \
        libxml2-dev

RUN docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    zip \
    bcmath
