<?php

/**
 * Aplicación web para crear y borrar cookies:
 * 
 * @author Gustavo Víctor
 * @version 1.0
 */

// Hemos de comprobar como primer paso que exista una cookie:
if (!isset($_COOKIE['theme'])) {

	// Creamos la cookie:
	setcookie('theme', 'dark');
	header('location:/act1triki.php');
	exit;
}

// Si está seteada la variable 'cookies':
if (isset($_GET['cookies'])) {

	// Si han aceptado las cookies, se crea una cookie de confirmación:
	if ($_GET['cookies'] === 'confirm') {
		setcookie('confirm', 'hellyeah', time() + 60, httponly: true);
		header('location:/act1triki.php');
		exit;
	} else if ($_GET['cookies'] === 'deleteAll') {
		foreach ($_COOKIE as $key => $cookie) {
			setcookie($key, expires_or_options: time() - 1, httponly: true);
		}
	}
	// Redirigimos:
	header('location:/act1triki.php');
	exit;
}

// El apartado para cambiar el tema con los botones. Primero comprobamos si
// la variable existe:
if (isset($_GET['theme']) && in_array($_GET['theme'], ['light', 'dark'])) {
		setcookie('theme', $_GET['theme'], httponly: true);

	// Sea como sea, devolvemos a la página:
	header('location:/act1triki.php');
	exit;
}


?>

<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Triki: el monstruo de las Cookies</title>
	<link rel="stylesheet" href="/css/<?= $_COOKIE['theme'] ?? 'dark' ?>.css">
</head>

<body>
	<?php
	// Ponemos este if para saltarse la configuración si ya existe la cookie
	// de confirmación:
	if (!isset($_COOKIE['confirm'])) {
	?>
		<div id="cookies">
			Este sitio web utiliza cookies propias y puede que de terceros.<br>
			Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies.<br>
			<div><a href="/act1triki.php?cookies=confirm">ACEPTAR</a></div>
		</div>
	<?php
	}
	?>

	<h1>Bienvenido a la web de Triki, el monstruo de las cookies</h1>

	<h2>Bienvenido a la web donde no se gestionan las cookies, se devoran.</h2>
	<img src="/img/triki.jpg" alt="Imagen de triki mirando una galleta">

	<div id="botones">
		<a href="/act1triki.php?theme=light" class="styleButton">Claro</a>
		<a href="/act1triki.php?theme=dark" class="styleButton">Oscuro</a>
	</div>
	<br>

	<div><a href="/act1triki.php?cookies=deleteAll">Borrar cookies</a></div>
</body>

</html>