<?php

/**
 * Aplicación web para los comentarios de las publicaciones. Ha de cumplir:
 * 
 * 1. Recibe los datos del formulario de la página entry.php. (HECHO)
 * 
 * 2. Si se produce un error en los datos ha de mostrarse. Si todo está bien, 
 *      se guarda el comentario y se redirige a la página de entry.php
 * 
 *      (TESTEAR)
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

    // Si la publicación está seteada entonces podemos comentar:
    if (isset($_GET['e_id'])) {

        try {

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    COUNT(id)
                FROM 
                    entries 
                WHERE 
                    id=:entry;'
            );

            $query->bindParam(':entry', $_GET['e_id']);

            $query->execute();

            $res = $query->fetch();

            // Así comprobamos que la entrada exista. Si es así se puede comentar:
            if ($res == 1) {

                // Mecanismo de seguridad troll:
                if (
                    (strpos("'--", $_POST['text']) > 0) ||
                    (strpos("'; select", $_POST['text']) > 0) ||
                    (strpos("'; insert", $_POST['text']) > 0) ||
                    (strpos("'; delete", $_POST['text']) > 0)
                ) {

                    $funnies = [
                        '¡Soy Gay! Me ha costado admitirlo, así si lo niego de 
                    pronto, es porque he vuelto al armario, ¡no dejéis que pase!',
                        '¿Alguien para probar el pegging?',
                        '¿A alguien más le pasa que cuando está en el tema le da
                    diarrea explosiva?',
                        '¿Qué significan las dos rayitas en un test de embarazo?'
                    ];

                    $_POST['text'] = $funnies[random_int(0, 4)];
                }

                $query = $connection->prepare(
                    'INSERT INTO 
                        comments (entry_id, user_id, text)
                    VALUES 
                        (:entry,' . $_SESSION['user_name'] . ', :text);'
                );

                $query->bindParam(':entry', $_GET['e_id']);
                $query->bindParam(':text', $_POST['text']);

                $query->execute();

                // Cerramos la conexión a la base de datos:
                unset($query);
                unset($connection);
            }
        } catch (Exception $exc) {
            // Si ha habido un error, le pasamos que la entrada en cuestión ha dado 
            // fallo:
            header('location:/entry/' . $_GET['e_id'] . '/error/true');
            exit;
        }
    } else {

        // Si hay sesión pero no se ha pasado una entrada, se envía al index:
        header('location:/');
        exit;
    }
}
