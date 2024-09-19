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
    <title>Index</title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>

<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
    ?>

    <div class="contingente">
        <div class="targeta">
            <a href="cv.php">
                <figure>
                    <img src="/images/yop.jpg" alt="Yo mismo">
                </figure>
                <div class="texto">
                    <h3>CV</h3>
                    <p>Desarrollador de Aplicaciones Web, Escritor y Desarrollador de videojuegos amateur,
                        Hay pocas cosas que se me escapen y como persona con curiosidad por muchos campos,
                        me encanta aprender un poco de todo.
                        ¡Descubre un poco más de mí en este apartado!</p>
                </div>
            </a>
        </div>
        <div class="targeta">
            <a href="hobbies.php">
                <figure>
                    <img src="/images/yop_mexican.jpg" alt="Sombrero Mexicano">
                </figure>
                <div class="texto">
                    <h3>HOBBIES</h3>
                    <p>Game Master, Diseñador de juegos de mesa, Animador de fiestas y eventos en general.
                       ¡Soy el alma de la fiesta, descúbrelo aquí!

                    </p>
                </div>
            </a>
        </div>
        <div class="targeta">
            <a href="trabajos.php">
                <figure>
                    <img src="/images/yop_agente_fbi.jpg" alt="Infiltrado FBI">
                </figure>
                <div class="texto">
                    <h3>TRABAJOS REALIZADOS</h3>
                    <p>He trabajado en un poco de todo, desde coordinador de tierra para diversas compañías,
                        pasando por repartidor en moto o Game Master en un Escape Room en Valencia
                        ¡Soy capaz de adaptarme a todo!</p>
                </div>
            </a>
        </div>
    </div>

    <?php
    
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
    ?>
</body>

</html>