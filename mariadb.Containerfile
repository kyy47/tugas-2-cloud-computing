# Gunakan image mariadb resmi sebagai base
FROM mariadb:latest

# Salin file SQL untuk inisialisasi database dan tabel
# Pastikan file init.sql berada di direktori yang sama dengan Containerfile ini,
# atau sesuaikan path sumbernya.
COPY init.sql /docker-entrypoint-initdb.d/