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
function creacionBaraja(): array
{

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

    return $deck;
}

/**
 * Función para crear un array de jugadores con nombres y fotos:
 * @author: Gustavo Víctor
 * @param: int del número de jugadores.
 * @return: Tantos jugadores como pidan.
 */

 function jugadores(int $numJugadores): array {

    // $jugadores = ['nombres' => ]


    return $jugadores;
 }
