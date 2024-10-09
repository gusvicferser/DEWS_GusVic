<?php
/**
 * Archivo principal de la aplicación Cartas
 *
 * @author Álex Torres
 * @version 1.0
 *
 */

$title = "Juegos de cartas";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="Sat, 07 feb 2016 00:00:00 GMT">
    <title>UD2 - Actividad 6 - <?=$title?></title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <?php
    require_once("includes/header.inc.php");
    ?>

    <img src="img/cartas.png" alt="Montón de cartas" id="cartasPrincipal">
</body>
</html>