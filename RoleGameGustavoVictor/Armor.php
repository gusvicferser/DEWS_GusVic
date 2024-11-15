<?php
/**
 * Página creada para la subclase Armor, que ha de contener los atributos 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.1
 */

 class Armor{

    private string $name;
    private int $defense;

    function __construct($name, $defense)
    {
        $this -> name = $name;
        $this -> defense = $defense;
        
    }

    function __get($property){
        if(isset($property)){
        return $this -> $property;
        }
    }

    function __set($property, $value){
        if(isset($property) && is_int($value)) {
            $this -> $property = $value;
        }
    }

    function __toString(){
        return $this -> name . ' (+' . $this->defense . ' DEF)';
    }
 }