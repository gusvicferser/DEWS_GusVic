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

if (empty($_GET)) {


	$connection = connectDB();

	if ($connection != null) {
		$results = $connection->query(
			'SELECT id, name, photo FROM groups ORDER BY name ASC;'
		);

		foreach($results->fetchAll(PDO::FETCH_OBJ) as $result) {
			
		}
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
		$_SERVER['DOCUMENT_ROOT'] . '\includes\headerGustavoVictor.inc.php');
	?>

	<form action="#" method="get">
		<label for="">Búsqueda</label>
		<input
			type="text"
			name="busqueda"
			id="busqueda"
			placeholder="Busca tu grupo aquí">
		<input type="submit" value="Buscar">
	</form>

	<h2>Grupos:</h2>
	<footer>
		<small>Gustavo Víctor &copy; 2024</small>
	</footer>
</body>

</html>