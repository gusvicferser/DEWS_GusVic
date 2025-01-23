<?php

/**
 * Aplicación web para eliminar la publicación cuyo id reciba:
 * 
 * 1. Elimina la publicación cuyo id reciba, todos los comentarios y likes y 
 *      dislikes y redirigirá a la pantalla list:
 * 
 *      (HECHO)
 *  
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
    // Si el id de la publicación está seteada entonces podemos borrarla:
    if (isset($_GET['entry_id'])) {

        try {

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    id, user_id
                FROM 
                    entries 
                WHERE 
                    id=:entry;'
            );

            $query->bindParam(':entry', $_GET['entry_id']);

            $query->execute();

            $res = $query->fetchObject();

            // var_dump($res->entries); // Traza

            // Así comprobamos que la entrada exista. Si es así se puede eliminar:
            if ($query->rowCount() == 1 && $res->user_id === $_SESSION['user_id']) {

                $tables = ['likes', 'dislikes', 'comments'];

                foreach ($tables as $key => $table) {
                    $queries[$key] =
                        $connection->prepare(
                            'DELETE FROM ' .
                                $table .
                                ' WHERE entry_id=' .
                                $res->id .
                                ';'
                        );
                }

                $queries[] =
                    $connection->prepare(
                        'DELETE FROM 
                            entries 
                        WHERE 
                            id=' . $res->id . ';'
                    );

                /* Vamos a realizar una transacción porque quiero que se hagan
                todas las queries o ninguna:*/
                $connection->beginTransaction();

                // Bucle para ejecutar todas las queries con un try catch:
                try {
                    foreach ($queries as $query) {
                        if ($query->execute() == 0) {
                            throw new Exception('Error al borrar');
                        }
                    }
                    $connection->commit();
                    $_SESSION['success'] = 'Post eliminado';

                } catch (Exception $exc) {
                    $connection->rollback();
                    throw new Exception($exc);
                }

                // Quitamos el set a todas las variables:
                unset($query);
                unset($queries);
                unset($connection);
            }
            // Enviamos para la cuenta:
            header('location:/list');
            exit;
        } catch (Exception $exc) {
            $_SESSION['errors']['delete_entry'] =
                'No se ha podido borrar la publicación';
        }
    } else {
        // Enviamos para la cuenta:
        header('location:/list');
        exit;
    }
}
