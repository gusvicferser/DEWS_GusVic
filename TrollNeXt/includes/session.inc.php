<?php
/**
 * Include para añadir el inicio de sesión:
 * 
 * @author Gustavo Víctor
 * @version 2.0
 */

// Cambiamos el nombre de la cookie de la sesión:
ini_set('session.name', 'SIDA');

// Le decimos al servidor que las cookies se han de obtener a través de http:
ini_set('session.cookie_httponly', 1);

// Modificamos la cookie para que expire en 1 día:
ini_set('session.cookie_lifetime', 86400000); // 

// Iniciamos sesión:
session_start();