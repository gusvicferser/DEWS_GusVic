<?php

/**
 * Aplicación web para el índice de la red social. Ha de cumplir:
 * 
 * 1. Si no está logueado, mensaje de bienvenida y de invitación a registrarse.
 * 
 * (HECHO)
 * 
 * 2. Mostrará el formulario de registro que envía datos al propio index (#).
 * 
 * (HECHO)
 * 
 * 3. 
 *    3.1 Si está logueado, mostrará el tablón de anuncios con todas las 
 *        publicaciones de los usuarios en orden cronológico (desc). 
 * 
 *       (HECHO)
 *  
 *    3.2 Estas publicaciones tendrán el texto y será un enlace a la página entry. 
 *       (HECHO)
 * 
 *    3.3 El autor con un enlace a la página user.
 *       (HECHO)
 * 
 *    3.4 Imágenes para indicar si gusta o no y el número de comentarios de una
 *        publicación.
 *       (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.7
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Hemos de traer las variables y las conexiones:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connectDB.inc.php');

if (!isset($_SESSION['user_name'])) {
   try {

      foreach ($_POST as $key => $element) {
         $_POST[$key] = trim($_POST[$key] ?? '');
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
            // Mod. 1.7 => faltaba el "="
            if ($query->rowCount() >= 1) {

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

                  $id = $id_query->fetchObject();

                  // Seteamos el login:
                  $_SESSION['user_name'] = $_POST['new_user'];
                  $_SESSION['user_id'] = $id->id;
                  $_SESSION['user_email'] = $_POST['new_email'];

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
      $errors['login'] = 'No fue posible hacer el login';
      //   $errors['login'] = $exc;
   }
   // Ahora vamos a ver qué puede ver el usuario si está conectado:
} else {

   try {
      // Vamos a hacer una query para ver todas las publicaciones tanto suyas:
      $search =
         'SELECT 
         u.user AS user,
         u.id AS u_id,  
         e.text AS entry,
         e.id AS e_id,  
         (
            SELECT 
               COUNT(l.user_id) 
            FROM 
               likes l, entries e2 
            WHERE 
               l.entry_id = e2.id AND e2.id=e.id
         ) AS likes, 
         (
            SELECT 
               COUNT(d.user_id) 
            FROM 
               dislikes d, entries e3 
            WHERE 
               d.entry_id = e3.id AND e3.id = e.id
         ) AS dislikes,
         (
            SELECT 
               COUNT(c.entry_id)
            FROM 
               comments c, entries e4
            WHERE
               c.entry_id = e4.id AND e4.id = e.id
         ) AS comments,
         (
            SELECT 
               COUNT(l.user_id) 
            FROM 
               likes l, entries e5 
            WHERE 
               l.entry_id = e5.id AND 
               e5.id=e.id AND 
               l.user_id = ' . $_SESSION['user_id'] . ') AS liked
      FROM 
         users u, entries e 
      WHERE
         (u.id = e.user_id AND u.id=' . $_SESSION['user_id'] . ')';

      // Como de las personas a las que sigue, añadiendo un OR por cada una:
      if (isset($_SESSION['user_fol'])) {
         foreach ($_SESSION['user_fol'] as $key => $follower) {
            $search =
               $search .
               ' OR (u.id = e.user_id AND u.id=' .
               $_SESSION['user_fol'][$key]->fol_id .
               ')';
         }
      }

      $search = $search . ' ORDER BY e.date DESC;';

      // var_dump($search); // Traza

      $connection = connectDB();

      $query = $connection->query($search);

      $posts = $query->fetchAll(PDO::FETCH_OBJ);

      // Quitamos todas las variables que ya no necesitamos:
      unset($search);
      unset($query);
      unset($connection);
   } catch (Exception $exc) {
      $errors['followers'] =
         'No se han podido encontrar publicaciones de las cuentas a las que sigues.';
   }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= CSS_LINK ?>
   <?= BOOT_LINK ?>
   <title>TrollNeXt</title>
</head>

<body>
   <?php

   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

   //Traza:
   // echo '<pre>';
   // var_dump($_SESSION['user_fol']);
   // echo '</pre>';

   echo '<div class="container">';

   if (!isset($_SESSION['user_name'])) {
   ?>
      <div class="d-flex flex-column text-secondary text-center pt-3 mt-3">
         <h1>Bienvenido a TrollNeXt</h1>
         <h2>donde el siguiente en ser trolleado podrías ser tú</h2>
      </div>

      <?php
      // Modificación de la 1.7
      echo '<div class="col-lg-3><div>;';
      echo '<div class="col-lg-6 posts">';
      if (isset($errors['new_user']['name_email'])) {
         echo '<div class="d-flex justify-content-center bg-danger p-3 m-3 rounded-pill">';

         echo '<div>' . $errors['new_user']['name_email'] . '</div>';

         echo '</div>';
      }
      // fin de la modificación.

      ?>
      <div class="row d-flex justify-content-center">
         <div class="col-lg-6 d-flex flex-column justify-content-center p-3 m-3">

            <div class="container-fluid">
               <form class="form-group mx-auto rounded-4 login" action="#" method="post">
                  <div class="m-2 p-5">
                     <h2 class="text-center text-warning">¡¡Regístrate y entra al nido del troll!!</h2>
                     <label for="new_user" class="form-label text-warning fw-semibold mt-5">Nombre de usuario</label><br>
                     <input
                        type="text"
                        name="new_user"
                        id="new_user"
                        class="form-control"
                        value="<?= $_POST['new_user'] ?? '' ?>">
                     <?php
                     if (isset($errors['new_user']['user'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['new_user']['user'] . '</span></span>';
                     }
                     ?>
                     <label class="form-label text-warning fw-semibold mt-3" for="new_email">Email</label><br>
                     <input
                        type="text"
                        name="new_email"
                        id="new_email"
                        class="form-control"
                        value="<?= $_POST['new_email'] ?? '' ?>">
                     <?php
                     if (isset($errors['new_user']['mail'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['new_user']['mail'] . '</span></span>';
                     }
                     ?>
                     <label class="form-label text-warning fw-semibold mt-3" for="new_pass">Contraseña</label><br>
                     <input type="password" class="form-control" name="new_pass" id="new_pass">
                     <?php
                     if (isset($errors['new_user']['pass'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['new_user']['pass'] . '</span></span>';
                     }
                     ?>
                     <label class="form-label text-warning fw-semibold mt-3" for="check_pass">Repita su contraseña</label><br>
                     <input type="password" class="form-control" name="check_pass" id="check_pass">
                     <?php
                     if (isset($errors['new_user']['dual'])) {
                        echo '<span class="d-flex justify-content-center text-warning fw-bold"><span>' . $errors['new_user']['dual'] . '</span></span>';
                     }
                     ?>

                     <input class="form-control rounded-3 p-2 mt-5 btn btn-outline-warning border-0" type="submit" value="Regístrate">
                  </div>
               </form>
            </div>
         </div>
      </div>

      <?php
   } else {
      echo '<div class="row">';
      require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/latscroll.inc.php');

      echo '<div class="col-lg-6 posts">';
      if (isset($errors)) {
         echo '<div class="d-flex justify-content-center bg-danger p-3 m-3 rounded-pill">';
         foreach ($errors as $key => $error) {
            if ($key != 'new_user') {
               echo '<div>' . $errors[$key] . '</div>';
            }
         }
         echo '</div>';
      }

      if (isset($_SESSION['errors'])) {
         echo '<div class="d-flex justify-content-center bg-danger p-3 m-3 rounded-pill">';
         foreach ($_SESSION['errors'] as $key => $error) {
            echo '<div>' . $_SESSION['errors'][$key] . '</div>';
         }
         echo '</div>';

         // Luego para quitar los errores, una vez mostrados, los eliminamos:
         unset($_SESSION['errors']);
      }

      if (isset($_SESSION['success'])) {
         echo '<div class="d-flex justify-content-center bg-success p-3 m-3 rounded-pill">';
         echo '<div>' . $_SESSION['success'] . '</div>';
         echo '</div>';

         // Quitamos también los avisos de éxito:
         unset($_SESSION['success']);
      }

      if (isset($posts)) {

         echo '<div class="d-flex flex-column justify-content-center">';
         foreach ($posts as $post) {
            echo '<div class="d-flex flex-column p-4">';

            echo '<div class="p-3">';
            echo '<a href="entry/' . $post->e_id . '">' . $post->entry . '</a>';
            echo '</div>';

            echo '<div class="text-center">';
            echo '<a href="user/' . $post->u_id . '">' . $post->user . '</a>';
            echo '</div>';


            echo '<div class="d-flex justify-content-evenly align-items-center p-3">';
            echo '<span>Likes: ' . $post->likes . ' </span>';

            echo '<span>Dislikes: ' . $post->dislikes . ' </span>';

            echo '<span>';
            echo '<a href="/like/' . $post->e_id . '">';
            if ($post->liked > 0) {
               echo '<img src="img/dislike.png" alt="dislike" width="50px"></a>';
            } else {
               echo '<img src="img/like.png" alt="like" width="50px"></a>';
            }
            echo ' </span>';
            echo '</div>';

            echo '<span class="d-flex justify-content-center px-5">Comentarios: ' . $post->comments . ' </span>';
            echo '</div>';
         }
         echo '</div>';
      } else {
      ?>
         <div class="col-lg-6 posts">
            <div class="post">
               <h2>¡No hay post en tu feed porque no sigues a nadie!</h2>
            </div>

         </div>
   <?php
      }
      echo '</div>';
   }

   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
   ?>
   </div>
</body>

</html>