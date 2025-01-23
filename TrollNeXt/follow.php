<?php

/**
 * Aplicación para seguir si no se sigue a ese usuario o para dejarle de seguir
 * en caso de que el usuario que manda la petición lo siga (follow/unfollow):
 * 
 * (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.2
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

// Si no hay usuario registrado, ni se pasan por get los datos necesarios, 
// le enviamos de nuevo al índice sin más:
if (
    !isset($_SESSION['user_name']) &&
    !isset($_GET['user_followed'])
) {

    // var_dump($_SESSION['user_fol']); // Traza

    header('location:/');
    exit;
} else {

    if (!empty($_GET['user_followed'])) {

        try {

            foreach ($_GET as $key => $element) {
                $_GET[$key] = trim($_GET[$key]);
            }

            if ($_GET['user_followed'] == $_SESSION['user_id']) {
                $_SESSION['errors']['oneself'] =
                    'Buen intento de ganar seguidores, 
                    pero no te puedes seguir a ti mismo';
                header('location:/');
                exit;
            }

            $connection = connectDB();

            // Comprobamos si el usuario que nos pasan existe:
            $query = $connection->prepare(
                'SELECT 
                    COUNT(id) AS quantity
                FROM 
                    users
                WHERE
                    id = :user_followed;'
            );

            $query->bindParam(':user_followed', $_GET['user_followed']);

            $query->execute();

            $result = $query->fetchObject();

            // Si el usuario existe, entonces se puede seguir:
            if ($result->quantity > 0) {

                if (isset($_SESSION['user_fol']) && !empty($_SESSION['user_fol'])) {
                    foreach ($_SESSION['user_fol'] as $key => $follower) {
                        if ($_GET['user_followed'] == $key) {

                            $query = $connection->exec(
                                'DELETE FROM 
                                    follows 
                                WHERE 
                                    user_id =' .
                                    $_SESSION['user_id'] .
                                    ' AND user_followed =' .
                                    $key .
                                    ';'
                            );

                            $_SESSION['success'] =
                                'Has dejado de seguir al usuario ' .
                                $follower->fol_name;

                            // Hemos de volver a guardar a los seguidores:
                            require_once(
                                $_SERVER['DOCUMENT_ROOT'] .
                                '/includes/followers.inc.php'
                            );

                            // Quitamos conexión y devolvemos al index:
                            unset($query);
                            unset($connection);
                            header('location:/');
                            exit;

                            // var_dump($_SESSION['user_fol']); // Traza
                        }
                    }
                }

                // Si el usuario no se encontraba en la lista de seguidos, follow:
                $query = $connection->prepare(
                    'INSERT INTO 
                    follows (user_id, user_followed)
                    VALUES 
                    (' . $_SESSION['user_id'] . ', :follow);'
                );

                $query->bindParam(':follow', $_GET['user_followed']);

                $query->execute();
                // print_r($query->debugDumpParams()); // Traza

                // Por último guardamos todos los seguidores en la sesión y 
                // devolvemos a index:
                require_once(
                    $_SERVER['DOCUMENT_ROOT'] .
                    '/includes/followers.inc.php'
                );


                // Añadimos a los éxitos el haber añadido a ese usuario:
                $_SESSION['success'] =
                    'Ahora sigues al usuario ' .
                    $_SESSION['user_fol'][$_GET['user_followed']]->fol_name;

                // var_dump($_SESSION['user_fol']); // Traza
            } else {
                $_SESSION['errors']['follow'] = 
                    'El usuario a quien intentas seguir no existe';
            }
            // Deseteamos la conexión a la base de datos:
            unset($query);
            unset($connection);
        } catch (Exception $exc) {
            // $_SESSION['errors']['follow'] = $exc;
            header('location:/');
            exit;
        }
    }
        // Devolvemos al índice:
        header('location:/');
        exit;
}
