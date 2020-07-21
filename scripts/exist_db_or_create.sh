#!/usr/bin/env bash

## Este script prepara la base de datos
## Recibe como parámetros o deben estar seteados en el entorno:
## $1 DB_USERNAME
## $2 DB_PASSWORD

if [[ ! $DB_USERNAME ]]; then
    DB_USERNAME=${1}
fi

if [[ ! $DB_PASSWORD ]]; then
    DB_PASSWORD=${2}
fi

## Compruebo si existe la db, en ese caso devolverá "1"
db_exist=$(psql -U ${DB_USERNAME} -tAc "SELECT 1 FROM pg_database WHERE datname='laravel_skeleton'")

if [[ db_exist = '1' ]]; then
    echo 'Ya existe la base de datos, se aborta crearla'
else
    #@SET PGPASSWORD="${DB_PASSWORD}"
    #createdb -O "${DB_USERNAME}" -T template1 'laravel_skeleton'
    psql -c "CREATE DATABASE laravel_skeleton" "user=${DB_USERNAME} dbname=laravel_skeleton password=${DB_PASSWORD}"
fi
