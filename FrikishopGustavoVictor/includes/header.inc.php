<?php

/**
 * Aplicación web para mostrar la cabecera modificada para que sea vea 
 * una parte o toda en función de la cuenta que tenga el usuario:
 * 
 * @author (Corrección) Gustavo Víctor
 * @version 1.1
 */

?>
<header>
    <h1><a href="/">MerchaShop</a></h1>

    <a href="/">Principal</a>

    <div id="zonausuario">
        <?php
        // Si el usuario no está logueado (no existe su variable de sesión): -->
        if (!isset($_SESSION['userName'])) {
            echo
            '<span>¿Ya tienes cuenta? 
                    <a href="/login">Loguéate aquí</a>
                </span>';
            // Fin usuario no logueado -->
        } else {

            //Si el usuario está logueado (existe su variable de sesión): -->
            echo '<div id="usuario">' . $_SESSION['userName'] . '</div>';
            // Solo si el usuario es administrador -->
            if ($_SESSION['rol'] === 'admin') {
                echo '<a href="/users">Ver usuarios</a>';
                echo '<br>';
            }
            echo '<span id="logout">';
            echo '<a href="/logout">Desconectar</a>';
            echo '</span>';
            // Fin usuario logueado -->
        }
        ?>

    </div>
</header>