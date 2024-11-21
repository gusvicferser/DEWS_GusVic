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
        if (is_int(intval($_GET['id']))) {

             // Preparamos la query porque los datos son introducidos por el usuario:
             $query = $connection->prepare(
                'SELECT 
                    id, 
                    name, 
                    photo
                FROM 
                    groups
                WHERE 
                    id= :group ;'
            );

            // Vinculamos la variable a la variable enviada para evitar SQL injection:
            $query->bindParam(':group', $_GET['id']);

            // Ejecutamos la query:
            $query->execute();

            // Lo guardo como objeto en una variable para el grupo:
            $group = $query->fetchObject();

            // Preparamos la siguiente query porque los datos siguen siendo introducidos por el usuario:
            $query = $connection->prepare(
                'SELECT  
                    title, 
                    year, 
                    price
                FROM 
                    albums
                WHERE 
                    group_id = :group 
                ORDER BY 
                    title ASC;'
            );

            // Vinculamos la variable a la variable enviada para evitar SQL injection:
            $query->bindParam(':group', $_GET['id']);

            // Ejecutamos la query:
            $query->execute();

            // Lo guardamos en una variable como array de objetos:
            $albums = $query->fetchAll(PDO::FETCH_OBJ);

            // Quitamos la conexión de la base de datos al no saber si continuaremos:
            unset($query);
            unset($connection);

            // Si la acción no está vacía:
            if (!empty($_GET['action'])) {

                // Un swith para los casos, en lugar de un if else:
                switch ($_GET['action']) {
                    case 'confirm':
                        $confirm = true;
                        break;
                    case 'delete':
                        // Debemos volver a conectar si entramos por aquí:
                        $connection = connectDB();

                        // Preparamos la query:
                        $query = $connection->query(
                            'DELETE FROM albums 
                                WHERE title = :album ;');

                        // Hay que vincular la consulta con un bindParam():
                        $query->bindParam(':album', $_GET['id']);

                        // Ejecutamos la query:
                        $query->execute();

                        // Para la confirmación:
                        $deleted = true;       
                }
            }
        } else {
            header('location:/'); // Así enviamos al directorio raíz.
        }
    }
} catch (Exception $exc) {
    $errors[] = 'No se ha podido conectar a la base de datos';
}

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

    <h2>Grupos:</h2><br>
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="error gold flex"><pre>' . $error . '</pre></div>';
        }
    }

    if (isset($deleted) && $deleted) {
        echo '<div class="confirmation gold flex">';
        echo '<h3>El album ha sido borrado con éxito</h3>';
        echo '</div>';
    }

    if (isset($confirm) && $confirm) {
       echo '<div class="error gold flex">';
       echo '<h3>Está a punto de borrar este álbum, ¿está seguro?</h3>';
       echo '
        <a href="/groups.php?id=' . $_GET['id'] .'">
        <button type="button">Cancelar</button></a>';
       echo '
        <a href="/groups.php?id=' . $_GET['id'] . '&action=delete">
        <button type="button">Confirmar</button>
        </a>';
       echo '</div>';
    }

    echo '<div class="group">';
    echo
    '<div class="gold flex">
		<img src="/img/grupos/' .
        $group->photo .
        '" alt="' .
        $group->photo .
        '">';
    echo '<h3>' .
        $group->name .
        '</h3>';
    ?>
    </div>
    <div class="albums flex">
        <table>
            <thead class="gold">
                <tr>
                    <th>Título</th>
                    <th>Año</th>
                    <th>Precio</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($albums as $album) {
                    echo '<tr>';
                    echo '<td>' . $album->title . '</td>';
                    echo '<td>' . $album->year . '</td>';
                    echo '<td>' . $album->price . ' €</td>';
                    echo '<td>
                        <a href="localhost/groups.php?id=' .
                        $_GET['id'] . 
                        '&album=' . 
                        $album->title .
                        '&action=confirm">
                        <img src="/img/papelera.png" alt="erase">
                        </a>
                        </td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <form class="flex" action="#" method="post" enctype="multipart/form-data">
        <legend>AÑADE UN ALBUM</legend>
        <fieldset>
            <label for="title">Título:</label><br>
            <input type="text" name="title" id="title"><br>
            <label for="year">Año:</label><br>
            <input type="text" name="year" id="year"><br>
            <label for="format">Formato:</label><br>
            <select name="format" id="format">
                <option value="cd">CD</option>
                <option value="dvd">DVD</option>
                <option value="mp3">MP3</option>
                <option value="vynil">Vinilo</option>
            </select><br>
            <label for="buyDate">Fecha de adquisición:</label><br>
            <input type="date" name="buyDate" id="buyDate"><br>
            <label for="price">Precio:</label><br>
            <input type="text" name="price" id="price"><br>
            <label for="photo">Foto del álbum:</label><br>
            <input type="file" name="photo" id="photo"><br>
            <input type="hidden" name="gId" id="gId" value="<?= $_GET['id'] ?>">
            <input type="submit" value="Añade">

        </fieldset>
    </form>
    <footer class="flex">
        <small>Gustavo Víctor &copy; 2024</small>
    </footer>
</body>

</html>