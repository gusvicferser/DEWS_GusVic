<?php
/**
 * Script para el juego de La carta más alta
 *
 * @author Álex Torres
 * @version 1.5
 *
 */

$title = "Carta más alta";

// Se crea una constante para la cantidad de cartas a repartir y otra para la cantidad de jugadores
const QUANTITY_OF_CARDS_IN_HAND = 10;
const QUANTITY_OF_PLAYERS = 2;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2 - Actividad 6 - <?=$title?></title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h1>
        Cartas más altas ganan
    </h1>
    <?php
    // Se incluye el header de la aplicación web
    require_once('includes/header.inc.php');

    // Se crea un array de nombres para que cada partida los jugadores sean aleatorios
    $playersNames = ['Bender', 'Fry', 'Leela', 'Zoidberg', 'Rick', 'Morty', 'Jerry', 'Beth', 'Summer', 'Peter', 'Brian', 'Quagmire'];
    shuffle($playersNames);
    for ($i=0; $i<QUANTITY_OF_PLAYERS; $i++) {
        $players[]['name'] = array_pop($playersNames);
    }

    // Se incluye el archivo que contiene el array con todas las cartas de la baraja
    require_once('includes/deck.inc.php');
    // Se ordena aleatoriamente la baraja con la función shuffle
    shuffle($deck);
    // Se reparten diez cartas a cada jugador yendo uno por uno
    for ($i=0;$i<QUANTITY_OF_CARDS_IN_HAND;$i++) {
        for ($j=0; $j<QUANTITY_OF_PLAYERS; $j++) {
            $players[$j]['hand'][$i] = array_pop($deck);
        }
    }
    
    // Se calculan las puntuaciones de cada jugador
    // Se inicializa la puntuación a cero
    for ($i=0; $i<QUANTITY_OF_PLAYERS; $i++) {
        $players[$i]['score'] = 0;
    }
    // Para cada pareja de cartas se calcula cuál gana o empata, se suman los puntos al jugador y se le añade a la carta
    //  un elemento nuevo 'style' para posteriormente poder aplicarle el css
    for ($i=0; $i<QUANTITY_OF_CARDS_IN_HAND; $i++) {
        if (cardValue($players[0]['hand'][$i]['value']) > cardValue($players[1]['hand'][$i]['value'])) {
            $players[0]['score'] += 2;
            $players[0]['hand'][$i]['style'] = "gana";
        } else if (cardValue($players[0]['hand'][$i]['value']) < cardValue($players[1]['hand'][$i]['value'])) {
            $players[1]['score'] += 2;
            $players[1]['hand'][$i]['style'] = "gana";
        } else {
            $players[0]['score']++;
            $players[0]['hand'][$i]['style'] = "empata";
            $players[1]['score']++;
            $players[1]['hand'][$i]['style'] = "empata";
        }
    }

    // Se muestran las manos de cada jugador
    foreach ($players as $key => $player) {
        echo '<div><h3>Jugador '. $key+1 .': '. $player['name'] .'</h3>';
        echo '<img src="img/players/'. $player['name'] .'.png" alt="'. $player['name'] .'" class="perfilJugador">';
        foreach ($player['hand'] as $card) {
            $scoreStyle = $card['style'] ?? "";
        echo '<img src="img/deck/'. $card['image'] .'" alt="'. $card['value'] .' '. $card['suit'] .'" class="jugada alta '. $scoreStyle .'">'; 
        }
        echo '</div>';
    }

    // Se muestran las puntuaciones y el resultado de la partida junto con el jugador ganador
    echo '<h3>Resultado de la partida:</h3>';
    foreach ($players as $player) {
        echo $player['name'] .': '. $player['score'] .' puntos<br>';
    }
    echo '<div class="jugador">';
        if ($players[0]['score'] > $players[1]['score']) {
            echo 'Gana: '. $players[0]['name'] .'<br>';
            echo '<img src="img/players/'. $players[0]['name'] .'.png" alt="'. $players[0]['name'] .'" class="perfilJugador">';
        } else if ($players[0]['score'] < $players[1]['score']) {
            echo 'Gana: '. $players[1]['name'] .'<br>';
            echo '<img src="img/players/'. $players[1]['name'] .'.png" alt="'. $players[1]['name'] .'" class="perfilJugador">';
        } else {
            echo 'Empate<br>';
            echo '<img src="img/players/'. $players[0]['name'] .'.png"t alt="'. $players[0]['name'] .'" class="perfilJugador">';
            echo '<img src="img/players/'. $players[1]['name'] .'.png" alt="'. $players[1]['name'] .'" class="perfilJugador">';
        }
    echo '</div>';

    // Función que devuelve el valor de la carta en forma numérica
    function cardValue(string $value): int {
        if ($value == 'J')
            return 11;
        else if ($value == 'Q')
            return 12;
        else if ($value == 'K')
            return 13;
        else
            return intval($value);
    }
    ?>
</body>
</html>