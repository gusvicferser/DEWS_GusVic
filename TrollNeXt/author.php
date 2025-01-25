<?php

/**
 * Aplicación web para mostrar al autor. Es decir, yo. Ha de incluir:
 * 
 * Nombre del creador
 * Foto de mí
 * 
 * (HECHO)
 * 
 * @author Gustavo Víctor
 * @version 1.3
 */

// Iniciamos la sesion:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.inc.php');

// Cargamos las variables:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?= CSS_LINK ?>
   <?= BOOT_LINK ?>
   <title>Author</title>
</head>

<body>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
   ?>
   <div class="d-flex flex-column justify-content-center align-items-center">
      <div>
         <h1 class="text-warning fw-bold">Gustavo Víctor (El creador)</h1>
      </div>
      <div>
         <img src="/img/gus.jpg" alt="gus.jpg" width="400px">
      </div>
   </div>
   <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
   ?>
</body>

</html>