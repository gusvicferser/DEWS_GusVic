<?php
	/**
	 * Página para las canciones de la aplicación de la actividad 'Discografia'
	 * 
	 * @author: Gustavo Víctor
	 * @version: 1.0
	 */
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
		$_SERVER['DOCUMENT_ROOT'] .
		'/DiscografiaGustavoVictor/includes/headerGustavoVictor.inc.php'
	);
	?>
	
	<h2>Canciones:</h2>

	<table>
		<th>
			<tr>
				Título
				<a href=""><img src="img/sort-asc.png" alt="ascendiente"></a>
				<a href=""><img src="img/sort-desc.png" alt="descendiente"></a>
			</tr>
			<tr>
				Duración
				<a href=""><img src="img/sort-asc.png" alt="ascendiente"></a>
				<a href=""><img src="img/sort-desc.png" alt="descendiente"></a>
			</tr>
			<tr>
				Álbum
				<a href=""><img src="img/sort-asc.png" alt="ascendiente"></a>
				<a href=""><img src="img/sort-desc.png" alt="descendiente"></a>
			</tr>
			<tr>
				Grupo
				<a href=""><img src="img/sort-asc.png" alt="ascendiente"></a>
				<a href=""><img src="img/sort-desc.png" alt="descendiente"></a>
			</tr>
		</th>
	</table>
	
	<footer>
		<small>Gustavo Víctor &copy; 2024</small>
	</footer>
</html>