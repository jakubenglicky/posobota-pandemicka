FROM php:7.4-apache

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis
