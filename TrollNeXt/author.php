<?php
/**
 * Aplicación web para mostrar al autor. Es decir, yo. Ha de incluir:
 * 
 * Nombre del creador
 * Foto de mí
 * 
 * (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.3
 */

 // Iniciamos la sesion:
 require_once($_SERVER['DOCUMENT_ROOT']. '/includes/session.inc.php');

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author</title>
 </head>
 <body>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.inc.php');
   ?>
    <h1>Gustavo Víctor (El creador)</h1>
    <img src="/img/gus.jpg" alt="gus.jpg" width="400px">

    <?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.inc.php');
    ?>
 </body>
 </html>