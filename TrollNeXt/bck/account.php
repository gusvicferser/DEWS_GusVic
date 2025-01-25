<?php

/**
 * Aplicación web para mostrar los datos del usuario para poder modificarlos:
 * 
 *  1. Si recibe datos de este mismo formulario (y la contraseña es correcta), 
 *      los almacenará. 
 *      
 *     (HECHO)
 * 
 *  2. Mostrará un enlace a list y un enlace a cancel. 
 * 
 *     (HECHO)
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
    try {

        if (isset($_POST) && !empty($_POST)) {
            foreach ($_POST as $key => $element) {
                $_POST[$key] = trim($_POST[$key] ?? '');
            }

            $connection = connectDB();

            $query = $connection->query(
                'SELECT
                password
            FROM 
                users
            WHERE
                id=' . $_SESSION['user_id'] . ';'
            );

            $result = $query->fetchObject();

            // Verificamos si la contraseña actual es correcta y, si no, me vale
            // verga que quiere cambiarla:
            if (!password_verify($_POST['password'], $result->password)) {
                $errors['change']['password'] =
                    'La contraseña que ha puesto no es correcta';
            } else {

                if (
                    isset($_POST['new_user']) &&
                    ($_POST['new_user'] != $_SESSION['user_name'])
                ) {

                    if (preg_match(REGEXP_USERNAME, $_POST['new_user'])) {
                        /* Si la cumple, hay que asegurarse de que no haya dos emails 
                        iguales para evitar problemas de seguridad:*/
                        $query = $connection->prepare(
                            'SELECT 
                                user
                            FROM 
                                users
                            WHERE   
                                user = :user;'
                        );

                        $query->bindParam(':user', $_POST['new_user']);

                        $query->execute();

                        /* Si lo que nos devuelve da 1 fila o más, significa que
                        existe:*/
                        if ($query->rowCount() > 1) {
                            $errors['change']['user_name'] =
                                '¡Este nombre de usuario ya existe!';
                        } else {
                            $user_ok = true;
                        }
                    } else {
                        $user_ok = false;
                        $errors['change']['user'] =
                            'No es un nombre de usuario válido';
                    }
                }

                // Comprobamos que el email del usuario cumpla la reg_exp:
                if (
                    isset($_POST['new_email']) &&
                    ($_POST['new_email'] != $_SESSION['user_email'])
                ) {

                    if (preg_match(REGEXP_USERMAIL, $_POST['new_email'])) {
                        // Si la cumple, hay que asegurarse de que no haya dos emails 
                        // iguales para evitar problemas de seguridad:

                        $query = $connection->prepare(
                            'SELECT 
                                email
                            FROM 
                                users
                            WHERE   
                                email = :email;'
                        );

                        $query->bindParam(':email', $_POST['new_email']);

                        $query->execute();

                        // Si lo que nos devuelve da 1 fila o más, significa que existe:
                        if ($query->rowCount() > 1) {
                            $errors['change']['name_email'] =
                                'Este email ya ha sido registrado';
                        } else {
                            $email_ok = true;
                        }
                    } else {
                        $email_ok = false;
                        $errors['change']['mail'] = 'No es un email válido';
                    }
                }

                // Si cualquiera de las variables están seteadas, haremos un update:
                if (

                    (isset($user_ok) && $user_ok) ||
                    (isset($email_ok) && $email_ok)

                ) {

                    $new_user = $_POST['new_user'] ?? $_SESSION['user_name'];
                    $new_email = $_POST['new_email'] ?? $_SESSION['user_email'];

                    $query = $connection->prepare(
                        'UPDATE 
                            users
                        SET 
                            user = :update_user , email = :update_email 
                        WHERE 
                            id =' . $_SESSION['user_id'] . ';'
                    );

                    $query->bindParam(':update_user', $new_user);

                    $query->bindParam(':update_email', $new_email);

                    // Traza:
                    // echo '<pre>';
                    // print_r($query->debugDumpParams());
                    // echo '</pre>';

                    $query->execute();

                    // Damos feedback de si se ha podido actualizar o no:
                    if (isset($user_ok)) {
                        if ($query->rowCount() < 1) {
                            $errors['user_name'] =
                                'No se ha podido actualizar su nombre de usuario';
                        } else {
                            $success['user_name'] =
                                'Se ha actualizado su nombre de usuario';
                        }
                    }

                    if (isset($email_ok)) {
                        if ($query->rowCount() < 1) {
                            $errors['user_mail'] =
                                'No se ha podido actualizar su email';
                        } else {
                            $success['user_name'] =
                                'Se ha actulizado su email';
                        }
                    }

                    // Actualizamos nombre o email o no hacemos nada, según:
                    $_SESSION['user_name'] =
                        $_POST['new_user'] ?? $_SESSION['user_name'];
                    $_SESSION['user_email'] =
                        $_POST['new_email'] ?? $_SESSION['user_email'];
                }

                // Comprobamos que quiere cambiar la contraseña:
                if (isset($_POST['new_pass']) && !empty($_POST['new_pass'])) {

                    // Si no están ambas vacías, comprobamos que las contraseñas
                    // coincidan:
                    if (
                        isset($_POST['check_pass']) &&
                        !empty($_POST['check_pass']) &&
                        ($_POST['new_pass'] === $_POST['check_pass'])
                    ) {
                        $pass_check_ok = true;
                    } else {
                        $pass_check_ok = false;
                        $errors['change']['dual'] = '¡Las contraseñas no coinciden!';
                    }
                }

                // ¿Puedo poner esto? (P.D: Parece que sí)
                if ($pass_check_ok ?? false) {

                    $query = $connection->query(
                        'UPDATE 
                            users
                        SET 
                            password = "' .
                            password_hash($_POST['new_pass'], PASSWORD_DEFAULT) .
                            '" 
                        WHERE 
                            id =' . $_SESSION['user_id'] . ';'
                    );

                    if ($query->rowCount() > 0) {
                        $success['password'] = 'Se ha actualizado su contraseña';
                        // Regeneramos la sesión para que no puedan robar la cuenta:
                        session_regenerate_id(); // SUPER IMPORTANTE:

                    } else {
                        $errors['password'] =
                            'No se ha podido actualizar su contraseña';
                    }
                }
            }
            // Cortamos la conexión con la base de datos:
            unset($query);
            unset($connection);
            unset($_POST);
        }
    } catch (Exception $exc) {
        // $errors['account'] = 'No ha sido posible mostrar su información.';
        $errors['account'] = $exc;
    }
}

