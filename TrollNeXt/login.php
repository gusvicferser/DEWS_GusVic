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
    <?= CSS_LINK ?>
    <?= BOOT_LINK ?>
    <title>Loguéate</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    echo '<div class="container">';

    echo '<div class="row d-flex justify-content-center">';

    echo '<div class="col-lg-6">';

    if (isset($errors)) {
        echo '<div class="d-flex justify-content-center bg-danger p-3 m-3 text-warning rounded-pill">';
        foreach ($errors as $key => $error) {
            if ($key != 'user') {
                echo '<div>' . $errors[$key] . '</div>';
            }
        }
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';

    echo '<div class="row d-flex justify-content-center">';
    echo 
        '<div class="col-lg-6 d-flex flex-column justify-content-center p-3 m-3">';
    if (!isset($_SESSION['error_access'])) {
    ?>
        <div class="container-fluid">
            <form class="form-group mx-auto rounded-4 login" action="#" method="post">
                <div class="m-2 p-5">
                    <h2 class="text-center text-warning">¡Entra al nido!</h2>
                    <label for="user_name" class="form-label text-warning fw-semibold mt-5">User o Email</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="'troll021' o 'name@example.com'" value="<?= $_POST['user_name'] ?? '' ?>">
                    <?php
                    if (isset($errors['user']['user'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['user']['user'] . '</span></span>';
                    }
                    ?>
                    <label for="password" class="form-label text-warning fw-semibold mt-3">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php
                    if (isset($errors['user']['pass'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['user']['pass'] . '</span></span>';
                    }
                    ?>
                    <input class="form-control rounded-3 p-2 mt-5 btn btn-outline-warning border-0" type="submit" value="Entra">
                </div>
            </form>
        </div>
        </div>
        </div>
    <?php
    } else {
    ?>
        <div class="errors">
            <div><?= $_SESSION['error_access'] ?></div>
        </div>
    <?php
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>

</body>

</html>