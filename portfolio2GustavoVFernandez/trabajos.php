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
    <title>Trabajos realizados</title>
    <link rel="stylesheet" href="/css/estilo.css">
</head>

<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
    ?>
    
        <div class="trabajos">
            <img src="images/coordinador.jpg" alt="coordinador">
            <div class="texto">
                <h2>Coordinador de Tierra</h2>
                <p>Encargado de atender a los aviones en el aeropuerto de Palma para diversas compañías</p>
            </div>
        </div>
        <div class="trabajos">
            <img src="images/repartidor_pizza.jpg" alt="repartidor de pizza">
            <div class="texto">
                <h2>Repartidor de Pizzas a Domicilio</h2>
                <p>Llevando felicidad y buena comida a tu mismísima puerta</p>
            </div>
        </div>
        <div class="trabajos">
            <img src="images/candado.jpg" alt="game master">
            <div class="texto">
                <h2>Game Master</h2>
                <p>¿Crees que puedes escapar de mí? ¡Ponte a prueba!</p>
            </div>
        </div>

    <?php
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
    ?>
</body>

</html>