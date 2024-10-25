<?php

/**
 * Aplicación para guardar los datos de un candidato para una oferta de trabajo
 * (Usuario, nombre, apellidos, DNI, dirección, mail, teléfono y fecha de nacimiento)
 * Se añade la foto y el cv en pdf.
 * 
 * @author = Gustavo Víctor
 * @version = 1.5
 */

// Aquí enlazamos con un include para tener separada la lógica de la visualización y tenerlo todo más limpio:
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/checksGustavoVictor.inc.php');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="errores">
        <div><?= $errors['user'] ?? '' ?></div>
        <div><?= $errors['name'] ?? '' ?></div>
        <div><?= $errors['lastName1'] ?? '' ?></div>
        <div><?= $errors['lastName2'] ?? '' ?></div>
        <div><?= $errors['dni'] ?? '' ?></div>
        <div><?= $errors['address'] ?? '' ?></div>
        <div><?= $errors['mail'] ?? '' ?></div>
        <div><?= $errors['tlf'] ?? '' ?></div>
        <div><?= $errors['birthDate'] ?? '' ?></div>
        <div><?= $errors['photo'] ?? '' ?></div>
        <div><?= $errors['cv'] ?? '' ?></div>
        <div><?= $errors['files'] ?? '' ?></div>
        <div><?= $errors['move'] ?? '' ?></div>
        <div><?= $errors['resize'] ?? '' ?></div>
        <div><?= $errors['moveSmall'] ?? '' ?></div>
        <div><?= $errors['hack'] ?? '' ?></div>
    </div>

    <?php

    /* Arriba hay un apartado en el cual ponemos los errores en diferentes divs por si queremos
     * ajustar posteriormente el estilo. Luego abajo un if en el cual si no hay errores y hay información
     * guardada en el array de $_POST, entonces ponemos el h1 con la frase dada. De lo contrario, mostramos el 
     * formulario con la información que ya han puesto, para que la corrijan.
     */

    if (empty($errors) && !empty($_POST) && !empty($_FILES)) {
        echo '<h1>Usuario registrado correctamente</h1>';
        echo '<a href=index.php target=_self>Vuelve a comenzar</a>';
    } else {
    ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <h1>Pon aquí tus datos...</h1>
                </legend>
                <div>
                    <label for="user">Usuario:</label>
                    <input type="text" name="user" id="user" placeholder="H4shi" value="<?= $_POST['user'] ?? '' ?>">
                </div>
                <div>
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" id="name" placeholder="Hashirama" value="<?= $_POST['name'] ?? '' ?>">
                </div>
                <div>
                    <label for="lastName1">Apellido 1:</label>
                    <input type="text" name="lastName1" id="lastName1" placeholder="Senju" value="<?= $_POST['lastName1'] ?? '' ?>">
                </div>
                <div>
                    <label for="lastName2">Apellido 2:</label>
                    <input type="text" name="lastName2" id="lastName2" placeholder="Primer Hokage" value="<?= $_POST['lastName2'] ?? '' ?>">
                </div>
                <div>
                    <label for="dni">DNI:</label>
                    <input type="text" name="dni" id="dni" placeholder="12345678A" value="<?= $_POST['dni'] ?? '' ?>">
                </div>
                <div>
                    <label for="address">Dirección:</label>
                    <input type="text" name="address" id="address" placeholder="Villa Oculta de la Hoja, edificio del Hokage, primer piso puerta 1" value="<?= $_POST['address'] ?? '' ?>">
                </div>
                <div>
                    <label for="mail">Email:</label>
                    <input type="text" name="mail" id="mail" placeholder="primer_hokage@konoha.es" value="<?= $_POST['mail'] ?? '' ?>">
                </div>
                <div>
                    <label for="tlf">Teléfono:</label>
                    <input type="text" name="tlf" id="tlf" placeholder="987654321" value="<?= $_POST['tlf'] ?? '' ?>">
                </div>
                <div>
                    <label for="birthDate">Fecha de nacimiento:</label>
                    <input type="text" name="birthDate" id="birthDate" placeholder="23/10/1900" value="<?= $_POST['birthDate'] ?? '' ?>">
                </div>
                <div>
                    <label for="photo">Incluye una foto (.png o .jpg):</label>
                    <input type="file" name="photo" id="photo">
                </div>
                <div>
                    <label for="cv">Adjunta tu currículum (solo .pdf):</label>
                    <input type="file" name="cv" id="cv">
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="20MB">
                <div>
                    <input id="button" type="submit" value="Envía">
                </div>
            </fieldset>
        </form>

    <?php
    }
    ?>

    <div>
        <a href="candidates.php" target="_blank">Candidatos</a>
    </div>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');

    ?>
</body>

</html>