<?php

/**
 * Página para añadir o eliminar albumes de determinado grupo
 * para la aplicación de la actividad 'Discografia'
 * 
 * @author: Gustavo Víctor
 * @version: 1.5
 */

// Si no está seteado el id o está vacío redireccionamos al index:
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location:/');
    exit;
}

// Primero llamamos a las variables y luego a la conexión a la base de datos:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

// Hacemos el try catch:
try {

    // Si el formulario no está vacío gestionamos la petición:
    if (!empty($_GET)) {

        // Primero establecemos la conexión:
        $connection = connectDB();

        // Hacemos un trim directamente:
        foreach ($_GET as $element) {
            $element = trim($element);
        }

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

            // Preparamos la siguiente query porque los datos siguen siendo 
            // introducidos por el usuario:
            $query = $connection->prepare(
                'SELECT  
                    id, 
                    title, 
                    year, 
                    price,
                    photo
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

                        // Preparamos la query porque los datos son introducidos por el usuario:
                        $query = $connection->prepare(
                            'SELECT 
                                id
                            FROM 
                                albums
                            WHERE 
                                id= :id ;'
                        );

                        // Vinculamos la variable a la variable enviada para evitar SQL injection:
                        $query->bindParam(':id', $_GET['album']);

                        // Ejecutamos la query:
                        $query->execute();

                        // $trazas[] = $query->debugDumpParams();

                        if ($query->rowCount() > 0) {

                            $trazas[] = 'Entra';

                            // Preparamos la query:
                            $query = $connection->prepare(
                                'DELETE FROM 
                                    albums 
                                WHERE 
                                id=:id_album ;'
                            );

                            // Hay que vincular la consulta con un bindParam():
                            $idAlbum = intval($_GET['album']);
                            $query->bindParam(':id_album', $idAlbum);

                            // Ejecutamos la query:
                            $query->execute();

                            // $trazas[] = $query->debugDumpParams();

                        }

                        // Cerramos la conexión:
                        unset($query);
                        unset($connection);

                        // Volvemos al grupo:
                        header(
                            'location:/group.php?id=' .
                            $_GET['id'] .
                            '&feedback=deleted');
                        exit;
                }
            }

            // Ahora trataremos la forma de incluir un álbum en ese grupo:
            if (!empty($_POST)) {

                // Vamos a hacer un if para los errores que pueda tener la portada del álbum:
                if (!empty($_FILES)) {

                    // Si $_FILES no está vacío, hemos de comprobar si existe 
                    // algún error posible de subida:
                    if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {

                        switch ($_FILES['photo']['error']) {
                            case UPLOAD_ERR_INI_SIZE:
                            case UPLOAD_ERR_FORM_SIZE:
                                $errors['photo'] = 'Portada demasiado grande';
                                break;
                            case UPLOAD_ERR_PARTIAL:
                                $errors['photo'] = 
                                'La portada no se ha podido subir entera';
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $errors['photo'] = 
                                'No se ha encontrado la portada';
                                break;
                            default:
                                $errors['photo'] = 'Error indeterminado';
                        }
                    }

                    // Si los errores están vacíos, entramos por aquí:
                    if (empty($errors['photo'])) {

                        // Si no hay errores, pasaremos a comprobar si es el tipo de archivo que requerimos:
                        if (
                            $_FILES['photo']['type'] != 'image/jpeg' && 
                            $_FILES['photo']['type'] != 'image/png') {

                            $errors['photo'] = 
                            'El tipo de archivo de la foto no es el correcto, debe ser .jpg/.jpeg o .png';
                        } else {
                            // Para añadir la foto, lo hacemos en otro include:
                            require_once(
                                $_SERVER['DOCUMENT_ROOT'] .
                                '/includes/addPhotoGustavoVictor.inc.php');
                        }
                    }
                }

                if (
                    isset($_POST['title']) && $_POST['title'] != '' &&
                    isset($_POST['price']) && $_POST['price'] != '' &&
                    $_GET['id'] == $_POST['gId']
                ) {

                    // Establecer la conexión con la base de datos de nuevo:
                    $connection = connectDB();

                    // Hemos de volver a preparar la query:
                    $query = $connection->prepare(
                        'INSERT INTO albums 
                        (title, 
                        group_id, 
                        year, 
                        format, 
                        buydate, 
                        price, 
                        photo) 
                    VALUES (
                        :title, 
                        :group_id, 
                        :year, 
                        :format, 
                        CURDATE(), 
                        :price, 
                        :photo);'
                    );

                    // Vinculamos las variables a los datos con bindParam para
                    // evitar inserciones SQL:
                    $query->bindParam(':title', $_POST['title']);
                    $query->bindParam(':group_id', $_POST['gId']);
                    $year = intval($_POST['year']);
                    $query->bindParam(':year', $year);
                    $query->bindParam(':format', $_POST['format']);

                    /*Hemos de asegurarnos de que sea un float y además de que 
                      no haya comas, sino puntos para hacer el float. De lo 
                      contrario lo trunca:*/
                    $price = floatval(str_replace(",", ".", $_POST['price']));
                    $query->bindParam(':price', $price);
                    // Por si no hay foto subida:
                    if (isset($_POST['photo'])) {
                        $query->bindParam(':photo', $_POST['photo']);
                    } else {
                        $null = null;
                        $query->bindParam(':photo', $null);
                    }

                    // Ejecutamos entonces la consulta:
                    $query->execute();

                    // $trazas[] = $query->debugDumpParams();

                    // Cerramos la conexión:
                    unset($query);
                    unset($connection);
                    unset($_POST); // Vaciamos $_POST

                    // Recargamos la página:
                    header('location:/group.php?id=' . $_GET['id'] . '&feedback=added');
                    exit;
                }
            } else {
                $error['info'] = 'Ha de introducir un album';
            }
        } else {
            header('location:/');
            exit; // Así enviamos al directorio raíz.
        }
    }
} catch (Exception $exc) {
    $errors[] = 'Ha habido un error crítico';
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

    echo '<h2>Grupos:</h2><br>';

    // Si hay errores los mostramos:
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="error gold flex"><pre>' . $error . '</pre></div>';
        }
    }

    // Para mostrar las trazas:
    if (!empty($trazas)) {
        foreach ($trazas as $traza) {
            echo '<pre>' . $traza . '</pre>';
        }
    }

    // Si hemos eliminado un mensaje, damos feedback:
    if (isset($_GET['feedback'])) {
        if ($_GET['feedback'] == 'deleted') {
            echo '<div class="confirmation gold flex">';
            echo '<h2>El album ha sido borrado con éxito</h2>';
            echo '</div>';


            // Si un album ha sido insertado, damos feedback:
        } else if ($_GET['feedback'] == 'added') {
            echo '<div class="confirmation gold flex">';
            echo '<h2>El album ha sido añadido con éxito</h2>';
            echo '</div>';
        }
    }

    // Mensaje de confirmación para borrar un album:
    if (isset($confirm) && $confirm) {
        echo '<div class="error gold flex">';
        echo '<h2>Está a punto de borrar este álbum, ¿está seguro?</h2>';
        echo '<div class="buttons flex">';
        echo '
            <a href="/group.php?id=' . $_GET['id'] . '">
            <button type="button" class="flex">Cancelar</button></a>';
        echo '
            <a 
            href="/group.php?id=' .
            $_GET['id'] . '&album=' .
            $_GET['album'] .
            '&action=delete"
            >
        <button type="button" class="flex">Confirmar</button>
        </a>';
        echo '</div>';
        echo '</div>';
    }

    echo '<div class="single gold flex">';
    echo '<div class="group">
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
    </div>

    <div class="albums flex">
        <table>
            <thead class="gold">
                <tr>
                    <th>Portada</th>
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
                    echo '
                    <td>
                        <img src="/img/albumes/' .
                        $album->photo .
                        '" alt="' .
                        $album->photo .
                        '">
                    </td>';
                    echo '<td>' . $album->title . '</td>';
                    echo '<td>' . $album->year . '</td>';
                    echo '<td>' . $album->price . ' €</td>';
                    echo '<td>
                        <a href="/group.php?id=' .
                        $_GET['id'] .
                        '&album=' .
                        $album->id .
                        '&action=confirm">
                        <img src="/img/papelera.png" alt="erase" class="trash">
                        </a>
                        </td>
                        </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <form class="flex" action="#" method="post" enctype="multipart/form-data">

        <fieldset>
            <legend>AÑADE UN ALBUM</legend>
            <label for="title">Título:</label><br>
            <input
                type="text"
                name="title"
                id="title"><br>
            <label for="year">Año:</label><br>
            <select name="year" id="year">
                <?php
                // Generar el array de años permitidos:
                $years = array_reverse(range(1860, (date("Y"))));
                foreach ($years as $year) {
                    echo '<option value="' . $year . '">' . $year . '</option>';
                }
                ?>
            </select><br>
            <label for="format">Formato:</label><br>
            <select name="format" id="format">
                <option value="cd">CD</option>
                <option value="dvd">DVD</option>
                <option value="mp3">MP3</option>
                <option value="vinilo">Vinilo</option>
            </select><br>
            <label for="price">Precio:</label><br>
            <input
                type="text"
                name="price"
                id="price"><br>
            <label for="photo">Foto del álbum:</label><br>
            <input
                type="file"
                name="photo"
                id="photo" 
                ><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="20MB">
            <input type="hidden" name="gId" id="gId" value="<?= $_GET['id'] ?>">
            <input type="submit" value="Añade">
        </fieldset>
    </form>
    <footer class="flex">
        <small>Gustavo Víctor &copy; 2024</small>
    </footer>
</body>

</html>