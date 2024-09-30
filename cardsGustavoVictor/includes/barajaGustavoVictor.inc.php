<?php

/**
 * Página reservada para crear la baraja y para repartir las cartas a los jugadores de los juegos de cartas.
 * @author: Gustavo Víctor
 * @version: 1.0
 */

/**
 * Función para crear la baraja. Devuelve un array con las cartas:
 * @author: chatGPT
 * @return: Un array de cartas con el palo, el valor y la imagen asociada.
 */
function createDeck(): array {

    $suits = [
        "corazones" => "cor",
        "rombos" => "rom",
        "treboles" => "tre",
        "picas" => "pic"
    ];

    $values = [
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "10",
        "J",
        "Q",
        "K"
    ];

    //$deck = [];

    foreach ($suits as $suit => $prefix) {
        foreach ($values as $value) {
            $deck[] = [
                "suit" => $suit,
                "value" => $value,
                "image" => "{$prefix}_{$value}.png"
            ];
        }
    }

    shuffle($deck);

    return $deck;
}

/**
 * Función para crear un array de jugadores con nombres y fotos:
 * @author: Gustavo Víctor
 * @param: int del número de jugadores.
 * @return: Tantos jugadores como pidan en un mismo array.
 */

function createPlayers(int $playerNum): array {

    $possiblePlayers = [['nombre' => 'Agallas', 'punctuation' => 0, 'avatar' => 'agallas.jpg'], 
                ['name' => 'Dexter', 'punctuation' => 0, 'avatar' => 'dexter.png'], 
                ['name' => 'Ed, Edd y Eddy', 'punctuation' => 0, 'avatar' => 'eddies.jpg'], 
                ['name' => 'Supernenas', 'punctuation' => 0, 'avatar' => 'supernenas.jpg'], 
                ['name' => 'Jake el Perro', 'punctuation' => 0, 'avatar' => 'jake.jpg'], 
                ['name' => 'Mandy', 'punctuation' => 0, 'avatar' => 'mandy.png'], 
                ['name' => 'Samurai Jack', 'punctuation' => 0, 'avatar' => 'samurai.png'], 
                ['name' => 'Jonnhy Bravo', 'punctuation' => 0, 'avatar' => 'bravo.jpg']
    ];

    shuffle($possiblePlayers);

    for ($i=0;$i<$playerNum;$i++) {

        $players[] = array_pop($possiblePlayers);      
        
    }

    return $players;
}
