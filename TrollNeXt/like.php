<?php

/**
 * Aplicación para likear una publicación si no está likeada o quitarle el like
 * si lo tiene y añadirlo a dislike:
 * 
 * (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.0
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
    !isset($_GET['entry_id'])
) {

    // var_dump($_SESSION['user_fol']); // Traza

    header('location:/');
    exit;
} else {

    if (!empty($_GET['entry_id'])) {

        try {
            $_GET['entry_id'] = trim($_GET['entry_id'] ?? '');

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    COUNT(l.user_id) AS liked 
                FROM 
                    likes l
                WHERE  
                    l.entry_id = :entry_id AND
                    l.user_id = ' . $_SESSION['user_id'].';'
            );

            $query->bindParam('entry_id', $_GET['entry_id']);

            $query->execute();

            $liked = $query->fetchObject();

            $query = $connection->prepare(
                'SELECT 
                    COUNT(d.user_id) AS disliked 
                FROM 
                    dislikes d
                WHERE 
                    d.entry_id=:entry_id AND
                    d.user_id = ' . $_SESSION['user_id'].';'
            );

            $query->bindParam('entry_id', $_GET['entry_id']);

            $query->execute();

            $disliked = $query->fetchObject();

            // Trazas:
            // var_dump($liked);
            // var_dump($disliked);

            // Si tiene likes, hay que sacarlos y ponerlos en la tabla dislike:
            if ($liked->liked > 0) {
                $query = $connection->prepare(
                    'DELETE FROM 
                        likes 
                    WHERE
                        entry_id = :entry_id AND 
                        user_id = '. $_SESSION['user_id'] .';'
                );

                $query->bindParam(':entry_id', $_GET['entry_id']);

                $query->execute();

                $query = $connection->prepare(
                    'INSERT INTO 
                        dislikes (entry_id, user_id)
                    VALUES 
                        (:entry_id, '. $_SESSION['user_id'] .');'
                );

                $query->bindParam(':entry_id', $_GET['entry_id']);

                $query->execute();

            } else {
                // Si no tiene likes, hay que hacer like:
                if ($disliked->disliked > 0) {

                    $query = $connection->prepare(
                        'DELETE FROM 
                            dislikes 
                        WHERE
                            entry_id = :entry_id AND 
                            user_id = '. $_SESSION['user_id'] .';'
                    );
    
                    $query->bindParam(':entry_id', $_GET['entry_id']);
    
                    $query->execute();
                }

                // Si no tiene dislikes ni likes, hay que hacer la inserción 
                // igual en la tabla likes:
                $query = $connection->prepare(
                    'INSERT INTO 
                        likes (entry_id, user_id)
                    VALUES 
                        (:entry_id, '. $_SESSION['user_id'] .');'
                );

                $query->bindParam(':entry_id', $_GET['entry_id']);

                $query->execute();
            }

            // Cerramos la conexión:
            unset($query);
            unset($connection);

        } catch (Exception $exc) {
            $_SESSION['errors']['follow'] = $exc;
            header('location:/');
            exit;
        }
    }

    // Si no hay nada en get, a casa:
    header('location:/');
    exit;
}
