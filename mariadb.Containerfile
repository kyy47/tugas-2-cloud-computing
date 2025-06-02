
FROM docker.io/library/mariadb:latest


COPY ./sql/init.sql /docker-entrypoint-initdb.d/init.sql

