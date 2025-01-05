<?php
/**
 * Aplicación web para mostrar la cabecera. Ha de incluír:
 * 
 * El logo de la red social (Ha de contener a su vez un enlace a index.html)
 * Si el usuario no está logueado, un enlace a loguin
 * Si el usuario está logueado, un formulario de búsqueda (campo de texto y botón)
 *  que mandará los datos a la página results y también aparecerá el nombre de
 *  usuario que será un enlace a account y enlaces a new(publicación) y close
 *  (log out).
 * 
 * @author Gustavo Víctor
 * @version 1.0
 */

// Iniciamos sesión:
 require_once($_SERVER['DOCUMENT_ROOT']. '/includes/session.inc.php');

?>

<header>
    <h1><a href="/">TrollNeXt</a></h1>

    <div id="header">
        <?php
        // Si el usuario no está logueado (no existe su variable de sesión): -->
        if (!isset($_SESSION['userName'])) {
            echo
            '<span>
                <p>Únete a la comunidad y comienza a trollear a todos. Sin excepción:</p>
                <a href="/login">Trolléate</a>
                </span>';
            // Fin usuario no logueado -->
        } else {

            //Si el usuario está logueado (existe su variable de sesión): -->
            echo '<div>';
            echo '<form action="/results/" method="get">';
            echo '<input type="text" id="search" name="search" placeholder="¿Qué buscas?"></input>';
            echo '<input type="submit" value="Busca">';
            echo '</form>';
            echo '</div>';
            echo '<div id="usuario">' . $_SESSION['userName'] . '</div>';
            echo '<span id="logout">';
            echo '<a href="/logout">Desconectar</a>';
            echo '</span>';
            // Fin usuario logueado -->
        }
        ?>
    </div>
</header>
