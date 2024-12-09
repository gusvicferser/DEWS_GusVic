<?php
/**
 * Include para añadir el inicio de sesión:
 * 
 * @author Gustavo Víctor
 * @version 1.0
 */

// Cambiamos el nombre de la cookie de la sesión:
ini_set('session.name', 'SessionGustavoVictor');

// Le decimos al servidor que las cookies se han de obtener a través de http:
ini_set('session.cookie_httponly', 1);

// Modificamos la cookie para que expire en 5 min:
ini_set('session.cookie_lifetime', 300); // 300 segundos = 5 min

// Iniciamos sesión:
session_start();