<?php
/**
 * Página para el registro de los nuevos usuarios:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 1.2
 */

// Sesión (hacemos los cambios en la cookie e iniciamos sesión):
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

if(!empty($_POST)) {
    // Se eliminan los espacios delante y detrás de los campos recibidos
    foreach($_POST as $key => $value)
        $_POST[$key] = trim($value);

    // Si el campo está vacío se añade un elemento al array $errors[]
    if (empty($_POST['user']))
        $errors['user'] = 'El usuario no puede estar en blanco.';   
    if (empty($_POST['email']))
        $errors['email'] = 'El email no puede estar en blanco.';
    if (empty($_POST['password']))
        $errors['password'] = 'La contraseña no puede estar en blanco.';

    // Si no existe el array $errors[] es que todos los campos recibidos están bien
    if (!isset($errors)) {
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/env.inc.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/connection.inc.php');
        try {
            if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
                // Se comprueba que no exista ya en la BBDD un usuario con el username o el mail recibido
                // Si no existen hay que guardar los datos del nuevo usuario encriptando la contraseña
                //  y posteriormente se redirige a la página para que el usuario haga login:
                $query = $connection->prepare(
                    'SELECT user, email FROM users WHERE :user = user OR :email = email;'
                );
                $query->bindParam(':user', $_POST['user']);
                $query->bindParam(':email', $_POST['email']);
                $query->execute();

                $results = $query->fetchAll();

                // Si no está en el array, lo añadimos a la base de datos:
                if(!in_array($_POST['user'], $results) && !in_array($_POST['email'], $results)) {

                    // Como nosotros encriptamos la contraseña, le especificamos
                    // que es un string con las comillas: 
                    $query = $connection->prepare(
                        'INSERT INTO users (user, email, password, rol) 
                        VALUES (:user, :email, "'.
                         password_hash($_POST['password'], PASSWORD_DEFAULT) .
                         '", "customer");'
                    );

                    $query->bindParam(':user', $_POST['user']);
                    $query->bindParam(':email', $_POST['email']);
                    $query->execute();

                    // Hay que regenerar la sesión (si no, al robar alguien la sesión 
                    // tendrá iniciada la sesión en otro ordenador):
                    session_regenerate_id(); //SUPER IMPORTANTE
                    
                    // Especificamos el nombre de usuario y el rol:
                    $_SESSION['userName'] = $_POST['user'];
                    $_SESSION['rol'] = 'customer';

                    header ('location:/');
                    exit;
                } else {
                    // Si sí que existen se guarda un error para luego mostrarlo en el body
                    $errors['exists'] = 'El usuario ya existe en la base de datos';
                }

            } else {
                throw new Exception('Error en la conexión a la BBDD');
            }
        } catch (Exception $exception) {
            // echo '<pre>';
            // var_dump($exception);
            // echo '</pre>';
            $dbError = true;
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
    <title>MerchaShop - Error en el registro</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.inc.php');
        if(isset($errors)){
    ?>
    <div>
        <h2>Existen errores en el formulario:</h2>
        <?php            
            foreach ($errors as $value) {
                echo $value .'<br>';
            }
        ?>
    </div>
<br>
    <a href="/">Vuelve a intentar el registro</a>
    <?php
        }
        ?>
    
</body>
</html>
