# Gunakan image php-apache resmi sebagai base
FROM php:apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install nano editor
RUN apt-get update && apt-get install -y nano

# (Opsional) Anda bisa menambahkan perintah COPY di sini jika file PHP
# ingin dimasukkan ke dalam image secara default,
# namun untuk tugas ini, file PHP akan di-mount melalui volume.
# COPY ./app/ /var/www/html/