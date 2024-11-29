<?php

/**
 * Aplicación web corregida para la actividad FrikiShop:
 * 
 * @author Gustavo Víctor
 * @version 1.0
 */

// Cambiamos el nombre de la cookie de la sesión:
ini_set('session.name', 'SessionGustavoVictor');

// Le decimos al servidor que las cookies se han de obtener a través de http:
ini_set('session.cookie_httponly', 1);

// Modificamos la cookie para que expire en 5 min:
ini_set('session.cache_expire', 5);

// Iniciamos sesión:
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

try {
	if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
		$query = 'SELECT * FROM products;';
		$products = $connection->query($query)->fetchAll(PDO::FETCH_OBJ);
	} else {
		throw new Exception('Error en la conexión a la BBDD');
	}
	unset($query);
	unset($connection);
} catch (Exception $exception) {
	$dbError = true;
	unset($query);
	unset($connection);
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

	//Si el usuario no está logueado (no existe su variable de sesión) -->
	?>

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

	<div id="ofertas">
		<a href="/sales"><img src="/img/ofertas.png" alt="Imagen acceso ofertas"></a>
	</div>
	<?php
	// Fin usuario no logueado

	// Eliminar estos br:
	echo '<br><br>';

	// Si el usuario está logueado (existe su variable de sesión): -->
	?>
	<div id="carrito">
		X
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
				echo '<img src="/img/products/' . $product->image . '" alt="' . $product->name . '" class="imgProducto"><br>';
				echo '<span>' . $product->price . ' €</span><br>';
				if ($product->stock > 0) {
					echo '<span class="botonesCarrito">';
					echo '<a href="" class="productos"><img src="/img/mas.png" alt="añadir 1"></a>';
					echo '<a href="" class="productos"><img src="/img/menos.png" alt="quitar 1"></a>';
					echo '<a href="" class="productos"><img src="/img/papelera.png" alt="quitar todos"></a>';
					echo '</span>';
					echo '<span>Stock: ' . $product->stock . '</span>';
				} else {
					echo "Sin stock";
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