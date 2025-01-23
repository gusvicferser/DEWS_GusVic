<?php

/**
 * Aplicación web para loguearse en la red social. Requiere:
 * 
 * 1. Si no recibe datos, muestra formulario para autenticarse. Datos se envían a 
 *      la propia página (#). 
 * 
 *      (HECHO)
 * 
 * 2. Si recibe datos, trata de hacer el login.
 * 
 *      (HECHO)
 * 
 * 3. En caso de error, se devuelve al formulario con los datos cumplimentados y
 *      un mensaje que diga que error se muestra. 
 * 
 *      (HECHO)
 * 
 * 4. Si los datos son correctos, se redirige a index.
 * 
 *      (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.3
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');


// Si ya tiene la sesión iniciada, no tiene sentido que acceda a login:
if (isset($_SESSION['user_name'])) {

    header('location:/');
    exit;
} else {

    try {
        // Hemos de traer las variables y las conexiones:
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

        foreach ($_POST as $key => $element) {
            $_POST[$key] = trim($_POST[$key] ?? '');
        }

        // Bloque por si nos pasan por POST el acceso a la cuenta:
        if (isset($_POST['user_name'])) {

            if (
                empty($_SESSION['password_tries']) ||
                $_SESSION['password_tries'] < 8
            ) {

                $connection = connectDB();

                $query = $connection->prepare(
                    'SELECT 
                        id,
                        user AS user_name,
                        email,
                        password
                    FROM 
                        users
                    WHERE 
                        user = :user OR user = :mail;'
                );

                $query->bindParam(':user', $_POST['user_name']);
                $query->bindParam(':mail', $_POST['user_name']);

                $query->execute();

                // Comprobaciones para el login
                if ($query->rowCount() !== 1) {

                    $errors['login'] = 'Error en el acceso';
                } else {
                    $user = $query->fetchObject();

                    if (
                        !empty($_POST['password'])
                    ) {
                        if (
                            password_verify($_POST['password'], $user->password)
                        ) {

                            // Regeneramos la sesión para que no puedan robar la cuenta:
                            session_regenerate_id(); // SUPER IMPORTANTE:

                            $_SESSION['user_name'] = $user->user_name;
                            $_SESSION['user_id'] = $user->id;
                            $_SESSION['user_email'] = $user->email;

                            require_once(
                                $_SERVER['DOCUMENT_ROOT'] .
                                '/includes/followers.inc.php'
                            );

                            // Traza para comprobar cómo se guardan los seguidores:
                            // echo '<pre>';
                            // var_dump($_SESSION['user_fol']);
                            // echo '</pre>';

                            // Eliminamos los intentos erróneos:
                            unset($_SESSION['password_tries']);

                            // Eliminamos la conexión con la base de datos y redirigimos:
                            unset($query);
                            unset($connection);
                            header('location: /');
                            exit;
                        } else {

                            /* Si es incorrecto se almacena el error para mostrarlo 
                        en el body:*/
                            $errors['user']['pass'] = 'Contraseña incorrecta';

                            // Para controlar que no meta la contraseña más de 8 veces:
                            if (isset($_SESSION['password_tries'])) {
                                $_SESSION['password_tries']++;
                            } else {
                                $_SESSION['password_tries'] = 1;
                            }
                        }
                    } else {
                        $errors['user']['pass'] =
                            'La contraseña no puede estar vacía';
                    }
                }

                // Cerramos la conexión:
                unset($query);
                unset($connection);
            } else if (

                isset($_SESSION['password_tries']) &&
                $_SESSION['password_tries'] >= 8

            ) {
                $_SESSION['error_access'] =
                    'Ha intentado poner la contraseña demasiadas
                    veces, póngase en contacto con nosotros';
            }
        }
    } catch (Exception $exc) {
        $errors['login'] = 'No fue posible hacer el login';
        // $errors['login'] = $exc;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loguéate</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    if (isset($errors)) {
        echo '<div class="errors">';
        foreach ($errors as $key => $error) {
            if ($key != 'user' && $key != 'errors') {
                echo '<div>' . $errors[$key] . '</div>';
            }
        }
        echo '</div>';
    }
    if (!isset($_SESSION['error_access'])) {
    ?>
        <div class="user_form">
            <form action="#" method="post">
                <fieldset>
                    <legend>¡Entra al nido del troll!</legend>
                    <label for="user_name">Nombre de usuario o Email:</label><br>
                    <input
                        type="text"
                        name="user_name"
                        id="user_name"
                        value="<?= $_POST['user_name'] ?? '' ?>">
                    <?php
                    if (isset($errors['user']['user'])) {
                        echo '<span>' . $errors['user']['user'] . '</span>';
                    }
                    ?>
                    <br><br>
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password">
                    <?php
                    if (isset($errors['user']['pass'])) {
                        echo '<span>' . $errors['user']['pass'] . '</span>';
                    }
                    ?>
                    <br><br>
                    <input type="submit" value="Entra">
                </fieldset>
            </form>
        </div>
    <?php
    } else {

        echo '<div class="errors">';
        echo '<div>' . $_SESSION['error_access'] . '</div>';
        echo '</div>';
    }
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>