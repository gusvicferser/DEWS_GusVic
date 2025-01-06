<?php

/**
 * Aplicación web para el índice de la red social. Ha de cumplir:
 * 
 * 1. Si no está logueado, mensaje de bienvenida y de invitación a registrarse.
 * 
 * 2. Mostrará el formulario de registro que envía datos al propio index (#).
 * 
 * 3. 
 *    3.1 Si está logueado, mostrará el tablón de anuncios con todas las 
 *        publicaciones de los usuarios en orden cronológico (desc).
 *  
 *    3.2 Estas publicaciones tendrán el texto y será un enlace a la página entry. 
 * 
 *    3.3 El autor con un enlace a la página user.
 * 
 *    3.4 Imágenes para indicar si gusta o no y el número de comentarios de una
 *        publicación.
 * 
 * @author Gustavo Víctor
 * @version 1.1
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');


?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TrollNeXt</title>
</head>

<body>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
   ?>
   <br><br>
   <a href="/author.php">Author</a>
   <a href="/close.php">Close</a>
   <a href="/comment.php">Comment</a>
   <a href="/entry.php">Entry</a>
   <a href="/login.php">Login</a>
   <a href="/new.php">New</a>
   <a href="/results.php">Results</a>
   <a href="/bck/account.php">Account</a>
   <a href="/bck/cancel.php">Cancel</a>
   <a href="/bck/delete.php">Delete</a>
   <a href="/bck/list.php">List</a>
   <br><br>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
   ?>
</body>

</html>