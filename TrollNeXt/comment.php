<?php

/**
 * Aplicación web para los comentarios de las publicaciones. Ha de cumplir:
 * 
 * 1. Recibe los datos del formulario de la página entry.php. (HECHO)
 * 
 * 2. Si se produce un error en los datos ha de mostrarse. Si todo está bien, 
 *      se guarda el comentario y se redirige a la página de entry.php
 * 
 *      (HECHO)
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

    // Si la publicación está seteada entonces podemos comentar:
    if (isset($_GET['entry_id'])) {

        try {

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    COUNT(id) AS entries
                FROM 
                    entries 
                WHERE 
                    id=:entry;'
            );

            $query->bindParam(':entry', $_GET['entry_id']);

            $query->execute();

            $res = $query->fetchObject();

            // var_dump($res->entries); // Traza

            // Así comprobamos que la entrada exista. Si es así se puede comentar:
            if ($res->entries == 1) {

                // Mecanismo de seguridad troll:
                if (
                    (strpos($_POST['text'], "--") !== false) ||
                    (strpos($_POST['text'], "; select") !== false) ||
                    (strpos($_POST['text'], "; insert") !== false) ||
                    (strpos($_POST['text'], "; drop") !== false) ||
                    (strpos($_POST['text'], "; update") !== false)
                ) {

                    $funnies = [
                        'Ommelette du fromage',
                        'Era mejor la película que te has montado con esta
                        publicación',
                        '¿Buscas maduritos o maduritas por tu zona?',
                        'Es todo mentira... salvo alguna cosa',
                        'Me gustan los catalanes... Hacen cosas.'
                    ];

                    $_POST['text'] = $funnies[random_int(0, 4)];

                }

                $query = $connection->prepare(
                    'INSERT INTO 
                        comments (entry_id, user_id, text)
                    VALUES 
                        (:entry,' . $_SESSION['user_id'] . ', :text);'
                );

                $query->bindParam(':entry', $_GET['entry_id']);
                $query->bindParam(':text', $_POST['text']);

                $query->execute();

                // Cerramos la conexión a la base de datos:
                unset($query);
                unset($connection);

                // Devolvemos a la entrada:
                header('location:/entry/'. $_GET['entry_id']);
                exit;
            }
        } catch (Exception $exc) {
            // Si ha habido un error, le pasamos que la entrada en cuestión ha dado 
            // fallo:
            $_SESSION['errors']['comment'] = 
                'No se ha podido comentar la publicación';
            header('location:/entry/' . $_GET['entry_id']);
            exit;
        }
    } else {

        // Si hay sesión pero no se ha pasado una entrada, se envía al index:
        header('location:/');
        exit;
    }
}
