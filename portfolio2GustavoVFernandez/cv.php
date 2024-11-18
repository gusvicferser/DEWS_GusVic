<?php
    /**
     * Adaptación de la página en HTML a versión PHP:
     * @author: Gustavo Víctor
     * @version: 2.0
     */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>

<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php')
    ?>

    <div class="tabla">
        <div class="trabajos">
            <img src="images/html5.png" alt="html5">
            <div class="texto">
                <h2>HTML5</h2>
            </div>
            <img src="images/css3.png" alt="css3">
            <div class="texto">
                <h2>CSS</h2>
            </div>
        </div>
        <div class="trabajos">
            <img src="images/jvs.png" alt="JavaScript">
            <div class="texto">
                <h2>JavaScript</h2>
            </div>
            <img src="images/java.png" alt="Java">
            <div class="texto">
                <h2>Java</h2>
            </div>
        </div>
    </div>

    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php')
    ?>

</body>

</html>