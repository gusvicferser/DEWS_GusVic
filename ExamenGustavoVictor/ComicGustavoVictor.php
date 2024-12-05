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

    public function __constructor($author, $title = '', $ended = false)
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
        return
            'Autor: ' .
            $this->author .
            '. Comic: ' .
            $this->title .
            '. ¿Está finalizada? ' .
            ($this->ended ? 'Sí' : 'No');
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
        return in_array($character, $this->caracters);
    }
}
