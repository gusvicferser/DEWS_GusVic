<?php

/**
 * Aplicación web para el usuario. Ha de cumplir:
 * 
 * 1. Mostrará los datos del usuario cuya id reciba por get y cantidad de 
 *      seguidores que tiene.  (HECHO)
 * 
 * 2. Se mostrará una lista de todas sus publicaciones. (HECHO)
 *      2.1 De cada publicación mostrará sólo los 50 primeros caracteres (enlace
 *          a la página entry.php) y la cantidad de likes y dislikes de esa 
 *          publicación. (HECHO)
 * 
 * 
 * @author Gustavo Víctor
 * @version 1.3
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
        // Si está seteada la variable de GET, buscamos en el sistema:
        if (isset($_GET['user_id'])) {
            // Quitamos espacios al inicio y al final, super importante:
            $_GET['user_id'] = trim($_GET['user_id']);

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    u.id AS user_id, 
                    u.user AS user_name, 
                    COUNT(f.user_id) AS followers 
                FROM 
                    users u LEFT JOIN follows f 
                ON 
                    u.id = f.user_followed 
                WHERE 
                    u.id=:user_id;'
            );

            $query->bindParam(':user_id', $_GET['user_id']);

            $query->execute();

            $id_res = $query->fetchObject();

            // var_dump($id_res); // Traza

            // Puedo contar cuántas filas tiene este array de obj con count():
            if (!empty($id_res)) {

                $query = $connection->query(
                    'SELECT 
                        e.id AS e_id, 
                        e.text AS text, 
                        (SELECT 
                            COUNT(l.entry_id) 
                        FROM 
                            likes l, entries e2 
                        WHERE 
                            l.entry_id = e2.id AND e2.id = e.id) AS likes, 
                        (SELECT 
                            COUNT(d.entry_id) 
                        FROM 
                            dislikes d, entries e3 
                        WHERE 
                            d.entry_id = e3.id AND e3.id=e.id) AS dislikes 
                    FROM 
                        entries e 
                    WHERE 
                        e.user_id=' . $id_res->user_id . ';'
                );

                $entries = $query->fetchAll(PDO::FETCH_OBJ);
            } 

            // Quitamos la conexión:
            unset($query);
            unset($connection);
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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Troll</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');
    
    if(isset($entries)) {
        echo '<div class="user"> Usuario: ' . $id_res->user_name . '</div>';
        echo '<div> Followers: ' . $id_res->followers . '</div>';
        echo '<div class="posts">';
         foreach ($entries as $entry) {
            echo '<div class="post">';
            echo '<div>';
            echo 
                '<a href="/entry/'. 
                $entry->e_id .
                '">'. 
                trim(substr($entry->text, 0, 50)) .
                '...</a>';
            echo '</div>';
            echo '<span>Likes: ' . $entry->likes . ' </span>';
            echo '<span>Dislikes: ' . $entry->dislikes . ' </span>';
            echo '</div>';
            echo '<br>';
         }
         echo '</div>';
      } else {
         echo '<div class="posts">';
         echo '<div class="post">';
         echo '<div>';
         echo '<h2>¡Este usuario no tiene posts!</h2>';
         echo '</div>';
      }
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>