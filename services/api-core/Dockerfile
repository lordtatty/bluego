## The base image with all shared components by each build stage
##
FROM php:7.0-apache AS base

RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/php.ini
RUN a2enmod rewrite

COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

COPY ./src /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80