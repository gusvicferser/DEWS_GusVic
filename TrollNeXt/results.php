<?php

/**
 * Aplicación web para los resultados de la búsqueda. Ha de tener:
 * 
 * 1. Recibe los datos por get y muestra una lista de los usuarios que coincidan
 *      con la búsqueda. 
 * 
 *      (HECHO)
 * 
 * 2. Mostrará un botón para seguir a los usuarios o dejar de seguirlos según
 *      si el usuario logueado sigue o no a esos usuarios. 
 * 
 *      (HECHO)
 * 
 * 3. Cada usuario será un enlace a la página user con el id de ese usuario.
 *      
 *     (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.4
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

// Si no hay usuario registrado, le enviamos de nuevo al índice sin más:
if (!isset($_SESSION['user_name'])) {

    header('location:/');
    exit;
} else {
    try {

        // Si nos pasan una búsqueda:
        if (isset($_GET['search'])) {

            // Super importante sacarle los espacios del principio y el final:
            $_GET['search'] = trim($_GET['search']);

            // BindParam no admite cadenas de texto dentro de la función:
            $search = '%' . $_GET['search'] . '%';

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    id,
                    user
                FROM 
                    users 
                WHERE 
                    user LIKE :user_name;'
            );

            $query->bindParam(':user_name', $search);

            $query->execute();

            if ($query->rowCount() > 0) {

                $results = $query->fetchAll(PDO::FETCH_OBJ);

                // Si no hemos seteado previamente los usuarios a los que sigue:
                if (
                    !isset($_SESSION['user_fol']) ||
                    empty($_SESSION['user_fol'])
                ) {

                    require_once(
                        $_SERVER['DOCUMENT_ROOT'] .
                        '/includes/followers.inc.php'
                    );
                }
            }

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

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');

    // Apartado de trazas:
    // echo '<pre>';
    // var_dump($_SESSION['user_fol']);
    // var_dump($results);
    // echo '</pre>';

    if (isset($errors)) {
        echo '<div class="errors">';
        foreach ($errors as $key => $error) {
            echo '<div>' . $errors[$key] . '</div>';
        }
        echo '</div>';
    }
    ?>

    <div id="results">
        <?php
        if (isset($results) && !empty($results)) {
            foreach ($results as $result) {
                echo '<div id="' . $result->user . '">';
                echo '<a 
                        href="/user/' . $result->id .
                    '">' .
                    $result->user .
                    '</a> ';

                // Ahora, si existe ese usuario entre sus seguidos:
                if (isset($_SESSION['user_fol'][$result->id])) {
                    // Si coincide con el usuario de la búsqueda, se pone para 
                    // dejar de seguir:
                    if ($result->id == $_SESSION['user_fol'][$result->id]->fol_id) {
                        echo
                        '<a href="/follow/'. $result->id . '">Unfollow</a>';
                    }
                    // De lo contrario, un botón para seguir:
                } else {
                    // Solo aparece el mensaje de seguir si no es el propio usuario:
                    if ($result->id != $_SESSION['user_id']) {
                        echo
                        '<a href="/follow/'. $result->id . '">Follow</a>';
                    }
                }
                echo '</div>';
            }
        } else {
        ?>
            <div>
                <h1>¡No hay resultados que mostrar!</h1>
            </div>
        <?php
            if (isset($errors['search'])) {
                echo '<div class="errors">' . $errors['search'] . '</div>';
            } else {
            }
        }
        ?>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>