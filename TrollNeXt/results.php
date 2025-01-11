<?php

/**
 * Aplicación web para los resultados de la búsqueda. Ha de tener:
 * 
 * 1. Recibe los datos por get y muestra una lista de los usuarios que coincidan
 *      con la búsqueda. (POR PROBAR)
 * 
 *      1.1 Cada usuario será un enlace a la página user con el id de ese usuario.
 *          (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.2
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT']. '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/includes/connectDB.inc.php');

// Si no hay usuario registrado, le enviamos de nuevo al índice sin más:
if (!isset($_SESSION['user_name'])) {

    header('location:/');
    exit;

} else {
    try {

        if (isset($_GET['search'])) {

            // Super importante sacarle los espacios del principio y el final:
            $_GET['search'] = trim($_GET['search']); 

            // BindParam no admite cadenas de texto dentro de la función:
            $search = '%' . $_GET['search'] . '%';

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT id AS user_id 
            FROM users 
            WHERE id LIKE :user_id;'
            );

            $query->bindParam(':user_id', $search);

            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_OBJ);

            // Desconectamos de la base de datos:
            unset($query);
            unset($connection);
        }
    } catch (Exception $exc) {
        $errors['search'] = '¡No se ha podido realizar su búsqueda!';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nido D Trolls</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>

    <div id="results">
        <?php
        if (isset($_GET['search'])) {
            foreach ($results as $result) {
                echo '<div id="' . $results->user . '">';
                echo '<a 
                        href="/user/' . $results->id .
                    '">' .
                    $results->user .
                    '</a>';
                echo '</div>';
            }
        } else {
            if(isset($errors['search'])) {
                echo '<div class="errors">'. $errors['search'] . '</div>';
            } else {
        ?>
            <div>
                <h1>¡No hay resultados que mostrar!</h1>
            </div>
        <?php
            }
        }
        ?>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>