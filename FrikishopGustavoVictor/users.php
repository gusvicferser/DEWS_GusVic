<?php
/**
 * Aplicación para ver los usuarios:
 * 
 * @author (Correccion) Gustavo Victor
 * @version 1.2
 */

 // Sesión (hacemos los cambios en la cookie e iniciamos sesión):
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/connection.inc.php');

// Si el usuario no es admin, no puede ver esta página:
if(!isset($_SESSION['rol']) || $_SESSION['rol']!='admin'){
    header('location:/');
    exit;
}

try {
	if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
		$query = 'SELECT user, email, rol FROM users;';
		$users = $connection->query($query)->fetchAll(PDO::FETCH_OBJ);
	} else {
		throw new Exception('Error en la conexión a la BBDD');
	}
} catch (Exception $exception) {
	$dbError = true;
}
unset($query);
unset($connection);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MerchaShop - Usuarios</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.inc.php');

        echo '<div class="center">';
        echo '<table>';
            echo '<tr>';
                echo '<td>Usuario</td><td>Email</td><td>Rol</td>';
            echo '</tr>';
            foreach($users as $user) {
                echo '<tr>';
                    echo '<td>'. $user->user .'</td>';
                    echo '<td>'. $user->email .'</td>';
                    echo '<td>'. $user->rol .'</td>';
                echo '</tr>';
            }
        echo '</table>';
        echo '</div>';
    ?>
</body>
</html>
