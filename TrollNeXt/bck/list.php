<?php

/**
 * Aplicación web para mostrar una lista de todas las publicaciones escritas
 * por el usuario, similar a la de la página user junto a un botón para
 * poder eliminar cada una de ellas:
 * 
 *      (TO DO)
 * 
 * @author Gustavo Víctor
 * @version 1.1
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

        $connection = connectDB();

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
                e.user_id=' . $_SESSION['user_id'] . ';'
        );

        $entries = $query->fetchAll(PDO::FETCH_OBJ);

        // Quitamos la conexión:
        unset($query);
        unset($connection);
    } catch (Exception $exc) {
        $errors['user'] = 'No se ha podido acceder a tus publicaciones';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus burradas</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    if (isset($_SESSION['errors'])) {
        echo '<div class="errors">';
        foreach ($_SESSION['errors'] as $key => $error) {
           echo '<div>' . $_SESSION['errors'][$key] . '</div>';
        }
        echo '</div>';
  
        // Luego para quitar los errores, una vez mostrados, los eliminamos:
        unset($_SESSION['errors']);
     }
  
     if (isset($_SESSION['success'])) {
        echo '<div class="success">';
        echo '<div>' . $_SESSION['success'] . '</div>';
        echo '</div>';
  
        // Quitamos también los avisos de éxito:
        unset($_SESSION['success']);
     }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');
    
    if(isset($entries)) {
        echo '<div class="user">Cuenta actual:'. $_SESSION['user_name'] . '</div>';
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
            echo '<div>';
            echo '<a href="/delete/'. $entry->e_id . '">Eliminar</a>';
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
