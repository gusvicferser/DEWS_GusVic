<?php
/**
 * Aplicación web para el usuario. Ha de cumplir:
 * 
 * 1. Mostrará los datos del usuario cuya id reciba por get y cantidad de 
 *      seguidores que tiene.+
 * 
 * 2. Se mostrará una lista de todas sus publicaciones. 
 *      2.1 De cada publicación mostrará sólo los 50 primeros caracteres (enlace
 *          a la página entry.php) y la cantidad de likes y dislikes de esa 
 *          publicación.
 * 
 * 
 * @author Gustavo Víctor
 * @version 1.0
 */

 // Iniciamos la sesion:
 require_once($_SERVER['DOCUMENT_ROOT']. '/includes/session.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Troll</title>
</head>
<body>
<?php
   require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.inc.php');
   ?>
   
<?php
    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.inc.php');
    ?>
</body>
</html>