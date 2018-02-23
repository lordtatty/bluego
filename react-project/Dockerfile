## The base image with all shared components by each build stage
##
FROM php:7.0-cli AS base

#COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

#RUN a2enmod proxy
#RUN a2enmod proxy_http
#RUN a2enmod proxy_balancer
#RUN a2enmod lbmethod_byrequests
#RUN service apache2 restart


## Install required dependencies
## But throw away image so we don't carry over build tools
##
FROM base AS dependencies_base

#RUN apt-get update
#RUN apt-get -y install git
#COPY src/composer.json /var/www/html/composer.json
#WORKDIR /var/www/html/

#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
#RUN php composer-setup.php
#RUN php -r "unlink('composer-setup.php');"
#RUN php composer.phar install --no-plugins --no-scripts


## Final Container
##
FROM base AS final

RUN mkdir vendor
COPY ./src /var/www/html
#COPY --from=dependencies_base /var/www/html/vendor ./vendor
WORKDIR /var/www/html/
CMD php run.php
EXPOSE 8080