FROM php:8.2.0-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql \
&& docker-php-ext-configure pcntl --enable-pcntl \
&& docker-php-ext-install pcntl;
