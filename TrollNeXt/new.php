<?php
/**
 * Aplicación web para una nueva entrada de la red social. Ha de cumplir:
 * 
 * 1. Si no recibe datos muestra un formulario para introducir una nueva 
 *      publicación. En caso de errores vuelve a mostrar todo el formulario y un
 *      mensaje indicando el error.
 * 
 * 2. En el caso de que los datos sean correctos, guardará la publicación y 
 *      redirigirá a la página de dicha entrada (entry.php).
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
    <title>Nuevo Trolleo</title>
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