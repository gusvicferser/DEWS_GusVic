<?php

/**
 * Script PHP para crear usuarios:
 * 
 * @author: Gustavo Víctor
 * @version: 1.0 
 */

class User
{
    private string $username;
    private string $password;
    private string $mail;
    private bool $logged = false;

    public function __construct(string $username, string $password, string $mail)
    {

        $this->username = $username;
        $this->password = $password;
        $this->mail = $mail;
    }

    public function __get($property)
    {

        return $this->$property;
    }

    public function __set($property, $value)
    {

        $this->$property = $value;
    }

    public function login(string $password): bool
    {
        if($this->logged) {
            return false;
        } else {
            if($this->password==$password) {
                
            }
        }


        return false;
    }

    public function logout() {}

    public function toString(): string
    {

        return $this->username . '(' . $this->mail . ')';
    }
}
