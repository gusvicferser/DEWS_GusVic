<?php
/**
 * Aplicación web para mostrar la cabecera modificada para que sea vea 
 * una parte o toda en función de la cuenta que tenga el usuario:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 1.1
 */

// Aquí invocamos las variables globales y la conexión a la base de datos:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

try {

	if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
		$query = 'SELECT * FROM products;';
		// Si no ponemos este if, vuelve a cargar de nuevo todos los productos:
		if (!isset($_SESSION['basket'])) {
			$_SESSION['products'] = $connection->query($query)->fetchAll(PDO::FETCH_OBJ);
		}

		// Como no queremos todos los productos de nuevo, establecemos una 
		// variable con los productos de sesión y lo vamos modificando aquí:
		$products = $_SESSION['products'];
		unset($query);
		unset($connection);
	} else {
		throw new Exception('Error en la conexión a la BBDD');
	}
	// Necesito comprobar si los ids que nos pasan por get existen en la DB:
	foreach ($products as $key => $product) {
		$ids[] = $products[$key]->id;
	}

	
} catch (Exception $exception) {
	$dbError = true;
}

// echo '<pre>';
// var_dump($products);
// echo '</pre>';

header('Content-Type: application/json; charset=utf-8');
echo json_encode($products);
