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
    <title>Hobbies</title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>

<body>
    <?php
        require_once(__DIR__.'/includes/header.inc.php')
    ?>

    <div class="contingente">
        <div class="targeta">
            <figure>
                <img src="images/master.jpg" alt="D&D">
            </figure>
            <div class="texto">
                <h3>JUGADOR DE ROL DE MESA</h3>
                <p>Hechiceros malvados con carisma,
                    Guerreros con la ilusión de un niño, Clérigos corruptos.
                    ¡Cuanto mayor es el objetivo, mayor la diversión!</p>
            </div>
        </div>
        <div class="targeta">
            <figure>
                <img src="images/videogames.jpg" alt="Mendo de consola">
            </figure>
            <div class="texto">
                <h3>VIDEOJUEGOS</h3>
                <p>Me apasionan los videojuegos desde que mis padres compraron mi primer juego, Pokemon amarillo.
                    Desde entonces he jugado infinidad de títulos, tanto triples A como Indies.
                </p>
            </div>
        </div>
        <div class="targeta">
            <figure>
                <img src="images/catan.jpg" alt="catan">
            </figure>
            <div class="texto">
                <h3>JUEGOS DE MESA</h3>
                <p>Soy un apasionado de los juegos de mesa, desde el más simple a los más complicados Eurogames de
                    gestión
                    de recursos, ¡un estratega y muy buen jugador!
                </p>
            </div>
        </div>
    </div>

    <?php
        require_once(__DIR__.'/includes/footer.inc.php')
    ?>

</body>

</html>