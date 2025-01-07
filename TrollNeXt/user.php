<?php
/**
 * Aplicación web para el usuario. Ha de cumplir:
 * 
 * 1. Mostrará los datos del usuario cuya id reciba por get y cantidad de 
 *      seguidores que tiene.
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

 // Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

// Si no hay usuario registrado, le enviamos de nuevo al índice sin más:
if (!isset($_SESSION['user_name'])) {

    header('location:/');
    exit;
} else {
    try{

        if(isset($_GET['user_id'])) {

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT users, '
            ); // CONTINUAR

        } else {

            // Si no se pasa ningún id de usuario, entonces lo devolvemos al index:
            header('location:/');
            exit;
        }

    } catch (Exception $exc) {
        $errors['user'] = '¡El usuario no existe!';
    }
}
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