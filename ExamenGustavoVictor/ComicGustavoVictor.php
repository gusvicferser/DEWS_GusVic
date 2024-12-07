<?php

/**
 * Ejercicio 1
 * 
 * @author Gustavo Victor
 * @version 1.0
 */

class Comic
{
    private string $author;
    private string $title;
    private string $ended;
    private array $characters = [];

    // Estaba mal la palabra del constructor. Era construct, no constructor:
    public function __construct($author, $title = '', $ended = false)
    {
        $this->author = $author;
        $this->title = $title;
        $this->ended = $ended;
    }

    public function __set($property, $value)
    {
        if (isset($this->$property)) {
            $this->$property = $value;
        }
    }

    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }
    }

    public function __toString()
    {
        // Añadido después del examen para mostrar los personajes:
        $showCarac = join(', ', $this->characters);

        return
            'Autor: ' .
            $this->author .
            '. Comic: ' .
            $this->title .
            '. ¿Está finalizada? ' .
            ($this->ended ? 'Sí ' : 'No ').
            // Añadido después del exámen:
            'Personajes de la obra: '.
            $showCarac;
    }

    // Función para añadir personajes al array:
    public function addCharacter(string $character): bool
    {
        if (!in_array($character, $this->characters)) {
            $this->characters[$character] = $character;
            return true;
        }
        return false;
    }

    // Función para eliminar personajes del array:
    public function removeCharacter(string $character): bool
    {
        if (in_array($character, $this->characters)) {
            unset($this->characters[$character]);
            return true;
        }
        return false;
    }

    // Función para devolver si un personaje está en el array o no:
    public function hasCharacter(string $character): bool
    {
        return in_array($character, $this->characters); // Por las prisas tenía una letra menos
    }
}
