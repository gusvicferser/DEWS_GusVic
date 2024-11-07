<?php

/**
 * Página creada para la clase Hero, que ha de contener los atributos 
 * listados en el diagrama de clases y los métodos que se especifican más 
 * abajo:
 * 
 * @author: Gustavo Víctor
 * @version: 1.3
 */

class Hero
{
    private string $name;
    private string $species;
    private string $class;
    private int $health;
    private int $baseAttack;
    private int $baseDefense;
    private array $weapons;
    private Armor $armor;
    private array $potions;

    function __construct(
        $name,
        $species,
        $class,
        $health = 50,
        $baseAttack = 10,
        $baseDefense = 10
    ) {

        $this->name = $name;

        /* Hemos de chequear que la especie esté entre las opciones disponibles:
         y si no se encuentra entre ellas, será 'Humano' la clase por defecto:*/
        /* if ($this->checkSpecies($species)) {
                $this->species = $species;
            } else {
                $this->species = 'Humano';
            }*/

        $this->species = $this->checkSpecies($species) ? $species : 'Humano';

        /* También hemos de verificar que la clase sea la correcta y si no, 
         ponemos que es ninguna:*/
        /* if ($this->checkClass($class)) {
                $this->class = $class;
            } else {
                $this->class = 'Ninguna';
            }*/

        $this->class = $this->checkClass($class) ? $class : 'Ninguna';
        /* La salud no será ni un número negativo ni cero:*/
        /*if ($health > 0) {
            $this->health = $health;
        } else {
            $this->health = 1;
        }*/

        $this->health = ($health > 0) ? $health : 1;

        /* El ataque base no puede ser negativo (al crear el objeto héroe): */
        /*if ($baseAttack > 0) {
                $this->baseAtack = $baseAttack;
            } else {
                $this->baseAtack = 0;
        }*/

        $this->baseAttack = ($baseAttack > 0) ? $baseAttack : 0;

        /* La defensa tampoco (al crear el héroe):*/
        /*if ($baseDefense > 0) {
            $this->baseDefense = $baseDefense;
        } else {
            $this->baseDefense = 0;
        }*/

        $this->baseDefense = ($baseDefense > 0) ? $baseDefense : 0;
    }

    function __get($property)
    {
        if (isset($property)) {
            return $this->$property;
        }
    }

    function __set($property, $value)
    {
        if (isset($property)) {
            $this->$property = $value;
        }
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

    /**
     * Función pública para añadir armas al héroe siempre que no lleve ya dos
     * (Que es el máximo permitido):
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param: Weapon $weapon
     * @return: bool (true si lo ha hecho, false si no)
     */
    function addWeapon(Weapon $weapon): bool
    {
        if (count($this->weapons) < 2) {
            array_push($this->weapons, $weapon);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Función pública para eliminar armas (que existan y que lleve el héroe) 
     * al héroe en cuestión:
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param: Weapon $weapon
     * @return: bool (true si lo ha hecho, false si no)
     */
    function removeWeapon(Weapon $weapon): bool
    {

        if (in_array($weapon, $this->weapons)) {
            $key = array_search($weapon, $this->weapons);
            if (is_int($key)) {
                $this->weapons = array_splice($this->weapons, $key, $key);
                return true;
            }
        }

        return false;
    }

    /**
     * Función pública para atacar que suma el daño base del héroe con el int de
     * ataque de todas sus armas:
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @return: int (el daño total)
     */
    function attack(): int
    {

        $dmg = $this->baseAttack;

        if (count($this->weapons) > 0) {
            foreach ($this->weapons as $weapon) {
                $dmg += $weapon->get('attack');
            }
        }

        return $dmg;
    }

    /**
     * Función pública para defenderse que suma las defensas y luego le resta el
     * daño hecho:
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param:int (daño realizado)
     * @return: int (el daño recibido)
     */
    function defense(int $dmg): int
    {



        if (count($this->weapons) > 0) {
            foreach ($this->weapons as $weapon) {
                $dmg += $weapon->attack;
            }
        }

        return $dmg;
    }

    /**
     * Función pública para eliminar la armadura al héroe en cuestión:
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @return: bool (true si lo ha hecho, false si no)
     */
    function removeArmor(): bool
    {

        if ($this->armor != null) {
            $this->armor = null;
            return true;
        }

        return false;
    }

    /**
     * Función pública para añadir pociones al héroe siempre que no lleve ya
     * tres (Que es el máximo permitido):
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @param: Potion $potion
     * @return: bool (true si lo ha hecho, false si no)
     */
    function addPotion(Potion $potion): bool
    {
        if (count($this->potions) < 3) {
            //array_push($this->potions, $potion);
            $this->potions[] = $potion;

            for ($i=0; $i<count($this->potions); $i++) {
                $minPosition = $i;
                $minValue=$this->potions[$i];
                for ($j=$i+1; $j<count($this->potions); $j++) {
                    if ($this->potions[$j]<$minValue) {
                        $minValue = $this->potions[$j];
                        $minPosition = $j;
                    }
                }

                if ($i!=$minPosition) {
                    $aux = $this->potions[$i];
                    $this->potions[$minPosition] = $this->potions[$i];
                    $this->potions[$i] = $aux;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Función pública para usar pociones (si el héroe tiene alguna). En caso de
     * tener varias, usará la que más HP cure:
     * 
     * @author: Gustavo Víctor
     * @version: 1.1
     * @return: bool (true si lo ha hecho, false si no)
     */
    function usePotion()
    {
        if (count($this->potions) > 0) {
            $usedPotion = array_pop($this->potions);
            $this->health += $usedPotion->health;
        }
    }

    function __toString()
    {
        return $this->name . ': ' . $this->species . ', '
            . $this->class . ', ' . $this->health . ' HP';
    }
}
