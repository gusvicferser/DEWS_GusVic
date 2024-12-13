<?php

/**
 * Aplicación web Frikishop página principal donde se pueden visionar los 
 * productos, añadirlos al carrito, quitar los que ya se han añadido (no se 
 * puede quitar un producto que no se haya añadido previamente al carro),
 * o quitar todos los productos que hubieras añadido. 
 * 
 * Además uno se puede registrar, acceder a la zona de login, ver las ofertas si
 * no está logueado y si es administrador, ver la lista de usuarios en la db:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 2.3
 */

// Sesión (hacemos los cambios en la cookie e iniciamos sesión):
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

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

	// Hemos de gestionar el carrito:
	// Entre las tres opciones que tenemos, existe la opción 'add': 
	if (isset($_GET['add']) && in_array($_GET['add'], $ids)) {

		// Si hay stock entonces añadimos uno:
		if ($products[$_GET['add'] - 1]->stock > 0) {
			if (isset($_SESSION['basket'][$_GET['add']])) {

				$_SESSION['basket'][$_GET['add']] += 1;
			} else {
				$_SESSION['basket'][$_GET['add']] = 1; // Si no la seteamos.
			}
			$products[($_GET['add'] - 1)]->stock -= 1;
		}
	}

	// La opción subtract:
	if (
		isset($_GET['subtract']) &&
		in_array($_GET['subtract'], $ids)
	) {
		// Si no es cero lo que hay en el carro, restamos, si no no hacemos nada.
		if (
			isset($_SESSION['basket'][$_GET['subtract']]) &&
			$_SESSION['basket'][$_GET['subtract']] > 0
		) {
			$_SESSION['basket'][$_GET['subtract']] -= 1;
			$products[$_GET['subtract'] - 1]->stock++;
		}
	}

	// La opción remove:
	if (isset($_GET['remove']) && in_array($_GET['remove'], $ids)) {

		// Si está seteada y además no es cero, devolvemos al stock lo que había
		// y la deseteamos:
		if (
			isset($_SESSION['basket'][$_GET['remove']]) &&
			$_SESSION['basket'][$_GET['remove']] > 0
		) {

			$products[$_GET['remove'] - 1]->stock += $_SESSION['basket'][$_GET['remove']];
			unset($_SESSION['basket'][$_GET['remove']]);
		}
	}
	// Con este apartado contamos cuántos objetos totales hay en el carrito 
	// cada vez:
	if (isset($_SESSION['basket'])) {
		$artTotal = 0;
		foreach ($_SESSION['basket'] as $product) {
			$artTotal += $product;
		}
	}
} catch (Exception $exception) {
	$dbError = true;
	// var_dump($exception);
}


?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MerchaShop</title>
	<link rel="stylesheet" href="/css/style.css">
</head>

<body>
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

	// Para poner el formulario si no está registrado:
	if (!isset($_SESSION['userName'])) {
		require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/form.inc.php');
	?>
		</div>
		<div id="ofertas">
			<a href="/sales">
				<img src="/img/ofertas.png"
					alt="Imagen acceso ofertas">
			</a>
		</div>
	<?php
	}
	// Si el usuario está logueado (existe su variable de sesión): -->
	if (isset($_SESSION['userName'])) {
	?>

		<div id="carrito">
			<?= $artTotal ?? 0 ?>
			productos en el carrito.
			<a href="/basket" class="boton">Ver carrito</a>
		</div>

		<section class="productos">
		<?php
		if (count($products) > 0) {
			foreach ($products as $product) {
				echo '<article class="producto">';
				echo '<h2>' . $product->name . '</h2>';
				echo '<span>(' . $product->category . ')</span>';
				echo
				'<img src="/img/products/' .
					$product->image .
					'" alt="' .
					$product->name .
					'" class="imgProducto">
					 <br>';
				echo '<span>' . $product->price . ' €</span><br>';
				if ($product->stock > 0) {
					echo '<span class="botonesCarrito">';
					echo
					'<a href="/add/' .
						$product->id .
						'" class="productos">
							<img src="/img/mas.png" 
							alt="añadir 1">
						</a>';
					echo
					'<a href="/subtract/' .
						$product->id .
						'" class="productos">
							<img src="/img/menos.png" 
							alt="quitar 1">
						</a>';
					echo
					'<a href="/remove/' .
						$product->id .
						'" class="productos">
							<img src="/img/papelera.png" 
							alt="quitar todos">
						</a>';
					echo '</span>';
					echo '<span>Stock: ' . $product->stock . '</span>';
				} else {
					echo "Sin stock";
					// Queremos dar la posibilidad de devolver los objetos cuando
					// han adquirido alguno pero nos hemos quedado sin stock:
					echo
					'<a href="/remove/' .
						$product->id .
						'" class="productos">
							<img src="/img/papelera.png" 
							alt="quitar todos">
						</a>';
				}
				echo '</article>';
			}
		} else {
			echo '<h2>Vendemos mucho y ahora mismo no hay productos, visítanos más tarde.</h2>';
		}
		echo '</section>';
		// Fin usuario logueado -->
	}
		?>

</body>

</html>