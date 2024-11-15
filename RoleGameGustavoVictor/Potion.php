<?php

/**
 * Página creada para la subclase Potion, que ha de contener el atributo 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.1
 */

class Potion
{

    private int $health;

    function __construct($health)
    {
        /* A menos que no sea una poción de veneno, no tiene sentido que quite
         vida, así que lo dejo a cero:*/
        if ($health > 0) {
            $this->health = $health;
        } else {
            $this->health = 0;
        }
    }

    function __get($property)
    {
        if (isset($property)) {
            return $this->$property;
        }
    }

    function __set($property, $value)
    {
        if (isset($property) && is_int($value)) {
            $this->$property = $value;
        }
    }

    function __toString()
    {
        return '+ ' . $this->health . ' HP';
    }
}
