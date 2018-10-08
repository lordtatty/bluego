## The base image with all shared components by each build stage
##
FROM ubuntu:18.04

RUN apt-get update
RUN apt-get install -y curl
#RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs
RUN apt-get install -y npm

RUN npm install -g @vue/cli

COPY ./src /var/www/html/
WORKDIR /var/www/html/
EXPOSE 80

CMD npm run serve

