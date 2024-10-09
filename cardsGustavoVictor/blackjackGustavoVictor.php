<?php

/**
 * Página reservada para juego de blackjack.
 * @author: Gustavo Víctor
 * @version: 1.15
 */

$title = 'BlackJack';

const NUMBER_OF_CARDS = 2;
const NUMBER_OF_PLAYERS = 6;
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
    $players = createPlayers(NUMBER_OF_PLAYERS - 1);

    // Creamos a la banca aquí, ya que sólo lo necesitaremos en esta página:
    $banca = ['name' => 'La Banca', 'score' => 0, 'avatar' => 'banca.png', 'asNum' => 0];

    // La añadimos al lugar de los jugadores para repartirle cartas:
    $players[] = $banca;

    // Como los valores de las figuras son diez siempre en el BlackJack, los cambiaremos antes de repartir:
    foreach ($deck as $key => $card) {
        switch ($card['value']) {
            case 'J':
            case 'Q':
            case 'K':
                $deck[$key]['value'] = 10;
                break;
        }
    }

    shuffle($deck);

    /* // Traza
    echo '<pre>';
    print_r($deck);
    echo '<pre>';
    */


    // Repartimos cartas:
    for ($i = 0; $i < NUMBER_OF_CARDS; $i++) {
        for ($j = 0; $j < NUMBER_OF_PLAYERS; $j++) {

            $players[$j]['hand'][] = array_pop($deck); // Repartimos una carta
            $players[$j]['score'] += $players[$j]['hand'][$i]['value']; // Sumamos el valor de la carta

            // Si hay un as, lo añadimos al contador de ases:
            if ($players[$j]['hand'][$i]['value'] == 1) {
                $players[$j]['asNum'] += 1;
            }
        }
    }

    /* // Traza:
    echo '<pre>';
    print_r($players);
    echo '<pre>';
    */


    // Ahora vamos a evaluar la mano de cada uno de los jugadores:
    for ($i = 0; $i < (NUMBER_OF_PLAYERS); $i++) {

        do {

            $handCards = count($players[$i]['hand']) - 1; // ¡¡He de restarle uno o si no se sale del índice del array!!

            

            // Si tiene más de un as, se añade 10 a la puntuación y se resta el as. Nunca dos ases juntos sumarán 10:
            if ($players[$i]['asNum'] > 0) {

                $players[$i]['score'] += 10;
                $players[$i]['asNum'] -= 1;
                // echo ' As Checked '; // Traza
            }

            // Si el jugador tiene menos de 14, después de calcular los ases, roba carta:
            if ($players[$i]['score'] < 14) {

                $players[$i]['hand'][] = array_pop($deck);
                $handCards++;
                $players[$i]['score'] += $players[$i]['hand'][$handCards]['value'];

                // Si la carta que ha robado es un as, añadimos uno al contador de ases:
                if ($players[$i]['hand'][$handCards]['value'] == 1) {

                    $players[$i]['asNum'] += 1;
                }
                
            }
            // Además, si está por encima y tiene un as, restamos diez y quitamos un as del contador:
            if ($players[$i]['score'] > 21 && $players[$i]['asNum'] > 0) {

                $players[$i]['score'] -= 10;
                $players[$i]['asNum'] -= 1;
            }
            // Reiniciamos el contador por si las moscas:
            unset($handCards);

            // echo ' Name: '. $players[$i]['name']. ' Cards in Hand: '. count($players[$i]['hand']) .'. Score: '. $players[$i]['score']; // Traza

        } while ($players[$i]['score'] < 14 || $players[$i]['asNum'] > 0);
    }

    // Comparar resultados y escoger al ganador:
    if ($players[5]['score'] > 21) {

        for ($i = 0; $i < 5; $i++) {

            if ($players[$i]['score'] <= 21) {

                $players[$i]['status'] = 'wins';
            } else {

                $players[$i]['status'] = 'loses';
            }
        }
    } else {

        for ($i = 0; $i < 5; $i++) {
            if ($players[$i]['score'] < $players[5]['score']) {

                $players[$i]['status'] = 'loses';
            } else if ($players[$i]['score'] == $players[5]['score']) {

                $players[$i]['status'] = 'ties';
            } else {

                if ($players[$i]['score'] <= 21) {

                    $players[$i]['status'] = 'wins';
                } else {
                    $players[$i]['status'] = 'loses';
                }
            }
        }
    }


    /* // Traza
        echo $players[$i]['name'] . ': ' . $players[$i]['score'];
        echo '<pre>';
        print_r($players[$i]);
        echo '<pre>';
        */
    ?>


    <div class="headContainer">
        <div class="tableGame">

            <?php
            // Luego desplegamos tanto las cartas como los contenedores de la misma, el nombre del jugador y su avatar: 
            for ($i = 0; $i < (NUMBER_OF_PLAYERS - 1); $i++) {

                // Mostramos a la banca entre el primer y el segundo jugador:
                if ($i == 1) {
            ?>

                    <div class="playerBanca">
                        <figure>
                            <img src="/images/banca.png" alt="banca"><br>
                        </figure>
                        <h1>La Banca: <?= $players[5]['score'] ?></h1>
                        <div class="player" id="banca">

                            <?php
                            foreach ($players[5]['hand'] as $key => $card) {
                            ?>
                                <img src="/images/baraja/<?= $card['image'] ?>" alt="<?= $card['image'] ?>">

                            <?php
                            }
                            ?>
                        </div><br>
                    </div>

                <?php

                }
                if ($i == 2) {
                ?>
        </div>
        <div class="tableGame">
        <?php
                }
        ?>

        <div class="playerDisplay <?= $players[$i]['status'] ?>">
            <h1><?= $players[$i]['status'] ?></h1>
            <figure>
                <img src="/images/<?= $players[$i]['avatar'] ?>" alt="<?= $players[$i]['name'] ?>"><br>
            </figure>
            <h1><?= $players[$i]['name'] ?>: <?= $players[$i]['score'] ?></h1>
            <div class="player" id="player<?= ($i + 1) ?>">

                <?php
                foreach ($players[$i]['hand'] as $key => $card) {
                ?>
                    <img src="/images/baraja/<?= $card['image'] ?>" alt="<?= $card['image'] ?>">

                <?php
                }
                ?>
            </div><br>
        </div>


    <?php
            }
    ?>
        </div><br>
    </div>

    <?php
    // Espacio reservado para el footer:
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');
    ?>

</body>

</html>