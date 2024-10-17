<?php

/**
 * Actividad 03 del tema 3: Introduciendo datos en el almacén.
 * 
 * Aplicación para guardar los datos de un candidato para una oferta de trabajo
 * (Usuario, nombre, apellidos, DNI, dirección, mail, teléfono y fecha de nacimiento)
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 */

// Si el array de $_POST NO está vacío, chequeamos si hay errores:
if (!empty($_POST)) {

    // Este array, proporcionado por ChatGPT nos permite comprobar si se dan las condiciones adecuadas:
    $regex_patterns = [
        'user' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,12}$/',
        'name' => '/^[A-Za-zÀ-ÿ\s]{1,30}$/',
        'lastName1' => '/^[A-Za-zÀ-ÿ\s]{5,30}$/',
        'lastName2' => '/^[A-Za-zÀ-ÿ\s]{0,30}$/',
        'dni' => '/^\d{8}[A-Za-z]$/',
        'address' => '/^.{10,100}$/',
        'mail' => '/^[\w\.-]+@[\w\.-]+\.\w{2,6}$/',
        'tlf' => '/^\d{9}$/',
        'birthDate' => '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/'
    ];


    // Ahora añadimos varios ifs en los cuales comprobamos si las expresiones cumplen la reg exp:
    if (preg_match($regex_patterns['user'], $_POST['user']) == 0) {
        $errors['user'] = 'El nombre de usuario no es correcto, ha de tener al menos una letra, al menos un número y de 5 a 12 caracteres';
    }

    if (preg_match($regex_patterns['name'], $_POST['name']) == 0) {
        $errors['name'] = 'El nombre solo puede contener letras y espacios, mínimo de 5, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['lastName1'], $_POST['lastName1']) == 0) {
        $errors['lastName1'] = 'El apellido 1 solo puede contener letras y espacios, mínimo de 5, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['lastName2'], $_POST['lastName2']) == 0) {
        $errors['lastName2'] = 'El apellido 2 puede estar en blanco y sólo puede contener letras y espacios, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['dni'], $_POST['dni']) == 0) {
        $errors['dni'] = 'El dni deben ser 8 números con una letra [12345678A].';
    }

    if (preg_match($regex_patterns['address'], $_POST['address']) == 0) {
        $errors['address'] = 'La dirección ha de tener un mínimo de 10 caracteres, max. de 100';
    }

    if (preg_match($regex_patterns['mail'], $_POST['mail']) == 0) {
        $errors['mail'] = 'El email ha de seguir este patrón: nombre@servidor.algo';
    }

    if (preg_match($regex_patterns['tlf'], $_POST['tlf']) == 0) {
        $errors['tlf'] = 'El teléfono ha de estar compuesto por 9 números';
    }
    if (preg_match($regex_patterns['birthDate'], $_POST['birthDate']) == 0) {
        $errors['birthDate'] = 'La fecha ha de estar en formato dd/mm/aaaa';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

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
    </div>

    <?php

    /* Arriba hay un apartado en el cual ponemos los errores en diferentes divs por si queremos
     * ajustar posteriormente el estilo. Luego abajo un if en el cual si no hay errores y hay información
     * guardada en el array de $_POST, entonces ponemos el h1 con la frase dada. De lo contrario, mostramos el 
     * formulario con la información que ya han puesto, para que la corrijan.
     */

    if (empty($errors) && !empty($_POST)) {
        echo '<h1>Usuario registrado correctamente</h1>';
        echo '<a href=index.php target=_self>Vuelve a comenzar</a>';
    } else {
    ?>
        <form action="#" method="post">
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
                    <input id="button" type="submit" value="Envía">
                </div>
            </fieldset>
        </form>

    <?php
    }
    ?>

    <?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footerGustavoVictor.inc.php');

    ?>
</body>

</html>