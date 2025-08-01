<?php

/**
 * Aplicación web para las diversas entradas o posts. Ha de cumplir:
 * 
 * 1. Mostrar la publicación cuyo id recibe.
 *      (HECHO)
 * 
 * 2. Mostrará todos los comentarios de dicha publicación.
 *      (HECHO)
 * 
 * 3. Mostrará un formulario para comentar la publicación, que se enviarán a la
 *      página de entry.php
 * 
 *      (HECHO)
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

        if (!isset($_GET['entry_id'])) {

            $_SESSION['errors']['entry'] =
                'La entrada que desea ver no está disponible en estos momentos';
            header('location:/');
            exit;
        } else {

            $_GET['entry_id'] = trim($_GET['entry_id']);
        }

        $connection = connectDB();

        $query = $connection->prepare(
            'SELECT 
                u.id AS u_id,
                u.user AS user,
                e.text AS text,
                e.id AS e_id,  
                (
                    SELECT 
                    COUNT(l.user_id) 
                    FROM 
                    likes l, entries e2 
                    WHERE 
                    l.entry_id = e2.id AND e2.id=e.id
                ) AS likes, 
                (
                    SELECT 
                    COUNT(d.user_id) 
                    FROM 
                    dislikes d, entries e3 
                    WHERE 
                    d.entry_id = e3.id AND e3.id = e.id
                ) AS dislikes
            FROM 
                entries e, users u
            WHERE 
                e.user_id = u.id AND e.id = :e_id;'
        );

        $query->bindParam(':e_id', $_GET['entry_id']);

        $query->execute();

        $entry = $query->fetchObject();

        // var_dump($entry); // Traza

        $query = $connection->prepare(
            'SELECT 
                u.user AS user,
                c.text AS comment,
                c.date AS date
            FROM 
                comments c, users u
            WHERE 
                u.id = c.user_id AND c.entry_id = :e_id;'
        );

        $query->bindParam(':e_id', $_GET['entry_id']);

        $query->execute();

        $comments = $query->fetchAll(PDO::FETCH_OBJ);

        // var_dump($comments); // Traza

        unset($query);
        unset($connection);
    } catch (Exception $exc) {
        $errors['entry'] =
            'La publicación no se encuentra disponible en estos momentos';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= CSS_LINK ?>
    <?= BOOT_LINK ?>
    <title>Trolleadas</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    echo '<div class="container">';
    echo '<div class="row">';
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');
    
    if (isset($entry)) {
        echo '<div class="col-lg-6 post">';
        echo '<div class="my-3">';
        echo '<a href="/user/' . $entry->u_id . '">' . $entry->user . '</a>';
        echo '</div>';
        echo '<div class="p-4">' . $entry->text . ' </div>';
        echo '<span>Likes: ' . $entry->likes . ' </span>';
        echo '<span>Dislikes: ' . $entry->dislikes . ' </span>';
        echo '<div class="my-2">';
        if (isset($comments) && !empty($comments)) {

            foreach ($comments as $comment) {
                echo '<div class="d-flex justify-content-start">';
                echo $comment->user;
                echo ':</div>';
                echo '<div class="d-flex justify-content-center">';
                echo '<span class="d-flex p-2 ms-5 flex-fill">';
                echo $comment->comment;
                echo '</span>';
                echo '<span class="d-flex p-2 align-self-end">';
                echo date_format(new DateTime($comment->date), 'd/m/y');
                echo '</span>';
                echo '</div>';
            }
        } else {
            echo '<label class="my-2" for="text">Esta publicación está sin trollear</label>';
        }
    ?>
        <div >
            <form class="d-flex flex-column" action="/comment/<?= $_GET['entry_id'] ?? '' ?>" method="post">
                <input
                    type="text"
                    name="text"
                    id="text"
                    style="height:50px"
                    placeholder="Trolea, va, que lo estás deseando...">
                <input type="submit" value="Troleo">
            </form>
        </div>
    <?php
        if (isset($_SESSION['errors']['comment'])) {
            echo '<div class="errors">' . $_SESSION['errors']['comment'] . '</div>';
            unset($_SESSION['errors']['comment']);
        }
        echo '</div>';
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
    </div>
</body>

</html>