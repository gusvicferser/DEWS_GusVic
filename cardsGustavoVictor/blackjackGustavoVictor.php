<?php

/**
 * Página reservada para juego de blackjack.
 * @author: Gustavo Víctor
 * @version: 1.0
 */

$title = 'BlackJack';

const NUMBER_OF_CARDS = 2;
const NUMBER_OF_PLAYERS = 5;
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

    // Creamos a la banca aquí, ya que sólo lo necesitaremos en esta página:
    $banca = ['name' => 'La Banca', 'score' => 0, 'avatar' => 'banca.png'];

    // La añadimos al lugar de los jugadores para repartirle cartas:
    $players[] = $banca;

    // Como los valores de las figuras son diez siempre en el BlackJack, los cambiaremos antes de repartir:
    foreach ($deck as $card) {
        switch ($card['value']) {
            case 'J':
            case 'Q':
            case 'K':
                $card['value'] = 10;
                break;
        }
    }


    // Repartimos cartas:
    for ($i = 0; $i < NUMBER_OF_CARDS; $i++) {
        for ($j = 0; $j < NUMBER_OF_PLAYERS + 1; $j++) {

            $players[$j]['hand'][] = array_pop($deck); // Repartimos una carta
            // $players[$j]['score'] += (int) $players[$j]['hand'][$i]['value']; // Sumamos el valor de la carta

            // Si hay un as, lo añadimos al contador de ases:
            /* if ($players[$j]['hand'][$i]['value'] == 1) {
                $players[$j]['asNum'] += 1;
            }*/
        }
    }

    /*
    // Ahora vamos a evaluar la mano de cada uno de los jugadores:
    for ($i = 0; $i < NUMBER_OF_PLAYERS + 1; $i++) {

        $actualHand = $players[$i]['score'];

        do {

                if ($players[$i]['score'] < 14 && $players[$i]['asNum'] > 0) {
                    $players[$i]['score'] += 10;
                } 
                
                if ($players[$i]['score'] > 21 && $players[$i]['asNum'] > 0) {
                    $players[$i]['score'] -=10;
                    $players[$i]['asNum']-=1;
                }

                if ($players[$i]['score'] < 14) {
                    $players[$j]['hand'][] = array_pop($deck); // Repartimos una carta
                    $$players[$i]['score'] += (int) $players[$j]['hand'][$i]['value']; // Sumamos el valor de la carta
                    
                    // Si hay un as, lo añadimos al contador de ases:
                    if ($players[$j]['hand'][$i]['value'] == 1) {
                        $players[$j]['asNum'] += 1;
                    }
                } 

        } while ($players[$i]['score'] < 14 || $players[$i]['score'] > 21);

        $players[$i]['score'] = $actualHand;
    }*/

    do {

        for ($i = 0; $i < NUMBER_OF_PLAYERS; $i++) {

            $num_as = 0;

            foreach ($players[$i]['hand'] as $card) {
                if ($card['value'] == 1) {
                    $num_as++;
                    switch ($card['value']) {
                        case 'J':
                        case 'Q':
                        case 'K':
                            $players[$i]['score'] += 10;
                            break;
                        default:
                            $players[$i]['score'] += $card['value'];
                    }
                }

                for ($i = 0; $i < $num_as; $i++) {
                    if (($players[$i]['score'] + 10) < 21) {
                        $players[$i]['score'] += 10;
                    }
                }
            }
        }

        if ($players[$i]['score'] < 14) {
            $players[$i]['hand'] = array_pop($deck);
        }
    } while ($algo < 14);


    // Luego desplegamos tanto las cartas como los contenedores de la misma, el nombre del jugador y su avatar: 
    for ($i = 0; $i < NUMBER_OF_PLAYERS; $i++) {

        ?>

        <div class="playerDisplay"><img src="/images/
       
       <?php
        echo $players[$i]['avatar'] . '" alt="' . $players[$i]['avatar'];
        ?>
        
        "><br><h1>
        
        <?php
        echo $players[$i]['name'] .'</h1>';
        ?>

        <br><div class="player" id="player"

        <?php
        echo ''. ($i + 1) . '';
        foreach ($players[$i]['hand'] as $card) {
        ?>

        ><img src="/images/baraja/

        <?php
            echo $card['image'] . '" alt="' . $card['image'];
        }
        ?>
        "></div></div><br>
        <?php
    }

    // Aquí guardamos en una variable el ganador, su avatar y la puntuación:
    if ($players[0]['score'] > $players[1]['score']) {
        $winner = $players[0]['name'];
        $avatar = $players[0]['avatar'];
    } else if ($players[0]['score'] == $players[1]['score']) {
        $winner = 'nadie.jpg';
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
            <h2><?= $winner ?><h2>
        </div>
    </div>


    <?php
    // Espacio reservado para el footer:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');
    ?>

</body>

</html>