<?php

/**
 * Aplicación web corregida para la actividad FrikiShop:
 * 
 * @author Gustavo Víctor
 * @version 1.1
 */

// Cambiamos el nombre de la cookie de la sesión:
ini_set('session.name', 'SessionGustavoVictor');

// Le decimos al servidor que las cookies se han de obtener a través de http:
ini_set('session.cookie_httponly', 1);

// Modificamos la cookie para que expire en 5 min:
ini_set('session.cookie_lifetime', 300); // 300 segundos = 5 min

// Iniciamos sesión:
session_start();

require_once(
	$_SERVER['DOCUMENT_ROOT'] . '/FrikishopGustavoVictor/includes/env.inc.php'
);
require_once(
	$_SERVER['DOCUMENT_ROOT'] .
	'/FrikishopGustavoVictor/includes/connection.inc.php'
);

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
		foreach ($_SESSION['basket'] as $product) {
			$artTotal += $product;
		}
	}
} catch (Exception $exception) {
	$dbError = true;
	var_dump($exception);
}


?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MerchaShop</title>
	<link rel="stylesheet" href="/FrikishopGustavoVictor/css/style.css">
</head>

<body>
	<?php
	require_once(
		$_SERVER['DOCUMENT_ROOT'] .
		'/FrikishopGustavoVictor/includes/header.inc.php');

	// Trazas de comprobación:

	// echo '<pre>';
	// print_r($_SESSION['products']);
	// echo '</pre>';

	// echo '<pre>';
	// print_r($ids);
	// echo '</pre>';

	// echo '<pre>';
	// print_r($_SESSION['basket']);
	// echo '</pre>';

	//Si el usuario no está logueado (no existe su variable de sesión) -->
	?>
	<div class="loginContainer">
		<h2>Regístrate para poder comprar en la tienda</h2>

		<form action="signup" method="post">
			<label for="user">Usuario</label>
			<input type="text" name="user" id="user">
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" id="email">
			<br>
			<label for="password">Contraseña</label>
			<input type="password" name="password" id="password">
			<br>
			<label></label>
			<input type="submit" value="Registrarse">
		</form>

		<span>¿Ya tienes cuenta? <a href="/login">Loguéate aquí</a>.</span>
	</div>
	<div id="ofertas">
		<a href="/FrikishopGustavoVictor/sales">
			<img src="/FrikishopGustavoVictor/img/ofertas.png"
				alt="Imagen acceso ofertas">
		</a>
	</div>

	<?php
	// Fin usuario no logueado

	// Eliminar estos br:
	echo '<br><br>';

	// Si el usuario está logueado (existe su variable de sesión): -->
	?>
	<div id="carrito">
		<?= $artTotal ?? 0 ?>
		productos en el carrito.
		<a href="/FrikishopGustavoVictor/basket" class="boton">Ver carrito</a>
	</div>

	<section class="productos">
		<?php
		if (count($products) > 0) {
			foreach ($products as $product) {
				echo '<article class="producto">';
				echo '<h2>' . $product->name . '</h2>';
				echo '<span>(' . $product->category . ')</span>';
				echo
				'<img src="/FrikishopGustavoVictor/img/products/' .
					$product->image .
					'" alt="' .
					$product->name .
					'" class="imgProducto">
					 <br>';
				echo '<span>' . $product->price . ' €</span><br>';
				if ($product->stock > 0) {
					echo '<span class="botonesCarrito">';
					echo
					'<a href="/FrikishopGustavoVictor/add/' .
						$product->id .
						'" class="productos">
							<img src="/FrikishopGustavoVictor/img/mas.png" 
							alt="añadir 1">
						</a>';
					echo
					'<a href="/FrikishopGustavoVictor/subtract/' .
						$product->id .
						'" class="productos">
							<img src="/FrikishopGustavoVictor/img/menos.png" 
							alt="quitar 1">
						</a>';
					echo
					'<a href="/FrikishopGustavoVictor/remove/' .
						$product->id .
						'" class="productos">
							<img src="/FrikishopGustavoVictor/img/papelera.png" 
							alt="quitar todos">
						</a>';
					echo '</span>';
					echo '<span>Stock: ' . $product->stock . '</span>';
				} else {
					echo "Sin stock";
					// Queremos dar la posibilidad de devolver los objetos cuando
					// han adquirido alguno pero nos hemos quedado sin stock:
					echo
					'<a href="/FrikishopGustavoVictor/remove/' .
						$product->id .
						'" class="productos">
							<img src="/FrikishopGustavoVictor/img/papelera.png" 
							alt="quitar todos">
						</a>';
				}
				echo '</article>';
			}
		} else {
			echo '<h2>Vendemos mucho y ahora mismo no hay productos, visítanos más tarde.</h2>';
		}
		?>
	</section>
	<?php
	// Fin usuario logueado -->
	?>

</body>

</html>