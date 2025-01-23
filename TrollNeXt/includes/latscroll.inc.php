<?php

/**
 * Include para la barra lateral donde se vean los seguidores. Ha de cumplir:
 * 
 * 1. Se muestran todos los seguidores del usuario:
 * 
 * @author Gustavo Víctor
 * @version 1.2
 */

?>

<div class="lateral_scroll">
    <?php
    if (isset($_SESSION['user_fol']) && !empty($_SESSION['user_fol'])) {
        foreach ($_SESSION['user_fol'] as $followed) {
            echo
            '<div class="followed" id="fol' .
                $followed->fol_id .
                '">';
            echo '<div>';
            echo
            '<a href="/user/' .
                $followed->fol_id .
                '">' .
                $followed->fol_name .
                '</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="followed">';
        echo 'No sigues a nadie... todavía. ¿Qué esperas, una señal?';
        echo '</div>';
    }
    ?>
</div>