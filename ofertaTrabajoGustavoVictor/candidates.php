<?php

/**
 * Archivo para mostrar a todos los candidatos con su foto y su marca de agua:
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 */

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
</head>

<body>


    <div class="titulo">
        <h1>CANDIDATOS</h1>
    </div>
    <div class="container">
        <?php

        // Tomamos la carpeta donde están las fotografías en pequeño:
        $imagesSet = scandir($_SERVER['DOCUMENT_ROOT'] . '/images/candidates/');

        // echo '<pre>';
        // echo print_r($imagesSet);
        // echo '</pre>';


        // Creamos una expresión regular para descartar las fotos que no sea de thumbnail:
        $reg_exp = '/-thumbnail\.png$/';

        // Hacemos un bucle for each para colocar cada imagen:
        foreach ($imagesSet as $image) {

            // Con este if descartamos los ./ y ../ que también se incluyen en el scandir:
            if (preg_match($reg_exp, $image)) {
                echo '<span>';
                echo '<img src="watermark.php?img=' . $image . '" alt="' . $image . '">';
                echo '<p>' . $image . '</p>';
                echo '</span>';
            }
        }
        ?>
    </div>
    </div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');

    ?>
</body>

</html>