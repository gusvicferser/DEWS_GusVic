<?php

/**
 * Ejercicio 3: Ha de mostrar un título con el texto "Añadir Personaje":
 * 
 * @author Gustavo Victor
 * @version 1.0
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/connectionGustavoVictor.inc.php');

try {

      if (
         !empty($_POST['name']) && $_POST['name'] != '' &&
         !empty($_POST['role']) && $_POST['role'] != '' &&
         !empty($_POST['anime']) && $_POST['anime'] != '' &&
         !empty($_POST['description']) && $_POST['description'] != '' &&
         !empty($_POST['age']) && $_POST['age'] != '' &&
         !empty($_POST['abilities'] && $_POST['abilities'] != '')
      ) {

         $connection = dbConnection();

         if ($connection != null) {

            $query = $connection->prepare(
               'INSERT INTO characters (name, role, anime, description, age, abilities) 
         VALUES (:name, :role, :anime, :description, :age, :abilities);'
            );

            $query->bindParam(':name', $_POST['name']);
            $query->bindParam(':role', $_POST['role']);
            $query->bindParam(':anime', $_POST['anime']);
            $query->bindParam(':description', $_POST['description']);
            $query->bindParam(':age', $_POST['age']);
            $query->bindParam(':abilities', $_POST['abilities']);

            $query->execute();

            $character = 'El héroe de nombre ' . $_POST['name'] . ', ' . $_POST['role'] . ' del anime ' . $_POST['anime'] . ' es ' . $_POST['description'] . ', tiene ' . $_POST['age'] . ' años de edad y posee las habilidades de ' . $_POST['abilities'] . '. Ha sido añadido correctamente.';

            unset($query);
            unset($connection);
         }
      } else {
         $errors[] = '¡Faltan datos!';
      }
} catch (Exception $exc) {
   $errors[] = $exc;
}
?>

<!DOCTYPE html>
<html lang="eS">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>EJERCICIO 3</title>
</head>

<body>

   <?php
   // Traza:
   // echo '<pre>';
   // var_dump($_POST);
   // echo '</pre>';

   if (!isset($errors) && empty($errors)) {
      echo '<div class="inserted">';
      echo '<h1>' . $character . '</h1>';
      echo '</div>';
      echo '<a href="/AddCharacterGustavoVictor.php">Vuelve al formulario</a>';
      
   } else {
      echo '<div class="errors">';
      foreach ($errors as $error) {
         echo '<div>';
         echo '<h2>' . $error . '</h2>';
         echo '</div>';
      }
      echo '</div>';

   ?>
      <form action="#" method="post">
         <fieldset>
            <legend>"AÑADIR PERSONAJE"</legend>
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>"><br><br>
            <label for="role">Rol:</label>
            <input type="text" name="role" id="role" value=" <?= $_POST['role'] ?? '' ?>"><br><br>
            <label for="anime">Anime:</label>
            <input type="text" name="anime" id="anime" value=" <?= $_POST['anime'] ?? '' ?>"><br><br>
            <label for="description">Descripción:</label>
            <input type="text" name="description" id="description" value=" <?= $_POST['description'] ?? '' ?>"><br><br>
            <label for="age">Edad:</label>
            <input type="text" name="age" id="age" value=" <?= $_POST['age'] ?? '' ?>"><br><br>
            <label for="abilities">Habilidades:</label>
            <input type="text" name="abilities" id="abilities" value=" <?= $_POST['abilities'] ?? '' ?>"><br><br>
            <input type="submit" value="Envía">
         </fieldset>
      </form>
   <?php
   }
   ?>
</body>

</html>