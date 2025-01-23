<?php

/**
 * Aplicación web para una nueva entrada de la red social. Ha de cumplir:
 * 
 * 1. Si no recibe datos muestra un formulario para introducir una nueva 
 *      publicación. En caso de errores vuelve a mostrar todo el formulario y un
 *      mensaje indicando el error. 
 * 
 *      (HECHO)
 * 
 * 2. En el caso de que los datos sean correctos, guardará la publicación y 
 *      redirigirá a la página de dicha entrada (entry.php).
 * 
 *      (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.5
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

        if (isset($_POST['text']) && !empty($_POST['text'])) {
            // Le hacemos el trim al texto:
            $_POST['text'] = trim($_POST['text']);

            // Mecanismo de seguridad troll:
            if (
                (strpos($_POST['text'], "--") !== false) ||
                (strpos($_POST['text'], "; select") !== false) ||
                (strpos($_POST['text'], "; insert") !== false) ||
                (strpos($_POST['text'], "; drop") !== false) ||
                (strpos($_POST['text'], "; update") !== false)
            ) {

                $funnies = [
                    '¡Soy Gay! Me ha costado admitirlo, así si lo niego de 
                    pronto, es porque he vuelto al armario, ¡no dejéis que pase!',
                    '¿Alguien para probar el pegging?',
                    '¿A alguien más le pasa que cuando está follando le da
                    diarrea explosiva?',
                    '¿Qué significan las dos rayitas en un test de embarazo?'
                ];

                $_POST['text'] = $funnies[random_int(0, 3)];
            }

            // Hacemos la conexión:
            $connection = connectDB();

            // Preparamos la query:
            $query = $connection->prepare(
                'INSERT INTO 
                    entries (user_id, text)
                VALUES 
                    (' . $_SESSION['user_id'] . ', :text);'
            );

            $query->bindParam(':text', $_POST['text']);

            // var_dump($query->debugDumpParams());

            // Ejecutamos:
            $query->execute();

            $query = $connection->query(
                'SELECT 
                    e.id AS e_id
                FROM 
                    entries e
                WHERE
                    e.user_id=' . $_SESSION['user_id'] . '
                ORDER BY e.date DESC
                LIMIT 1;'
            );

            $entry_id = $query->fetchObject();

            // var_dump($entry_id); // Traza

            // Quitamos la conexión una vez hecho el insert:
            unset($query);
            unset($connection);

            // Devolvemos a la página de entry con la publicación:
            header('location:/entry/' . $entry_id->e_id);
            exit;
        }
    } catch (Exception $exc) {
        $errors['new'] = '¡No se ha podido crear la nueva publicación!';
        // $errors['new'] = $exc;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Trolleo</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');
    ?>

    <div class="form">
        <form action="#" method="post">
            <fieldset>
                <input
                    type="text"
                    name="text"
                    id="nText"
                    value="<?= $_POST['text'] ?? '' ?>">
                <br>
                <input type="submit" value="Publicar">
            </fieldset>
        </form>
        <?php
        if (isset($errors['new'])) {
            echo '<div class="errors">' . $errors['new'] . '</div>';
        }
        ?>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>