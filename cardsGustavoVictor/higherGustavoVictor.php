<?php

/**
 * Página reservada para el juego de la carta más alta de los juegos de cartas.
 * @author: Gustavo Víctor
 * @version: 1.8
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
            $players[0]['score'] += 2;
        } else if ($players[0]['hand'][$i]['value'] == $players[1]['hand'][$i]['value']) {

            $players[0]['hand'][$i]['winner'] = 0;
            $players[0]['score'] += 1;
            $players[1]['hand'][$i]['winner'] = 0;
            $players[1]['score'] += 1;
        } else {

            $players[1]['hand'][$i]['winner'] = 1;
            $players[0]['hand'][$i]['winner'] = -1;
            $players[1]['score'] += 2;
        }
    }
    for ($i = 0; $i < NUMBER_OF_PLAYERS; $i++) {
    ?>

        <div class="playerDisplay">
            <img src="/images/<?= $players[$i]['avatar'] ?>" alt="<?= $players[$i]['avatar'] ?>"><br>
            <h1><?= $players[$i]['name'] ?></h1><br>
            <div class="player" id="player<?= ($i + 1) ?>">;

                <?php
                foreach ($players[$i]['hand'] as $card) {
                    if ($card['winner'] == 1) {
                ?>

                        <img src="/images/baraja/<?= $card['image'] ?>" alt="<?= $card['image'] ?>" class="winner">

                    <?php
                    } else if ($card['winner'] == 0) {
                    ?>

                        <img src="/images/baraja/<?= $card['image'] ?>" alt="<?= $card['image'] ?>" class="even">

                    <?php
                    } else {
                    ?>

                        <img src="/images/baraja/<?= $card['image'] ?>" alt="<?= $card['image'] ?>">';

                <?php
                    }
                }
                ?>
            </div>
        </div><br>

    <?php
    }

    if ($players[0]['score'] > $players[1]['score']) {
        $winner = $players[0]['name'];
        $avatar = $players[0]['avatar'];
    } else if ($players[0]['score'] == $players[1]['score']) {
        $winner = 'Nadie';
        $avatar = 'nadie.jpg';
    } else {
        $winner = $players[1]['name'];
        $avatar = $players[1]['avatar'];
    }

    ?>
    <br><br>
    <div class="winPlayer">
        <div>
            <h1>Puntuación</h1><br>
            <div>
                <h3><?= $players[0]['name'] ?>: <?= $players[0]['score'] ?></h3><br>
                <h3><?= $players[1]['name'] ?>: <?= $players[1]['score'] ?></h3><br>
            </div>
        </div>
        <div>
            <h1>El ganador es:</h1>
            <img src="/images/<?= $avatar ?>" alt="<?= $winner ?>">
            <h2><?= $winner ?><h2><br>
        </div>
    </div>



    <?php
    // Espacio reservado para el footer:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');
    ?>

</body>

</html>