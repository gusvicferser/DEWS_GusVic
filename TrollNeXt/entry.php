<?php
/**
 * Aplicación web para las diversas entradas o posts. Ha de cumplir:
 * 
 * 1. Mostrar la publicación cuyo id recibe.
 * 
 * 2. Mostrará todos los comentarios de dicha publicación.
 * 
 * 3. Mostrará un formulario para comentar la publicación, que se enviarán a la
 *      página de entry.php
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
    <title>Trolleadas</title>
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