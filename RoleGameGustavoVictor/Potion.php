<?php

/**
 * Página creada para la subclase Potion, que ha de contener el atributo 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.0
 */

class Potion
{

    private int $health;

    function __construct($health)
    {
        $this->health = $health;
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
