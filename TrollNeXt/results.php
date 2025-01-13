<?php

/**
 * Aplicación web para los resultados de la búsqueda. Ha de tener:
 * 
 * 1. Recibe los datos por get y muestra una lista de los usuarios que coincidan
 *      con la búsqueda. (POR PROBAR)
 * 
 * 2. Mostrará un botón para seguir a los usuarios o dejar de seguirlos según
 *      si el usuario logueado sigue o no a esos usuarios. 
 * 
 * 3. Cada usuario será un enlace a la página user con el id de ese usuario.
 *          (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.2
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

                if (
                    !isset($_SESSION['user_fol']) ||
                    empty($_SESSION['user_fol'])
                ) {

                    $query = $connection->query(
                        'SELECT 
                            f.user_followed AS fol_id,
                            u.user AS fol_name
                        FROM
                            follows f LEFT JOIN users u
                        ON 
                            u.id = f.user_id
                        WHERE
                            user_id =' .  $_SESSION['user_id'] . ';'
                    );

                    $_SESSION['user_fol'] = $query->fetchAll(PDO::FETCH_OBJ);

                    foreach ($_SESSION['user_fol'] as $follower) {
                        $following[$follower->id] = $follower->id;
                    }
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

                if (isset($following)) {
                    if (in_array($result->id, $following)) {
                        echo '<a href="/follow/' . $result->id . '">Unfollow</a>';
                    }
                } else {
                    echo '<a href="/follow/' . $result->id . '">Follow</a>';
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