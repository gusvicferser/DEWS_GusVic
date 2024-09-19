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
                echo '<a href="#secc'. $i .'">Seccion '. $i .'</a>';
            echo '</li>';
            
        }
    ?>
    </u>

<!-- -->
</body>
</html>