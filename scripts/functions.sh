#!/usr/bin/env bash


##
## Comprueba si la línea recibida existe en el archivo o la crea
##
replace_or_add_line_in_file() {
    local FILE="${1}"
    local LINE="${2}"

    echo "La línea recibida es: ${LINE}"
}

##
## Comprueba si existe una variable=valor en un archivo o la añade.
## La comprobación se hace: Comienza por el nombre de la variable hasta
## encontrar un "=", por ejemplo "mi_variable="
##
replace_or_add_var_in_file() {
    local FILE="${1}"
    local VAR="${2}"
    local VALUE="${3}"

    echo "La variable recibida es: ${VAR}"
    echo "El valor recibido es: ${VALUE}"
}
