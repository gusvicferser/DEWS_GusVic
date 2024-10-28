<?php
/**
 * Ejercicio de Login para loggear a un usuario con usuario, password y lista de usuarios a parte:
 * 
 * @author: Gustavo Víctor
 * @version: 1.0
 */



 ?>

 <!DOCTYPE html>
 <html lang="es">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede a la web</title>
 </head>
 <body>
    
    <form action="#" method="post">
        <fieldset>
            <legend>
                <h1>¡Loggeate!</h1>
            </legend>
            <label for="user">User</label><br>
            <input type="text" name="user" value="<?=$_POST['user']??''?>"><br>
            <label for="password">Password</label><br>
            <input type="text" name="password" value="<?=$_POST['password']??''?>"><br><br>
            <input type="button" type="submit" value="Acceder">
        </fieldset>
    </form>

 </body>
 </html>