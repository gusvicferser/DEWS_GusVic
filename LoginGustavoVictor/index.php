<?php

/**
 * Ejercicio de Login para loggear a un usuario con usuario, password y lista de usuarios a parte:
 * 
 * @author: Gustavo Víctor
 * @version: 1.3
 */

// Requerimos la página con la lista de los users:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/userList.inc.php');

// Si el array no está vacío, comprobamos:
if (!empty($_POST)) {

    // Primero de todo hacemos un trim de user y password y lo guardamos 
    // en el mismo lugar, para no tener que estar cambiándolo todo el rato:
    $_POST['user'] = trim($_POST['user']);
    $_POST['password'] = trim($_POST['password']);

    // Guardamos el objeto usuario (si existe, si no es null) para usarlo más adelante:
    $userTry = userExists($_POST['user'], $users);

    // Si el usuario no es 'null', entonces comprobamos la contraseña:
    if ($userTry != null) {

        if (!$userTry->login($_POST['password'])) {
            $error = 'La contraseña no es correcta'; // Mensaje de error
        }
    // Si el usuario tiene una longitud de 0, mandamos otro mensaje de error personalizado:
    } else if(strlen($_POST['user'])==0) {
        $error = 'Ha de introducir primero un usuario';
    } 
    // En cualquier otro caso, el usuario no existe:
    else {
        $error = 'El usuario no existe';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede a la web</title>
</head>

<body>

    <?php
    if (!empty($_POST) && empty($error)) {
        echo '<div class="correcto">';
        echo '<h1>Login Correcto</h1>';
        echo '<p>' . $userTry->toString() . '</p>';
        echo '<a href="index.php" target="__self">Volver</a>';
        echo '</div>';
    } else {

        // Traza:
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($errors);
        // echo '</pre>';

        // Un bucle for para recorrer y mostrar los errores en caso de que los haya:
        if (!empty($error)) {
            echo '<div class="errors">';
            echo '<div>' . $error . '</div>';
            echo '</div>';
        }
    ?>

        <form action="#" method="post">
            <fieldset>
                <legend>
                    <h1>¡Loggeate!</h1>
                </legend>
                <label for="user">User</label><br>
                <input type="text" name="user" value="<?= $_POST['user'] ?? '' ?>"><br>
                <label for="password">Password</label><br>
                <input type="text" name="password" value="<?= $_POST['password'] ?? '' ?>"><br><br>
                <input type="submit" value="Acceder">
            </fieldset>
        </form>
    <?php
    }
    ?>


</body>

</html>