# php-apache.Containerfile

# Gunakan base image php dengan apache
# Anda bisa memilih versi PHP yang spesifik jika diperlukan, misal: php:8.0-apache
FROM php:apache

# Install mysqli extension
# RUN docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
#    && docker-php-ext-install mysqli \
#    && docker-php-ext-enable mysqli
# Cara yang lebih umum dan sering berhasil untuk PHP image resmi:
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install nano text editor
# Pertama update package list, lalu install nano
RUN apt-get update && apt-get install -y \
    nano \
    && rm -rf /var/lib/apt/lists/*

# (Opsional) Anda bisa menyalin file konfigurasi PHP kustom jika ada
# COPY custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# (Opsional) Setel working directory jika diperlukan,
# tapi untuk php:apache, DocumentRoot defaultnya adalah /var/www/html
# WORKDIR /var/www/html

# Port yang diekspos oleh Apache adalah 80 (default)
EXPOSE 80

# Perintah default sudah diatur oleh base image php:apache untuk menjalankan Apache.
# CMD ["apache2-foreground"]
