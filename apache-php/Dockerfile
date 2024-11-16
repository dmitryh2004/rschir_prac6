FROM php:8.0-apache
WORKDIR /var/www/html/
RUN docker-php-ext-install mysqli && a2enmod authn_dbd && apt-get update && apt-get install -y libaprutil1-dbd-mysql && pecl install redis && docker-php-ext-enable redis
RUN apt-get install -y git
RUN apt-get install -y zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/
RUN composer require fzaninotto/faker
RUN composer require szymach/c-pchart
RUN composer require ajaxray/php-watermark