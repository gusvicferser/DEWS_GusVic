<?php
/**
 * Aplicación web para cerrar sesión:
 * 
 * @author (Corregido) Gustavo Víctor
 * @version 2.0
 */

 // Sesión (hacemos los cambios en la cookie e iniciamos sesión):
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Se tiene que cerrar la sesión:
session_destroy();

// Una vez cerrada la sesión se redirige a index
header ('location: /');