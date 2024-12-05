<?php

/**
 * Include para la conexión a la base de datos:
 * 
 * @author Gustavo Victor
 * @version 1.0
 */

/**
 * Función para la connexión a base de datos:
 * @author Gustavo Victor
 * @version 1.0
 */
function dbConnection(): mixed
{
    try {

        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $connection = new PDO('mysql:host=localhost;dbname=examanime', 'examen', 'nemaxe', $options);
        return $connection;

    } catch (Exception $exc) {
        
        return null;
    }
}
