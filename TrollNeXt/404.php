<?php
/**
 * Página para todo aquello a lo que traten de acceder y que no exista en el 
 * servidor:
 * 
 * @author Gustavo Víctor
 * @version 3.1 
 */

// Cargamos las variables:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=CSS_LINK?>
    <?=BOOT_LINK?>
    <title>You got trolled!</title>
</head>
<body>
    <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
?>
<div class="d-flex flex-column justify-content-center align-items-center">
      <div>
          <h1 class="text-warning fw-bold">
            ¡Has sido troleado por alguien y no existe lo que buscas!
        </h1>
      </div>
      <div>
          <a 
            class="align-self-center text-warning fw-bold" 
            href=/contact target="_blank"
            >
            <img src="img/TrollNeXt.png" alt="TrollNeXt" width="800px">
        </a>
      </div>
      <div>
          <a class="text-warning fw-bold" href="/">Volver al index</a>
      </div>
   </div>
    <?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
   ?>
</body>
</html>