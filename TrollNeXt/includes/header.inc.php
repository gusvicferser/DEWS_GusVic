<?php

/**
 * Aplicación web para mostrar la cabecera. Ha de incluír:
 * 
 * El logo de la red social (Ha de contener a su vez un enlace a index.html)
 *  (TO DO)
 * 
 * Si el usuario no está logueado, un enlace a loguin
 *  (HECHO)
 * 
 * Si el usuario está logueado, un formulario de búsqueda (campo de texto y botón)
 *  que mandará los datos a la página results y también aparecerá el nombre de
 *  usuario que será un enlace a account y enlaces a new(publicación) y close
 *  (log out).
 * 
 *  (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.3
 */
?>

<header>
    <nav>
        <h1><a href="/">TrollNeXt</a></h1>

        <div id="header">
            <?php
            // Si el usuario no está logueado (no existe su variable de sesión): -->
            if (!isset($_SESSION['user_name'])) {
                echo
                '<span>
                <p>¡Únete a la comunidad y comienza a trollear!</p>
                <a href="/login">Trolléate</a>
                </span>';
                // Fin usuario no logueado -->

                //Si el usuario está logueado (existe su variable de sesión): -->
            } else {
                echo '<div>';
                echo '<form action="/results.php" method="GET">';
                echo '<input type="text" id="search" name="search" placeholder="¿Qué buscas?"></input>';
                echo '<input type="submit" value="Busca">';
                echo '</form>';
                echo '</div>';
                echo '<span id="usuario">';
                echo '<a href="/account">';
                echo $_SESSION['user_name'] . '</a> '; 
                echo '</span>';
                echo '<span id="newPost">';
                echo '<a href="/new">Nueva Publicación</a> ';
                echo '</span>';
                echo '<span id="closeOut">';
                echo '<a href="/close">Desconectar</a> ';
                echo '</span>';
                // Fin usuario logueado -->
            }
            ?>
        </div>
    </nav>
</header>