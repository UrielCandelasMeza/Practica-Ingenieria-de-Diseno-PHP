FROM postgres:15

ENV POSTGRES_USER=root
ENV POSTGRES_PASSWORD=password
ENV POSTGRES_DB=app_db

COPY init.sql /docker-entrypoint-initdb.d/