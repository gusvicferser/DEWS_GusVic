<?php

/**
 * Aplicación web para eliminar la cuenta de la persona cuya cuenta esté abierta:
 * 
 * 1. 
 * 
 * @author Gustavo Víctor
 * @version 1.0
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

    if (
        isset($_POST['confirm']) && !empty($_POST['confirm'])
    ) {

        // var_dump($_POST);

        try {

            $connection = connectDB();

            // Hay que eliminar primero los comentarios de cada entrada:
            $query = $connection->query(
                'SELECT 
                    id
                FROM
                    entries
                WHERE 
                    user_id = ' . $_SESSION['user_id'] . ';'
            );

            $query->execute();

            $entries = $query->fetchAll(PDO::FETCH_OBJ);

            // Traza:
            // echo '<pre>';
            // var_dump($entries);
            // echo '</pre>';

            // Si no tiene posts, hemos de saltarnos este paso:
            $qString =
                'DELETE FROM 
                        comments
                    WHERE';

            // Si hay entradas, las vamos añadiendo a la query:
            foreach ($entries as $key => $entry) {
                $qString .= ' entry_id = ' . $entry->id;
                if ($key != array_key_last($entries)) {
                    $qString .= ' OR ';
                }
            }

            /* Si no hay entradas, no necesitamos el OR, sólo debemos eliminar
            los comentarios del usuario, ya que de lo contrario no nos 
            permitirá eliminarlos la base de datos:*/

            if (!empty($entries)) {
                $qString .= ' OR ';
            }

            $qString .= ' user_id = ' . $_SESSION['user_id'] . ';';

            $queries[] =
                $connection->prepare($qString);

            // Luego eliminamos sus entradas:
            $queries[] =
                $connection->prepare(
                    'DELETE FROM 
                        entries 
                    WHERE 
                        user_id=' . $_SESSION['user_id'] . ';'
                );

            // Luego hay que eliminar los follows y también la relación de quien
            // sigue al usuario ya que es una clave primaria doble:
            $queries[] =
                $connection->prepare(
                    'DELETE FROM 
                        follows 
                    WHERE 
                        user_id=' . $_SESSION['user_id'] . 
                        ' OR user_followed = '. $_SESSION['user_id'] .';'
                );

            // Por último quitamos al usuario:
            $queries[] =
                $connection->prepare(
                    'DELETE FROM 
                            users 
                        WHERE 
                            id=' . $_SESSION['user_id'] . ';'
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
            } catch (Exception $exc) {
                $connection->rollback();
                throw new Exception($exc);
            }

            // Quitamos el set a todas las variables:
            unset($query);
            unset($queries);
            unset($connection);

            // Destruimos la sesión:
            session_destroy();

            // Enviamos para inicio:
            header('location:/');
            exit;

        } catch (Exception $exc) {
            $_SESSION['errors']['delete_user'] =
                'No se ha podido completar la acción';

            $_SESSION['errors']['delete_user'] = $exc;

            // // Traza:
            // echo '<pre>';
            // var_dump($exc);
            // echo '</pre>';

            // Enviamos para la cuenta:
            header('location:/account');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar su cuenta</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>
    <div class="user_form">
        <form action="#" method="post">
            <fieldset>
                <legend>Eliminar cuenta de <?= $_SESSION['user_name'] ?></legend>
                <br>
                <input
                    type="checkbox"
                    name="confirm"
                    id="confirm"
                    value="true">
                <label for="confirm">
                    ¿Está seguro de que quiere borrar su cuenta?<br>
                    Esta acción no se puede deshacer
                </label>
                <br><br>
                <input type="submit" value="Borra todo">
            </fieldset>
        </form>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>