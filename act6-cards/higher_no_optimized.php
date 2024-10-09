<?php
/**
 * Script para el juego de La carta más alta
 *
 * @author Álex Torres
 * @version 1.0
 *
 */

$title = "Carta más alta (No optimizado)";
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

    // Se crea una constante para la cantidad de cartas a repartir
    const QUANTITY_OF_CARDS_IN_HAND = 10;
    // Se crea un array de nombres para que cada partida los jugadores sean aleatorios
    $players = ['Bender', 'Fry', 'Leela', 'Zoidberg', 'Rick', 'Morty', 'Jerry', 'Beth', 'Summer', 'Peter', 'Brian', 'Quagmire'];
    shuffle($players);
    $player1 = array_pop($players);
    $player2 = array_pop($players);

    // Se incluye el archivo que contiene el array con todas las cartas de la baraja
    require_once('includes/deck.inc.php');
    // Se ordena aleatoriamente la baraja con la función shuffle
    $barajar = shuffle($deck);
    // Se reparten diez cartas a cada jugador yendo uno por uno
    for ($i=0;$i<QUANTITY_OF_CARDS_IN_HAND;$i++) {
        $player1hand[$i] = array_pop($deck);
        $player2hand[$i] = array_pop($deck);
    }
    
    // Se calculan las puntuaciones de cada jugador
    $player1score = 0;
    $player2score = 0;
    for ($i=0;$i<QUANTITY_OF_CARDS_IN_HAND;$i++) {
        if (cardValue($player1hand[$i]['value']) > cardValue($player2hand[$i]['value'])) {
            $player1score += 2;
            $player1hand[$i]['style'] = "gana";
        } else if (cardValue($player1hand[$i]['value']) < cardValue($player2hand[$i]['value'])) {
            $player2score += 2;
            $player2hand[$i]['style'] = "gana";
        } else {
            $player1score++;
            $player1hand[$i]['style'] = "empata";
            $player2score++;
            $player2hand[$i]['style'] = "empata";
        }
    }

    // Se muestran las manos de cada jugador
    echo '<div><h3>Jugador 1: '. $player1 .'</h3>';
    echo '<img src="img/players/'. $player1 .'.png" alt="'. $player1 .'" class="perfilJugador">';
    foreach ($player1hand as $card) {
        $scoreStyle = $card['style'] ?? "";
       echo '<img src="img/deck/'. $card['image'] .'" alt="'. $card['value'] .' '. $card['suit'] .'" class="jugada alta '. $scoreStyle .'">'; 
    }
    echo '</div>';
    echo '<div><h3>Jugador 2: '. $player2 .'</h3>';
    echo '<img src="img/players/'. $player2 .'.png" alt="'. $player2 .'" class="perfilJugador">';
    foreach ($player2hand as $card) {
        $scoreStyle = $card['style'] ?? "";
       echo '<img src="img/deck/'. $card['image'] .'" alt="'. $card['value'] .' '. $card['suit'] .'" class="jugada alta '. $scoreStyle .'">'; 
    }
    echo '</div>';

    // Se muestran las puntuaciones y el resultado de la partida
    echo '<h3>Resultado de la partida:</h3>';
    echo $player1 .': '. $player1score .' puntos<br>';
    echo $player2 .': '. $player2score .' puntos<br>';

    echo '<div class="jugador">';
        if ($player1score > $player2score) {
            echo 'Gana: '. $player1 .'<br>';
            echo '<img src="img/players/'. $player1 .'.png" alt="'. $player1 .'" class="perfilJugador">';
        } else if ($player1score < $player2score) {
            echo 'Gana: '. $player2 .'<br>';
            echo '<img src="img/players/'. $player2 .'.png" alt="'. $player2 .'" class="perfilJugador">';
        } else {
            echo 'Empate<br>';
            echo '<img src="img/players/'. $player1 .'.png" alt="'. $player1 .'" class="perfilJugador">';
            echo '<img src="img/players/'. $player2 .'.png" alt="'. $player2 .'" class="perfilJugador">';
        }
    echo '</div>';

    function cardValue(string $value): int {
        if ($value == "J")
            return 11;
        else if ($value == "Q")
            return 12;
        else if ($value == "K")
            return 13;
        else
            return intval($value);
    }
    ?>
</body>
</html>