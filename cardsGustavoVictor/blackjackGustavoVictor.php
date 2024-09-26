<?php
    /**
     * Página reservada para juego de blackjack.
     * @author: Gustavo Víctor
     * @version: 1.0
     */

     $title = 'BlackJack';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
</head>
<body>
    <?php
     // Espacio reservado para la cabecera:
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/cabeceraGustavoVictor.inc.php');  
    ?>

    <?php
     // Espacio reservado para el footer:
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footerGustavoVictor.inc.php');
     ?>
</body>
</html>
