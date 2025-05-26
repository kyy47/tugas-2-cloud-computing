# mariadb.Containerfile

# Gunakan base image mariadb
# Anda bisa memilih versi MariaDB yang spesifik, misal: mariadb:10.5
FROM mariadb:latest

# Salin file *.sql ke direktori inisialisasi database MariaDB
# File SQL di direktori /docker-entrypoint-initdb.d/ akan dieksekusi secara otomatis
# saat container pertama kali dijalankan dan database belum ada/kosong.
# Pastikan path ke init.sql sesuai dengan struktur direktori Anda.
# Jika init.sql ada di direktori yang sama dengan mariadb.Containerfile:
COPY ./sql/init.sql /docker-entrypoint-initdb.d/init.sql

# (Opsional) Anda bisa menyalin file konfigurasi MariaDB kustom jika ada
# COPY custom-my.cnf /etc/mysql/conf.d/custom-my.cnf

# Port default MariaDB adalah 3306
EXPOSE 3306
