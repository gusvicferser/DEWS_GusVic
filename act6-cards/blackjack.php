<?php
/**
 * Script para el juego de La carta más alta
 *
 * @author Álex Torres
 * @version 1.0
 *
 */

$title = "BlackJack";

// Se crea una constante para la cantidad de cartas a repartir y otra para la cantidad de jugadores
const QUANTITY_OF_CARDS_IN_HAND = 2;
const QUANTITY_OF_PLAYERS = 6;
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
        Blackjack (21)
    </h1>
    <?php
    // Se incluye el header de la aplicación web
    require_once('includes/header.inc.php');

    // Se crea un array multidimensional para almacenar la información de los jugadores
    $playersNames = ['Bender', 'Fry', 'Leela', 'Zoidberg', 'Rick', 'Morty', 'Jerry', 'Beth', 'Summer', 'Peter', 'Brian', 'Quagmire'];
    shuffle($playersNames);
    // El primer jugador será la banca
    $players[0]['name'] = "Banca";
    for ($i=1; $i<QUANTITY_OF_PLAYERS; $i++) {
        $players[]['name'] = array_pop($playersNames);
    }
    
    
    // Se incluye el archivo que contiene el array con todas las cartas de la baraja
    require_once('includes/deck.inc.php');
    // Se ordena aleatoriamente la baraja con la función shuffle
    shuffle($deck);
    // Se reparten dos cartas a cada jugador yendo uno por uno (el último es la banca)
    for ($i=0;$i<QUANTITY_OF_CARDS_IN_HAND;$i++) {
        for ($j=0; $j<QUANTITY_OF_PLAYERS; $j++) { 
            $players[$j]['cards'][] = array_pop($deck);    
        }
    }

    // Cálculo de los puntos de cada jugador
    // Como no se necesita cada elemento del array solo se recorren sus índices
    foreach (array_keys($players) as $index) {
        do {
            $players[$index]['score'] = calculateScore($players[$index]['cards']);
            
            // Mientras la puntuación sea menor que 14 se reparte otra carta al jugador y se vuelve a calcular los puntos
            if ($players[$index]['score'] < 14)
                $players[$index]['cards'][] = array_pop($deck);
        } while ($players[$index]['score'] < 14);
    }

    // Se muestran los jugadores, su mano y la puntuación obtenida por cada uno
    foreach ($players as $index => $player) {
        if ($index == 0)
            $result = 'banca';
        else
            $result = claculateFinalResult($player['score'], $players[0]['score']);

        echo '<div class="jugador '. $result  .'">';
            echo '<h3>';
                echo 'Jugador '. $index .': '. $player ['name'];
            echo '</h3>';
            echo '<img src="img/players/'. $player['name'] .'.png" alt="'. $player['name'] .'" class="perfilJugador">';
            foreach ($player['cards'] as $card) {
                echo '<img src="img/deck/'. $card['image'] .'" alt="'. $card['value'] .' '. $card['suit'] .'" class="jugada j21"> '; 
            }
            echo '<br>';
            echo '<span class="score">';
                echo 'Puntos: '. $player['score'];
                if ($index != 0) {
                    echo ' - '. ucfirst($result);
                }
            echo '</span>';
        echo '</div>';
        // Se separa la banca del resto
        if ($index==0)
            echo '<br>';
    }

    // Función que recibe un array de cartas y calcula su puntuación.
    function calculateScore (array $cards): int {
        // Primero se suman los valores teniendo en cuenta que el AS vale 1
        $score = 0;
        foreach ($cards as $card) {
            if (in_array($card['value'], ['J', 'Q', 'K']))
                $score += 10;
            else
                $score += $card['value'];
        }

        // Se comprueba si hay algún AS y su valor puede ser 11
        // Es necesario hacerlo así para asegurarse que el AS solo vale 11 si no supera la suma de 21
        foreach ($cards as $card) {
            if ($card['value']==1 && $score+10<=21)
                $score += 10;
        }

        return $score;
    }

    function claculateFinalResult(int $playerScore, int $bankScore): string {
        if ($playerScore > 21)
            $result = 'pierde';
        else if ($playerScore > $bankScore)
            $result = 'gana';
        else if ($playerScore < $bankScore && $bankScore>21)
            $result = 'gana';
        else if ($playerScore < $bankScore)
            $result = 'pierde';
        else
            $result = 'empata';

        return $result;
    }
    ?>
</body>
</html>