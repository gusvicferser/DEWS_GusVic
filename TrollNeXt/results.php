<?php
/**
 * Aplicación web para los resultados de la búsqueda. Ha de tener:
 * 
 * 1. Recibe los datos por get y muestra una lista de los usuarios que coincidan
 *      con la búsqueda. 
 * 
 *      1.1 Cada usuario será un enlace a la página user con el id de ese usuario.
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
    <title>Nido D Trolls</title>
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