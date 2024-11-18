<?php

/**
 * Página para añadir o eliminar albumes de determinado grupo
 * para la aplicación de la actividad 'Discografia'
 * 
 * @author: Gustavo Víctor
 * @version: 1.0
 */

// Primero llamamos a las variables y luego a la conexión a la base de datos:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

// Hacemos el try catch:
try {

    // Primero establecemos la conexión:
    $connection = connectDB();

    // Hacemos un trim directamente:
    $_GET['id'] = trim($_GET['id']);

    // Si el formulario no está vacío gestionamos la petición:
    if (!empty($_GET)) {

        // Si el id enviado no es un int, enviamos al usuario al index:
        if (is_int($_GET['id'])) {

            // Preparamos la query porque los datos son introducidos por el usuario:
            $results = $connection->prepare(
                'SELECT 
                    g.id, 
                    g.name, 
                    g.photo AS "photo", 
                    a.title AS "title", 
                    a.year, 
                    a.price
                FROM 
                    groups g, albums a 
                WHERE 
                    a.group_id=g.id AND g.id= :group 
                ORDER BY 
                    a.title ASC;'
            );

            // Vinculamos la variable a la variable enviada para evitar SQL injection:
            $results->bindParam(':group', $_GET['id']);

            // Ejecutamos la query:
            $results->execute();

            // Lo guardamos en una variable como array de objetos:
            $groups = $results->fetch(PDO::FETCH_OBJ);

            if (!empty($_POST)) {

                switch($_POST['action']){
                    case 'cancel':
                        header('location:/groups?id='. $_GET['id']);
                        break;
                    case 'confirm':
                        // header();


                }

            }

        } else {
            header('location:/'); // Así enviamos al directorio raíz.
        }



    }
} catch (Exception $exc) {
    $errors[] = 'No se ha podido conectar a la base de datos';
}

// header('location:/'); // Para redireccionar al directorio raíz.





?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bangers&family=Kablammo&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/styles/style.css">
    <title>Groups</title>
</head>

<body>
    <?php
    require_once(
        $_SERVER['DOCUMENT_ROOT'] .
        '/includes/headerGustavoVictor.inc.php'
    );
    ?>

    <h2>Grupo:</h2><br>
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="error gold flex"><pre>' . $error . '</pre></div>';
        }
    }
    echo '<div class="group">';
    echo
    '<a class="gold flex" href="songs.php?search=' .
        $group->id .
        '">
		<img src="/img/grupos/' .
        $group->photo .
        '" alt="' .
        $group->photo .
        '">';
    echo '<h3>' .
        $group->name .
        '</h3></a>';
    echo '</div>';
    echo '</div>';

    ?>
    <footer class="flex">
        <small>Gustavo Víctor &copy; 2024</small>
    </footer>
</body>

</html>