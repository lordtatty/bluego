## The base image with all shared components by each build stage
##
FROM php:7.0-apache AS base

COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

COPY ./src /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80