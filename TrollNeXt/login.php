<?php
/**
 * Aplicación web para loguearse en la red social. Requiere:
 * 
 * 1. Si no recibe datos, muestra formulario para autenticarse. Datos se envían a 
 *      la propia página (#).
 * 
 * 2. Si recibe datos, trata de hacer el login.
 * 
 * 3. En caso de error, se devuelve al formulario con los datos cumplimentados y
 *      un mensaje que diga que error se muestra. 
 * 
 * 4. Si los datos son correctos, se redirige a index.
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
    <title>Accede</title>
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