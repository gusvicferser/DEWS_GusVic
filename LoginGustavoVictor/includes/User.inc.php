<?php

/**
 * Script PHP para crear usuarios:
 * 
 * @author: Gustavo Víctor
 * @version: 1.3 
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

    /**
     * Función mágica 'get' para obtener un atributo, excepto si es logged:
     * 
     * @author: Gustavo Víctor
     * @version: 1.1
     * @param: parametro a obtener su atributo.
     * @return: atributo pedido.
     */
    public function __get($property)
    {
        if (isset($this->$property)) {
            if ($property != 'logged') {
                return $this->$property;
            }
        }
    }

    /**
     * Función mágica 'set' para cambiar un atributo, excepto si es logged. 
     * En el if nos aseguraremos de que sea un valor correcto para la propiedad,
     * ya que todos los atributos del objeto son strings (para evitar introducir 
     * un objeto y que de fallo):
     * 
     * @author: Gustavo Víctor
     * @version: 1.2
     * @param: parametro a cambiar su atributo (normalmente string) y el valor del atributo.
     */
    public function __set($property, $value)
    {
        if (isset($this->$property)) {
            if ($property != 'logged' && is_string($value)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Función para cambiar el atributo logged si el usuario existe 
     * y no está loggeado previamente. Si la contraseña es correcta, 
     * se loggea y devuelve true. En cualquier otro caso, devuelve false.
     * 
     * @author: Gustavo Víctor
     * @version: 1.2
     * @param: String con la contraseña
     * @return: boolean
     */

    public function login(string $password): bool
    {
        if ($this->logged) {
            return false;
        } else {
            if ($this->password == $password) {
                $this->logged = true;
                return true;
            }
        }
        return false;
    }

    /**
     * Función para quitar la sesión activa a alguien.
     * 
     * @author: Gustavo Víctor
     * @version: 1.1
     * @return: boolean
     */
    public function logout(): bool
    {
        $this->logged = false;

        if ($this->logged == false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Función para devolver en string el nombre de usuario y su email.
     * 
     * @author: Gustavo Víctor
     * @version: 1.0
     * @return: String (Usuario+Mail)
     */
    public function toString(): string
    {
        return $this->username . '(' . $this->mail . ')';
    }
}
