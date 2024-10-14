<?php

/**
 * Actividad 01 del tema 3: Introduciendo datos en el almacén.
 * 
 * Página para procesar los datos.
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 */

    echo 'El producto de código ';
    echo $_POST['code'];
    echo ' y nombre ';
    echo $_POST['name'];
    echo ' vale ';
    echo $_POST['cost'];
    echo '€, se trata de ';
    echo $_POST['descrip'];
    echo ' cuyo fabricante es ';
    echo $_POST['maker'];
    echo ' adquirido en la fecha ';
    echo $_POST['date'];

?>

