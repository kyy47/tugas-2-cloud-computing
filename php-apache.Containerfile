FROM docker.io/library/php:8.3-rc-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN apt-get update && apt-get install -y nano
