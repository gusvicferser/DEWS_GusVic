<?php

/**
 * Página con un array de la clase User
 * con objetos pertenecientes a esa clase:
 * 
 * @author: Gustavo Victor
 * @version: 1.0
 */

 /**
  * Función para comprobar si el nombre de usuario ya existe
  * y si es así, devolverá el objeto con ese nombre. En caso 
  * contrario devuelve null:
  * @author: Gustavo Víctor
  * @param: String con el nombre, array de usuarios.
  * @return: mixed (el objeto si existe, si no devuelve null).
  */

  require_once('User.inc.php');

  function userExists(String $name, array $users): mixed {

    

  }

$users = [
    new User("HomerSimpson", "donuts", "homer@springfield.com"),
    new User("PeterGriffin", "freakinSweet", "peter@quahog.com"),
    new User("RickSanchez", "wubbalubbadubdub", "rick@multiverse.com"),
    new User("StanSmith", "CIAAgent", "stan@langley.com"),
    new User("BenderRodriguez", "bending", "bender@futurama.com"),
    new User("DariaMorgendorffer", "sarcastic", "daria@lawndale.com"),
    new User("Fry", "futurama123", "fry@futurama.com"),
    new User("LisaSimpson", "smartgirl", "lisa@springfield.com"),
    new User("MegGriffin", "loser", "meg@quahog.com"),
    new User("Cartman", "respectmyauthority", "cartman@southpark.com"),
];