<?php

/**
 * Aplicación web para mostrar los datos del usuario para poder modificarlos:
 * 
 *  1. Si recibe datos de este mismo formulario, los almacenará.
 * 
 *  2. Mostrará un enlace a list y un enlace a cancel.
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
    try {


        // Si están seteados cualquiera de estos campos comprobamos:
        if (
            isset($_POST['new_email']) ||
            isset($_POST['new_pass']) ||
            isset($_POST['pass_check'])
        ) {

            $connection = connectDB();

            // Comprobamos que el email del usuario cumpla la reg_exp:
            if (
                isset($_POST['new_email']) &&
                preg_match(REGEXP_USERMAIL, $_POST['new_email'])
            ) {
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
                    $update_mail = 'email = ' . $_POST['new_email'];
                }
            } else {
                $email_ok = false;
                $errors['change']['mail'] = 'No es un email válido';
            }

            // Comprobamos que la nueva contraseña no esté vacía:
            if (isset($_POST['new_pass']) && !empty($_POST['new_pass'])) {
                
                // Si no están ambas vacías, comprobamos que las contraseñas coincidan:
                if (
                    isset($_POST['check_pass']) &&
                    !empty($_POST['check_pass']) &&
                    ($_POST['new_pass'] === $_POST['check_pass'])
                ) {
                    $pass_check_ok = true;
                    $update_pass =
                        'password = ' .
                        password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
                } else {
                    $pass_check_ok = false;
                    $errors['change']['dual'] = '¡Las contraseñas no coinciden!';
                }
            }
            // Si cualquiera de las variables están seteadas, haremos un update:
            if ($email_ok || $pass_check_ok) {
                /* El caso límite o de ruptura es cuando ambos updates se van a 
                hacer al mismo tiempo. Para realizar tan solo una consulta, hemos
                de unirlas en un string. De lo contrario, me sirve cualquiera
                que no sea nula (no pasaría por este if si ninguna estuviera
                seteada):*/
                if (isset($update_mail) && isset($update_pass)) {

                // Si no existe, pasamos a actualizarlo:
                $query = $connection->prepare(
                    'UPDATE 
                            users
                        SET 
                            :update_mail , :update_pass 
                        WHERE 
                            id =' . $_SESSION['user_id'] . ';'
                );

                $query->bindParam(':update_mail', $update_mail); // SEGUIR
                
                echo '<pre>';
                print_r($query->debugDumpParams());
                echo '</pre>';

                $query->execute();
        
                } else {
                    $update = $update_mail ?? $update_pass ?? '';
                }



                if (strpos($update, 'email') > 0) {
                    $success = 'Su email ha sido actualizado';
                    $_SESSION['user_email'] = $_POST['new_email'];
                } else {
                    $success = 'Su contraseña ha sido actualizada';
                }
            }
            // Cortamos la conexión con la base de datos:
            unset($query);
            unset($connection);
        }
    } catch (Exception $exc) {
        // $errors['account'] = 'No ha sido posible mostrar su información.';
        $errors['account'] = $exc;
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta de <?= $_SESSION['user_name'] ?></title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

    //Traza:
    // echo '<pre>';
    // var_dump($_SESSION['user_fol']);
    // echo '</pre>';


    if (isset($errors['account'])) {
        echo '<div class="errors">';
        echo '<div>' . $errors['account'] . '</div>';
        echo '</div>';
    }


    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');
    ?>
    <br><br>
    <div>
        <a href="/bck/list/">¿Quieres ver tus publicaciones?</a>
    </div>
    <br>
    <div>
        <a href="/bck/cancel/">¿Quieres... quieres borrar tu cuenta?</a>
    </div>
    <br><br>
    <div class="change_form">
        <form action="#" method="post">
            <fieldset>
                <legend>¿Quieres cambiar tu información?</legend>
                <label for="new_user">Cambia tu nombre de usuario:</label><br>
                <input
                    type="text"
                    name="new_user"
                    id="new_user"
                    value="<?= $_SESSION['user_name']?>">
                <?php
                if (isset($errors['change']['user'])) {
                    echo '<span>' . $errors['change']['user'] . '</span>';
                }
                ?>
                <br><br>
                <label for="new_email">Cambia tu email:</label><br>
                <input
                    type="text"
                    name="new_email"
                    id="new_email"
                    value="<?=$_SESSION['user_email']?>">
                <?php
                if (isset($errors['change']['mail'])) {
                    echo '<span>' . $errors['change']['mail'] . '</span>';
                }
                ?>
                <br><br>
                <label for="new_pass">Cambia tu contraseña:</label><br>
                <input type="password" name="new_pass" id="new_pass">
                <?php
                if (isset($errors['change']['pass'])) {
                    echo '<span>' . $errors['change']['pass'] . '</span>';
                }
                ?>
                <br><br>
                <label for="check_pass">Repite tu nueva contraseña:</label><br>
                <input type="password" name="check_pass" id="check_pass">
                <?php
                if (isset($errors['change']['dual'])) {
                    echo '<span>' . $errors['change']['dual'] . '</span>';
                }
                ?>
                <br><br>
                <input type="submit" value="Actualiza">
            </fieldset>
        </form>
    </div>
</body>

</html>