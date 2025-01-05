<?php
/**
 * Aplicación web para los comentarios de las publicaciones. Ha de cumplir:
 * 
 * 1. Recibe los datos del formulario de la página entry.php. 
 * 
 * 2. Si se produce un error en los datos ha de mostrarse. Si todo está bien, 
 *      se guarda el comentario y se redirige a la página de entry.php
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
    <title>Komentar</title>
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