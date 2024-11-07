<?php

/**
 * Página creada para la clase Hero, que ha de contener los atributos 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.1
 */

class Hero
{

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
        $baseDefense = 10
    ) {
        $this->name = $name;
        
        if ($this->checkSpecies($species)) {
            $this->species = $species;
        } else {
            $this->species = 'Humano';
        }

        if ($this->checkClass($class)) {
            $this->class = $class;
        } else {
            $this->class = 'Ninguna';
        }

        if ($health > 0){
            $this->health = $health;
        } else {
            $this->health = 1;
        }

        if ($baseAttack > 0){
            $this->baseAtack = $baseAttack;
        } else {
            $this->baseAtack = 0;
        }

        if ($baseDefense > 0){
            $this->baseDefense = $baseDefense;
        } else {
            $this->baseDefense = 0;
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
        return $this->name . ': ' . $this->species . ', ' . $this->class . ', ' . $this->health . ' HP';
    }

    /**
     * Función privada para comprobar la especie de las disponibles. Devuelve un 
     * booleano (verdadero si está, falso si no está).
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param: string
     * @return: bool 
     */
    private function checkSpecies($race)
    {

        $races =
            [
                'Altmer',
                'Argoniano',
                'Bosmer',
                'Bretón',
                'Dunmer',
                'Guardia rojo',
                'Imperial',
                'Khajiita',
                'Nórdico',
                'Orsimer'

            ];

        return in_array($race, $races);
    }

    /**
     * Función privada para comprobar la clase del PJ entre las disponibles. 
     * Devuelve un booleano (verdadero si está, falso si no está).
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param: string
     * @return: bool 
     */
    private function checkClass($class)
    {

        $classes =
            [
                'Agente',
                'Arquero',
                'Asesino',
                'Bárbaro',
                'Brujo',
                'Caballero',
                'Guerrero',
                'Ladrón',
                'Mago',
                'Monje'

            ];

        return in_array($class, $classes);
    }
}