?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= CSS_LINK ?>
    <?= BOOT_LINK ?>
    <title>Cuenta de <?= $_SESSION['user_name'] ?></title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    
    //Traza:
    // echo '<pre>';
    // var_dump($_SESSION['user_fol']);
    // echo '</pre>';
    
    echo '<div class="container">';

    echo '<div class="row">';
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');

    echo '<div class="col-lg-6">';

    if (isset($_SESSION['errors']['delete_user'])) {
        echo '<div>' . $_SESSION['errors']['delete_user'] . '</div>';
    }

    if (isset($errors)) {
        echo '<div class="errors">';
        foreach ($errors as $key => $error) {
            if ($key != 'change') {
                echo '<div>' . $errors[$key] . '</div>';
            }
        }
        echo '</div>';
    }

    if (isset($success)) {
        echo '<div class="success">';
        foreach ($success as $element) {
            echo '<div>' . $element . '</div>';
        }
        echo '</div>';

        // Quitamos también los avisos de éxito:
        unset($_SESSION['success']);
    }

    ?>
    <br><br>
    <div>
        <a href="/list/">¿Quieres ver tus publicaciones?</a>
    </div>
    <br>
    <div>
        <a href="/cancel/">¿Quieres... quieres borrar tu cuenta?</a>
    </div>
    <br><br>
    <div>
        <form class="d-flex flex-column text-center p-4 justify-content-center" action="#" method="post">
                <legend>¿Quieres cambiar tu información?</legend>
                <br>
                <label for="new_user">Cambia tu nombre de usuario:</label>
                <input
                    type="text"
                    name="new_user"
                    id="new_user"
                    value="<?= $_SESSION['user_name'] ?>">
                <?php
                if (isset($errors['change']['user'])) {
                    echo '<span>' . $errors['change']['user'] . '</span>';
                }
                ?>
                <br>
                <label for="new_email">Cambia tu email:</label>
                <input
                    type="text"
                    name="new_email"
                    id="new_email"
                    value="<?= $_SESSION['user_email'] ?>">
                <?php
                if (isset($errors['change']['mail'])) {
                    echo '<span>' . $errors['change']['mail'] . '</span>';
                }
                ?>
                <br>
                <label for="new_pass">Cambia tu contraseña:</label>
                <input type="password" name="new_pass" id="new_pass">
                <br>
                <label for="check_pass">Repite tu nueva contraseña:</label>
                <input type="password" name="check_pass" id="check_pass">
                <?php
                if (isset($errors['change']['dual'])) {
                    echo '<span>' . $errors['change']['dual'] . '</span>';
                }
                ?>
                <br>
                <label for="password">Introduce tu contraseña actual:</label>
                <input type="password" name="password" id="password">
                <?php
                if (isset($errors['change']['password'])) {
                    echo '<span>' . $errors['change']['password'] . '</span>';
                }
                ?>
                <input class="m-4 p-4 btn btn-warning" type="submit" value="Actualiza">
        </form>
    </div>
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
    </div>
    </div>
</body>

</html>