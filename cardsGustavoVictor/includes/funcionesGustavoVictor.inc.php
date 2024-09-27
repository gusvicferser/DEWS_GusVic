<?php

/**
 * Página reservada para las funciones de calcular cuál es mayor de los juegos de cartas.
 * @author: Gustavo Víctor
 * @version: 1.0
 */


/**
 * Función para calcular qué carta es la mayor:
 * @author: Gustavo Víctor
 * @param: El valor en un int de las dos cartas a comparar.
 * @return: Un int, 1 si la primera carta es mayor que la segunda, 0 si es igual y -1 si la segunda carta es mayor.
 * @version: 1.0
 */

function comparar(int $carta1, int $carta2): int
{

    if ($carta1 > $carta2) {
        return 1;
    } else if ($carta1 == $carta2) {
        return 0;
    } else {
        return -1;
    }
}
