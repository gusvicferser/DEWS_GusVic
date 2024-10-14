<?php

/**
 * Actividad 01 del tema 3: Introduciendo datos en el almacén.
 * 
 * Página con el formulario
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 */

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gustavo Víctor</title>
 </head>
 <body>
    
    <form action="/processGustavoVictor.php" method="post">
        
        <fieldset>
            <legend><h1>Pon aquí tus datos...</h1></legend>
            <label for="code">Código:</label>
            <input type="text" name="code" id="code"><br>
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name"><br>
            <label for="cost">Precio:</label>
            <input type="text" name="cost" id="cost"><br>
            <label for="descrip">Descripción:</label>
            <input type="text" name="descrip" id="descrip"><br>
            <label for="maker">Fabricante:</label>
            <input type="text" name="maker" id="maker"><br>
            <label for="date">Fecha de adquisición:</label>
            <input type="text" name="date" id="date"><br><br>
            <input type="submit" value="Envía">
        </fieldset>
    </form>


 </body>
 </html>