<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación</title>
</head>
<body>
    <?php
    /**
     * Prueba de PHPDoc:
     * 
     */
        $name = 'MARIO!!!!!';
        $username = 'Tremendo código';
        echo 'Hola, soy yo '. $name;
        ?>

    <h1>Hola
        <?php 
            // Esto es igual a lo de abajo:
            echo $username;
        ?>
    </h1>

    <h1>Hola <?=$username?></h1>

</body>
</html>