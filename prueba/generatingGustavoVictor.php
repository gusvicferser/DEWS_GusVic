<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades 2, 3 y 4</title>
</head>
<body>
    <!-- Actividad 2: un php que genere  una lista  desordenada  de  5 
    elementos,  los  elementos  de  la  lista  deben  contener  el  texto  "sección  X"  siendo  X  el  número 
    correspondiente entre 1 y 5, ese texto debe ser un enlace HTML que vaya a #sec1‐#sec5. -->
        <ul>
        <?php
            for ($i=1;$i<=5;$i++) {
                echo '<li>';
                    echo '<a href="#seccion'. $i .'">Seccion '. $i .'</a>';
                echo '</li>';
                
            }
        ?>
        </u>

    <!-- Generaremos cada artículo con h1 y el título de la sección y el código para realizar las siguientes tareas:

    sec1: dado un número aleatorio entre ‐200 y 200 almacenado en una variable se indicará si ese número es negativo, cero o 
    positivo.-->
        <h1 id="seccion1">Negativo - Cero - Positivo</h1>

        <div>El número 

            <?php   
                $random_number = rand(-200, 200);

                echo $random_number;

                if ($random_number>0) {
            ?>   
            es positivo.

            <?php
                } else if ($random_number<0) {
            ?>

            es negativo.
        
            <?php
                } else {
            ?>

            es igual.

            <?php
            }
            ?>
        </div>

    <!-- sec2:  dada  una  nota  media  entera  aleatoria  entre  0  y  10 
    almacenada en una variable se indicará (usando switch) la nota correspondiente en palabra. 
        De cero a dos incluido: insuficiente 
        Tres y cuatro: necesita mejorar 
        Cinco: aprobado justito 
        Seis: aprobado 
        Siete: notable bajo 
        Ocho: notable 
        Nueve y diez: sobresaliente 
        Cualquier otro valor: valor no válido -->

        <h1 id="seccion2">Nota</h1>
</body>
</html>