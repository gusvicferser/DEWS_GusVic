<?php

/**
 * Página para la función de conexión a la base de datos:
 * 
 * @author: Gustavo Víctor
 * @version: 1.0
 */

/**
 * Función para conectar con la base de datos:
 *
 * @author: Gustavo Víctor
 * @version: 1.0
 * 
 * @return: Mixed: 'PDO' (Un objeto Php Data Object) si lo consigue, 
 * o 'null' si no.
 */
function connectDB(): mixed
{

    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];
    try {
        return new PDO(
            'mysql:host=localhost;dbname=' . DB_NAME,
            DB_USERNAME,
            DB_PASSWORD,
            $options
        );
    } catch (Exception $exc) {
        return null;
    }
}
