<?php

/**
 * Página principal de los juegos de cartas.
 * @author: Gustavo Víctor
 * @version: 1.0
 */

$title = 'CaNsino';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php
    // Espacio reservado para la cabecera:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/cabeceraGustavoVictor.inc.php');
    ?>

    <div>
        <img src="/images/blackJack.jpg" alt="black_jack">
    </div>


    <?php
    // Espacio reservado para el footer:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');
    ?>

</body>

</html>