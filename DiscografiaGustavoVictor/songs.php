<?php

/**
 * Página para las canciones de la aplicación de la actividad 'Discografia'
 * 
 * @author: Gustavo Víctor
 * @version: 1.2
 */

// Primero llamamos a las variables y luego a la conexión a la base de datos:
$raiz = $_SERVER['DOCUMENT_ROOT'];

require_once($raiz . '/includes/env.inc.php');
require_once($raiz . '/includes/connection.inc.php');

// Creamos dos arrays para comprobar los valores de la consulta GET
$values =
	[
		'title' => 's.title',
		'length' => 'length',
		'album' => 'a.title',
		'group' => 'g.name'
	];

$valOrder = [
	'asc',
	'desc'
];

// Ahora entramos en el try para capturar errores:
try {

	// Establecemos la conexión con la función que hemos creado.
	$connection = connectDB();

	// En el caso de que la conexión no sea nula, obtenemos las canciones.
	if ($connection != null) {

		// Si el formulario está vacío, mostramos todas las canciones de forma ascendente:
		if (empty($_GET)) {

			$results = $connection->query(
				'SELECT s.id, s.title, length, a.title AS "album", g.name AS "group"
				FROM songs s, albums a, groups g
				WHERE album_id=a.id AND group_id=g.id 
				ORDER BY s.title ASC;'
			); // La consulta está entregada por el ejercicio.

			/* Obtenemos todos los resultados como objetos y los guardamos en un
		 array de objetos:*/
			$songs = $results->fetchAll(PDO::FETCH_OBJ);

			// Si no está vació el formulario, nos aseguramos de la consulta:
		} else {

			// Esto es porque si no nos salta un error al venir de Discografía:
			if(empty($_GET['field'])) {
				$_GET['field'] = null;
			}

			/* Sólo si los valores de field y de orden están bien, 
			realizamos la búsqueda:*/
			if (
				array_key_exists($_GET['field'], $values) &&
				in_array($_GET['order'], $valOrder)
			) {

				$field = $values[$_GET['field']];
				$order = strtoupper($_GET['order']);

				// Para que quede bien la consulta, la pasamos como string primero:
				$query = '
				SELECT 
					s.id, 
					s.title AS "title", 
					length, 
					a.title AS "album", 
					g.name AS "group" 
				FROM 
					songs s, albums a, groups g
				WHERE 
					album_id=a.id AND group_id=g.id 
				ORDER BY 
					' . $field . ' ' . $order . ';';

				// Preparamos la consulta:
				$results = $connection->prepare($query);

				// Ejecutamos la consulta:
				$results->execute();

				// Almacenamos la consulta como un array de objetos:
				$songs = $results->fetchAll(PDO::FETCH_OBJ);

			} else if (!empty($_GET['search']) ) {

				// Como en este caso el usuario introduce datos, hemos de asegurarnos de
			// que su consulta no sea un injecto de sql:
			$results = $connection->prepare(
				'SELECT 
					s.id, 
					s.title AS "title", 
					length, 
					a.title AS "album", 
					g.name AS "group" 
				FROM 
					songs s, albums a, groups g
				WHERE album_id=a.id AND group_id=g.id AND g.name LIKE :search 
			ORDER BY a.title, s.title ASC;'
			);

			// bindParam() no admite comodines, por lo que creamos una variable donde
			// los introducimos:
			$key = '%' . trim($_GET['search']) . '%';

			// Y ahora sí, ligamos los parámetros a la consulta:
			$results->bindParam(':search', $key);

			// Y ahora sí, ejecutamos la consulta:
			$results->execute();

			// Almacenamos la consulta como un array de objetos:
			$songs = $results->fetchAll(PDO::FETCH_OBJ);

			} else {
				$errors[] = 'No se han introducido campos válidos de búsqueda';
				$songs = [];
			}

			// Traza
			// $sql = $results;
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
	<link rel="stylesheet" href="styles/style.css">
	<title>Discografía</title>
</head>

<body>
	<?php
	require_once(
		$raiz . '/includes/headerGustavoVictor.inc.php'
	);
	?>

	<h2>Canciones:</h2>

	<?php
	// Mostramos los errores si toca:
	if (!empty($errors)) {
		foreach ($errors as $error) {
			echo '<div class="error gold flex"><pre>' . $error . '</pre></div>';
		}
	}

	// Trazas:
	// echo '<pre>';
	// print_r($_GET);
	// echo '</pre>';
	// echo '<pre>';
	// echo $field . ' ' . $order;
	// echo '</pre>';
	// echo '<pre>';
	// print_r($sql->debugDumpParams());
	// echo '</pre>';
	?>

	<div class="tSongs flex">
		<table>
			<thead class="gold">
				<tr>
					<th>
						Título
					</th>
					<th>
						Duración
					</th>
					<th>
						Álbum
					</th>
					<th>
						Grupo
					</th>
				</tr>
				<tr>
					<th>
						<a href="songs.php?field=title&order=asc">
							<img src="img/sort-asc.png" alt="ascendiente"></a>
						<a href="songs.php?field=title&order=desc">
							<img src="img/sort-desc.png" alt="descendiente"></a>
					</th>
					<th>
						<a href="songs.php?field=length&order=asc">
							<img src="img/sort-asc.png" alt="ascendiente"></a>
						<a href="songs.php?field=length&order=desc">
							<img src="img/sort-desc.png" alt="descendiente"></a>
					</th>
					<th>
						<a href="songs.php?field=album&order=asc">
							<img src="img/sort-asc.png" alt="ascendiente"></a>
						<a href="songs.php?field=album&order=desc">
							<img src="img/sort-desc.png" alt="descendiente"></a>
					</th>
					<th>
						<a href="songs.php?field=group&order=asc">
							<img src="img/sort-asc.png" alt="ascendiente"></a>
						<a href="songs.php?field=group&order=desc">
							<img src="img/sort-desc.png" alt="descendiente"></a>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Mostramos cada canción con su duración, album y grupo:
				foreach ($songs as $song) {
					echo '<tr>';
					echo '<td>' . $song->title . '</td>';
					echo '<td>' .
						intval($song->length / 60) .
						':' .
						sprintf('%02d', ($song->length % 60)) .
						'</td>'; // ChatGPT me dio cómo formatear el número de salida para obtener 01, 02...
					echo '<td>' . $song->album . '</td>';
					echo '<td>' . $song->group . '</td>';
					echo '</tr>';
				}
				?>
			</tbody>
		</table>
	</div>

	<footer class="flex">
		<small>Gustavo Víctor &copy; 2024</small>
	</footer>
</body>

</html>