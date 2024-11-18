<?php

/**
 * Aplicación web para mostrar grupos y discografía. Permite buscar a los grupos.
 * 
 * @author: Gustavo Víctor 
 * @version: 1.5
 */

// Primero llamamos a las variables y luego a la conexión a la base de datos:
$raiz = $_SERVER['DOCUMENT_ROOT'];

require_once($raiz . '/includes/env.inc.php');
require_once($raiz . '/includes/connection.inc.php');


try {

	// Establecemos la conexión con la función que hemos creado.
	$connection = connectDB();

	// En el caso de que la conexión no sea nula, obtenemos los grupos.
	if ($connection != null) {

		// Si el formulario está vacío, mostramos todos los grupos con sus covers:
		if (empty($_GET)) {

			$results = $connection->query(
				'SELECT id, name, photo FROM groups ORDER BY name ASC;'
			); // La consulta está entregada por el ejercicio.

			/* Obtenemos todos los resultados como objetos y los guardamos en un
		 array de objetos:*/
			$groups = $results->fetchAll(PDO::FETCH_OBJ);

			// Si no está vació el formulario, nos aseguramos de la consulta:
		} else {

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
			$key = '%' . trim($_GET['search']) . '%';

			// Y ahora sí, ligamos los parámetros a la consulta:
			$results->bindParam(':search', $key);

			// Y ahora sí, ejecutamos la consulta:
			$results->execute();

			// Almacenamos la consulta como un array de objetos:
			$groups = $results->fetchAll(PDO::FETCH_OBJ);

			if (empty($groups)) {
				$errors[] =
					'No existe el grupo "' .
					$_GET['search'] .
					'", lo lamentamos.';
			}
		}
	} else {
		$errors[] = 'Ha habido un error con la conexión';
	}

	// Quitamos las variables que conectan a la base de datos:
	unset($results);
	unset($connection);
} catch (Exception $exc) {
	$errors[] = $exc;
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
	<title>Discografía</title>
</head>

<body>
	<?php
	require_once(
		$_SERVER['DOCUMENT_ROOT'] .
		'/includes/headerGustavoVictor.inc.php'
	);
	?>

	<form class="flex" action="#" method="get">
		<label for="search">Búsqueda</label>
		<input
			type="text"
			name="search"
			id="search"
			placeholder="Busca tu grupo aquí">
		<input type="submit" value="Buscar">
	</form>

	<h2>Grupos:</h2><br>
	<?php
	if (!empty($errors)) {
		foreach ($errors as $error) {
			echo '<div class="error gold flex"><pre>' . $error . '</pre></div>';
		}
	}
	echo '<div class="groups gold flex">';
	foreach ($groups as $group) {
		echo '<div class="group">';
		echo
		'<a class="gold flex" href="groups.php?id=' .
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
	}
	echo '</div>';

	?>
	<footer class="flex">
		<small>Gustavo Víctor &copy; 2024</small>
	</footer>
</body>

</html>