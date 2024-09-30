<?php

/**
 * Página reservada para el juego de la carta más alta de los juegos de cartas.
 * @author: Gustavo Víctor
 * @version: 1.0
 */

$title = 'Higher';

const NUMBER_OF_CARDS = 10;
const NUMBER_OF_PLAYERS = 2;
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
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/barajaGustavoVictor.inc.php');

    // Crear el deck:
    $deck = createDeck();

    // Asignamos el jugador 1 y el jugador 2:
    $players = createPlayers(NUMBER_OF_PLAYERS);

    // Repartimos cartas:
    for ($i = 0; $i < NUMBER_OF_CARDS; $i++) {

        // Una a cada jugador
            $players[0]['hand'][] = array_pop($deck);
            $players[1]['hand'][] = array_pop($deck);

        // Aprovechamos y calculamos qué carta ha ganado:
        if ($players[0]['hand'][$i]['value'] > $players[1]['hand'][$i]['value']) {

            $players[0]['hand'][$i]['winner'] = 1;
            $players[1]['hand'][$i]['winner'] = -1;
            $players[0]['punctuation'] += 2;
        } else if ($players[0]['hand'][$i]['value'] == $players[1]['hand'][$i]['value']) {

            $players[0]['hand'][$i]['winner'] = 0;
            $players[0]['punctuation'] += 1;
            $players[1]['hand'][$i]['winner'] = 0;
            $players[1]['punctuation'] += 1;
        } else {

            $players[1]['hand'][$i]['winner'] = 1;
            $players[0]['hand'][$i]['winner'] = -1;
            $players[1]['punctuation'] += 2;
        }
    }
    for ($i=0;$i<NUMBER_OF_PLAYERS;$i++) {
        echo '<h1>Player '. $players[$i]['name'] . '</h1><br><div id="player'. $i . '> <br>';
    foreach ($players[$i]['hand'] as $card) {
        echo '<img src="/images/baraja/'. $card['image'] . '" alt="'. $card['image']. '">';
    }
}
    ?>


    <?php
    // Espacio reservado para el footer:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');
    ?>

</body>

</html>