<?php

/**
 * Aplicación modificada para poder loguearse:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 1.3 (Corregido después de enviarlo)
 */

// Sesión (hacemos los cambios en la cookie e iniciamos sesión):
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Si llegan datos del formulario hay que intentar hacer el login
if (!empty($_POST)) {
    // Se eliminan los espacios delante y detrás de los campos recibidos
    foreach ($_POST as $key => $value)
        $_POST[$key] = trim($value);

    // Si el campo está vacío se añade un elemento al array $errors[]
    if (empty($_POST['user']))
        $errors['user'] = 'El usuario no puede estar en blanco.';
    if (empty($_POST['password']))
        $errors['password'] = 'La contraseña no puede estar en blanco.';

    if (!isset($errors)) {
        try {
            // Si no hay errores se procede a comprobar las credenciales
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
            if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
                // Se accede obtienen los datos del usuario desde la base de datos
                $query = $connection->prepare(
                    'SELECT 
                        user, rol, password 
                    FROM 
                        users 
                    WHERE 
                        (user=:user OR email=:mail);');

                $query->bindParam(':user', $_POST['user']);
                $query->bindParam(':mail', $_POST['user']);
                $result = $query->execute();

                // Comprobaciones para el login
                if ($result !== false) {
                    $errors['login'] = 'Error en el acceso';
                } else {

                    // Existe solo un usuario que coincide para realizar el login:
                    $user = $query->fetchObject();

                    // Se comprueba si la contraseña es correcta
                    // Si es correcta se almacenan los datos del usuario en la 
                    // sesión y se redirige a index
                    if (password_verify($_POST['password'], $user->password)) {

                        // Regeneramos la sesión para que no puedan robar la cuenta:
                        session_regenerate_id(); // SUPER IMPORTANTE:
                        $_SESSION['userName'] = $user->user;
                        $_SESSION['rol'] = $user->rol;

                        unset($query);
                        unset($connection);
                        header('location: /');
                        exit;
                    } else {
                        // Si es incorrecto se almacena el error para mostrarlo 
                        // en el body:
                        $errors['password'] = 'Contraseña incorrecta';

                    }
                }
            } else {
                throw new Exception('Error en la conexión a la BBDD');
            }
        } catch (Exception $e) {
            $errors['login'] = 'Error en el acceso';
        }
        unset($query);
        unset($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop - Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>
    <div class="loginContainer">
        <h2>Accede a la aplicación</h2>

        <?php
        if (isset($_GET['signup']) && $_GET['signup'] == 1) {
            echo '<h3>';
            echo 
                'Se ha registrado correctamente ya puede acceder a la aplicación.';
            echo '</h3>';
        } else {
            echo 
                isset($errors['login']) ? 
                    '<h3>Error en el acceso, inténtelo más tarde.</h3>' : '';
        ?>

            <form action="#" method="post">
                <label for="user">Usuario o mail</label>
                <input 
                    type="text" 
                    name="user" 
                    id="user" 
                    placeholder="usuario o mail" 
                    value="<?= $_POST['user'] ?? "" ?>"
                >
                <br>
                <?= isset($errors['user']) ? 
                    '<span class="error">' . $errors['user'] . '</span>' : "" ?>
                <br>
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    value="<?= $_POST['password'] ?? "" ?>"
                >
                <br>
                <?= isset($errors['password']) ? 
                    '<span class="error">' . $errors['password'] . '</span>' : "" ?>
                <br>
                <!-- <label></label>
                <input type="checkbox" name="autologin" id="autologin">
                <label for="autologin">Recordarme</label>
                <br> -->
                <label></label>
                <input type="submit" value="Accede">
            </form>
        <?php
        }
        ?>
    </div>
</body>

</html>