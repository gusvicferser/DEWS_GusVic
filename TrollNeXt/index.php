<?php

/**
 * Aplicación web para el índice de la red social. Ha de cumplir:
 * 
 * 1. Si no está logueado, mensaje de bienvenida y de invitación a registrarse.
 * 
 * 2. Mostrará el formulario de registro que envía datos al propio index (#).
 * 
 * 3. 
 *    3.1 Si está logueado, mostrará el tablón de anuncios con todas las 
 *        publicaciones de los usuarios en orden cronológico (desc).
 *  
 *    3.2 Estas publicaciones tendrán el texto y será un enlace a la página entry. 
 * 
 *    3.3 El autor con un enlace a la página user.
 * 
 *    3.4 Imágenes para indicar si gusta o no y el número de comentarios de una
 *        publicación.
 * 
 * @author Gustavo Víctor
 * @version 1.2
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

if (!isset($_SESSION['user_name'])) {
   try {

      foreach ($_POST as $key => $element) {
         $_POST[$key] = trim($_POST[$key]);
      }

      if (isset($_POST['new_user'])) {

         // Comprobamos que el nombre del nuevo usuario cumpla la reg_exp:
         if (
            isset($_POST['new_user']) &&
            preg_match(REGEXP_USERNAME, $_POST['new_user'])
         ) {
            $user_ok = true;
         } else {
            $user_ok = false;
            $errors['new_user']['user'] = 'No es un nombre de usuario válido';
         }

         // Comprobamos que el email del usuario cumpla la reg_exp:
         if (
            isset($_POST['new_email']) &&
            preg_match(REGEXP_USERMAIL, $_POST['new_email'])
         ) {
            $email_ok = true;
         } else {
            $email_ok = false;
            $errors['new_user']['mail'] = 'No es un email válido';
         }

         if (isset($_POST['new_pass']) && empty($_POST['new_pass'])) {
            $errors['new_user']['pass'] =
               '¡La contraseña no puede estar vacía!';
            $pass_check_ok = false;
         } else {
            // Comprobamos que las contraseñas coincidan:
            if (
               isset($_POST['check_pass']) &&
               !empty($_POST['check_pass']) &&
               ($_POST['new_pass'] === $_POST['check_pass'])
            ) {
               $pass_check_ok = true;
            } else {
               $pass_check_ok = false;
               $errors['new_user']['dual'] = '¡Las contraseñas no coinciden!';
            }
         }

         // Si las tres cosas están bien, se procede a registrarlo:
         if ($user_ok && $email_ok && $pass_check_ok) {

            $connection = connectDB();

            $query = $connection->prepare(
               'SELECT 
              user, email
          FROM 
              users
          WHERE   
              user = :new_user OR email = :email;'
            );

            $query->bindParam(':new_user', $_POST['new_user']);
            $query->bindParam(':email', $_POST['new_email']);

            $query->execute();

            // Si lo que nos devuelve da 1 fila o más, significa que existe:
            if ($query->rowCount() > 1) {

               $errors['new_user']['name_email'] =
                  'Nombre de usuario o email ya registrado';
            } else {
               // Si no existe, pasamos a registrarlo:
               $query = $connection->prepare(
                  'INSERT INTO 
                      users (user, password, email)
                  VALUES (
                      :user, "' .
                     password_hash(
                        $_POST['new_pass'],
                        PASSWORD_DEFAULT
                     ) .
                     '", :email);'
               );

               $query->bindParam(':user', $_POST['new_user']);
               $query->bindParam(':email', $_POST['new_email']);

               $query->execute();

               // Si lo ha registrado correctamente, entonces guardamos su id
               if ($query->rowCount() === 1) {

                  $id_query = $connection->query(
                     'SELECT 
                          id
                      FROM 
                          users
                      WHERE
                          user="' . $_POST['new_user'] . '";'
                  );

                  $id = $id_query->fetch();

                  // Seteamos el login:
                  $_SESSION['user_name'] = $_POST['new_user'];
                  $_SESSION['user_id'] = $id->id;

                  // Regeneramos el id de la sesión:
                  session_regenerate_id();

                  /* Cortamos conexión con la base de datos y devolvemos
                  al index:*/
                  unset($query);
                  unset($connection);
                  header('location:/');
                  exit;
               } else {
                  $errors['add_db'] =
                     'No se pudo registrar correctamente, 
                      pruebe de nuevo.';
               }
            }
         }

         // Cerramos las conexiones:
         unset($query);
         unset($connection);
      }
   } catch (Exception $exc) {
      // $errors['login'] = 'No fue posible hacer el login';
      $errors['login'] = $exc;
   }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TrollNeXt</title>
</head>

<body>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
   
   if (!isset($_SESSION['user_name'])) {
      ?>
      <div class="new_user_form">
         <form action="#" method="post">
            <fieldset>
               <legend>¡Regístrate y entra al nido del troll!</legend>
               <label for="new_user">Nombre de usuario</label><br>
               <input
               type="text"
               name="new_user"
               id="new_user"
               value="<?= $_POST['new_user'] ?? '' ?>">
               <?php
                if (isset($errors['new_user']['user'])) {
                   echo '<span>' . $errors['new_user']['user'] . '</span>';
                  }
                  ?>
                <br><br>
                <label for="new_email">Email</label><br>
                <input
                type="text"
                name="new_email"
                id="new_email"
                value="<?= $_POST['new_email'] ?? '' ?>">
                <?php
                if (isset($errors['new_user']['mail'])) {
                   echo '<span>' . $errors['new_user']['mail'] . '</span>';
                  }
                  ?>
                <br><br>
                <label for="new_pass">Contraseña</label><br>
                <input type="password" name="new_pass" id="new_pass">
                <?php
                if (isset($errors['new_user']['pass'])) {
                   echo '<span>' . $errors['new_user']['pass'] . '</span>';
                  }
                  ?>
                <br><br>
                <label for="check_pass">Repita su contraseña</label><br>
                <input type="password" name="check_pass" id="check_pass">
                <?php
                if (isset($errors['new_user']['dual'])) {
                   echo '<span>' . $errors['new_user']['dual'] . '</span>';
                  }
                  ?>
                <br><br>
                <input type="submit" value="Entra">
               </fieldset>
            </form>
         </div>
         <?php
   } else {
      require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');    
   }
   ?>
   <br><br>
   <a href="/author.php">Author</a>
   <a href="/close.php">Close</a>
   <a href="/comment.php">Comment</a>
   <a href="/entry.php">Entry</a>
   <a href="/login.php">Login</a>
   <a href="/new.php">New</a>
   <a href="/results.php">Results</a>
   <a href="/bck/account.php">Account</a>
   <a href="/bck/cancel.php">Cancel</a>
   <a href="/bck/delete.php">Delete</a>
   <a href="/bck/list.php">List</a>
   <br><br>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
   ?>
</body>

</html>