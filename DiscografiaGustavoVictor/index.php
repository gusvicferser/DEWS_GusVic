<?php

/**
 * Aplicación web para mostrar grupos y discografía. Permite buscar a los grupos.
 * 
 * @author: Gustavo Víctor 
 * @version: 1.0
 */

/**
 * Función para conectar con la base de datos:
 *
 * @author: Gustavo Víctor
 * @version: 1.0
 * 
 * @return: Mixed: 'PDO' (Un objeto Php Data Object) si lo consigue, 
 * o 'null' si no.
 */
function connectDB(): mixed
{

	$options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];
	try {
		return new PDO(
			'mysql:host=localhost;dbname=discografia',
			'vetustamorla',
			'15151',
			$options
		);
	} catch (Exception $exc) {
		return null;
	}
}

// Si el formulario está vacío, mostramos todos los grupos con sus covers:
if (empty($_GET)) {

	// Establecemos la conexión con la función que hemos creado.
	$connection = connectDB();

	// En el caso de que la conexión no sea nula, obtenemos los grupos.
	if ($connection != null) {
		$results = $connection->query(
			'SELECT id, name, photo FROM groups ORDER BY name ASC;'
		); // La consulta está entregada por el ejercicio.

		/* Obtenemos todos los resultados como objetos y los guardamos en un
		 array de objetos:*/
		$groups = $results->fetchAll(PDO::FETCH_OBJ);

		// Deshacemos las variables para cortar la conexión a la base de datos:
		unset($results);
		unset($connection);
	}
} else {

	$connection = connectDB();

	if ($connection != null) {
		// Como en este caso el usuario introduce datos, hemos de asegurarnos de
		// que su consulta no sea un injecto de sql:
		$results = $connection->prepare(
			'SELECT id,name,photo 
			FROM groups 
			WHERE name LIKE :search 
			ORDER BY name ASC;'
		);

		// bindParam() no admite comodines, por lo que creamos una variable donde
		// los introducimos:
		$key = '%'. trim($_GET['search']) . '%';

		// Y ahora sí, ligamos los parámetros a la consulta:
		$results->bindParam(':search', $key);

		// Y ahora sí, ejecutamos la consulta:
		$results->execute();

		// Almacenamos la consulta como un array de objetos:
		$groups = $results->fetchAll(PDO::FETCH_OBJ);

		// Quitamos las variables que conectan a la base de datos:
		unset($results);
		unset($connection);

	}
}

?>

<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles/style.css">
	<title>Discografía</title>
</head>

<body>
	<?php
	require_once(
		$_SERVER['DOCUMENT_ROOT'] . 
		'/DiscografiaGustavoVictor/includes/headerGustavoVictor.inc.php'
	);
	?>

	<form action="#" method="get">
		<label for="">Búsqueda</label>
		<input
			type="text"
			name="search"
			id="search"
			placeholder="Busca tu grupo aquí">
		<input type="submit" value="Buscar">
	</form>

	<h2>Grupos:</h2>
	<?php
		echo '<div class="groups>';
		foreach ($groups as $group) {
			echo '<div class="group">';
			echo '<div class="gPhoto">';
			echo '<img href"'. $group->img . '"/>';
			echo '</div>';
			echo '<h2>'. $group->name . '</h2>';
			echo '</div>';
		}
		echo '</div>';

	?>
	<footer>
		<small>Gustavo Víctor &copy; 2024</small>
	</footer>
</body>

</html>