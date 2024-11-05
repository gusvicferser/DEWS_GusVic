<?php
/**
 * Página creada para la clase Hero, que ha de contener los atributos 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.0
 */

 class Hero {

    private string $name;
    private string $species;
    private string $class;
    private int $health;
    private int $baseAttack;
    private int $baseDefense;

    function __construct(
        $name, 
        $species, 
        $class, 
        $health = 50, 
        $baseAttack = 10,
        $baseDefense = 10 )
    {
        $this -> name = $name;
        $this -> species = $species;
        $this -> class = $class;
        
        
    }

 }