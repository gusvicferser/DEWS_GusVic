<?php

/**
 * Aplicación web para loguearse en la red social. Requiere:
 * 
 * 1. Si no recibe datos, muestra formulario para autenticarse. Datos se envían a 
 *      la propia página (#).
 * 
 * 2. Si recibe datos, trata de hacer el login.
 * 
 * 3. En caso de error, se devuelve al formulario con los datos cumplimentados y
 *      un mensaje que diga que error se muestra. 
 * 
 * 4. Si los datos son correctos, se redirige a index.
 * 
 * @author Gustavo Víctor
 * @version 1.1
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

// Si ya tiene la sesión iniciada, no tiene sentido que acceda a login:
if (!isset($_SESSION['user_name'])) {

    header('location:/');
    exit;
} else {

    try {

        if (isset($_POST['user_name'])) {

            // Importante hacerle trim a todo lo que envíe el usuario:
            $_POST['user_name'] = trim($_POST['user_name']);

            $connection = connectDB();

            $query = $connection->prepare(
                'SELECT 
                    u.id AS user_id,
                    u.user AS user_name,
                    u.password AS user_pass
                FROM 
                    users u
                WHERE 
                    u.user = :user OR u.user = :mail;'
            );

            $query->bindParam(':user', $_POST['user_name']);
            $query->bindParam(':mail', $_POST['user_name']);

            $result = $query->execute();

            // Comprobaciones para el login
            if ($result !== false) {
                
                $errors['login'] = 'Error en el acceso';

            } else {
                $user = $query->fetchObject();

                if (password_verify($_POST['password'], $user->user_pass)) {

                    // Regeneramos la sesión para que no puedan robar la cuenta:
                    session_regenerate_id(); // SUPER IMPORTANTE:
                    $_SESSION['user_name'] = $user->user_name;
                    $_SESSION['id'] = $user->user_id;

                    unset($query);
                    unset($connection);
                    header('location: /');
                    exit;
                } else {

                    // Si es incorrecto se almacena el error para mostrarlo en el body:
                    $errors['password'] = 'Contraseña incorrecta';
                }
            }
        }
    } catch (Exception $exc) {
        $errors['login'] = 'No fue posible hacer el login';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>