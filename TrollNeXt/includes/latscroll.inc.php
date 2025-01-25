<?php

/**
 * Include para la barra lateral donde se vean los seguidores. Ha de cumplir:
 * 
 * 1. Se muestran todos los seguidores del usuario:
 * 
 * @author Gustavo Víctor
 * @version 1.3
 */

?>
    <div class="col-lg-3 p-3 d-flex flex-column text-center gris">
        <h4>Estás siguiendo a:</h4>
        <?php
        
        if (isset($_SESSION['user_fol']) && !empty($_SESSION['user_fol'])) {
            foreach ($_SESSION['user_fol'] as $followed) {
                echo '<div 
                    class="d-flex flex-column text-center" 
                    id="fol'.$followed->fol_id .'">';
                echo
                '<a 
                    class="fw-bold text-center text-warning"
                    href="/user/' .
                    $followed->fol_id .
                    '">' .
                    $followed->fol_name .
                    '</a>';
                echo '</div>';
            }
        } else {
            ?>
            <div class="followed text-warning fw-bold">
            No sigues a nadie... todavía. ¿Qué esperas, una señal?
            </div>
        <?php
        }
        ?>
    </div>
