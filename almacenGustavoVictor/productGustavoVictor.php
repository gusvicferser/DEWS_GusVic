<?php

/**
 * Actividad 01 del tema 3: Introduciendo datos en el almacén.
 * 
 * Página con el formulario
 * 
 * @author = Gustavo Víctor
 * @version = 2.3
 */

// Si el array de $_POST NO está vacío, chequeamos si hay errores:
if (!empty($_POST)) {

    // Este array, proporcionado por ChatGPT nos permite comprobar si se dan las condiciones adecuadas:
    $regex_patterns = [
        'code' => '/^[A-Za-z]-\d{5}$/', // Una letra seguida de un guion y 5 dígitos
        'name' => '/^[A-Za-z]{3,20}$/', // Solo letras, mínimo 3 y máximo 20
        'cost' => '/^\d+(\.\d{1,2})?$/', // Decimal (puede ser entero o con 1-2 decimales)
        'descrip' => '/^[A-Za-z0-9\s]{50,}$/', // Alfanumérico (mínimo 50 letras, incluyendo espacios)
        'maker' => '/^[A-Za-z0-9\s]{10,20}$/', // Alfanumérico (entre 10 y 20 letras)
        'date' => '/^\d{4}-\d{2}-\d{2}$/', // Fecha en formato YYYY-MM-DD
    ];

    // Ahora añadimos varios ifs en los cuales comprobamos si las expresiones cumplen la reg exp:
    if (preg_match($regex_patterns['code'], $_POST['code']) == 0) {
        $errors['code'] = 'El código no es correcto, ha de ser una letra seguida de un guión y 5 dígitos. [L-01234]';
    }

    if (preg_match($regex_patterns['name'], $_POST['name']) == 0) {
        $errors['name'] = 'El nombre sólo puede contener letras, entre un mínimo de 3 y un máximo de 20';
    }

    if (preg_match($regex_patterns['cost'], $_POST['cost']) == 0) {
        $errors['cost'] = 'El precio debe ser un número con 1 o 2 decimales después de un punto.';
    }

    if (preg_match($regex_patterns['descrip'], $_POST['descrip']) == 0) {
        $errors['descrip'] = 'La descripción ha de tener un mínimo de 50 letras, incluyendo espacios';
    }

    if (preg_match($regex_patterns['maker'], $_POST['maker']) == 0) {
        $errors['maker'] = 'El campo ha de tener entre 10 y 20 letras';
    }

    if (preg_match($regex_patterns['date'], $_POST['date']) == 0) {
        $errors['date'] = 'La fecha ha de estar en formato AAAA-MM-DD';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gustavo Víctor</title>
</head>

<body>

    <div class="errores">
        <div><?= $errors['code'] ?? '' ?></div>
        <div><?= $errors['name'] ?? '' ?></div>
        <div><?= $errors['cost'] ?? '' ?></div>
        <div><?= $errors['descrip'] ?? '' ?></div>
        <div><?= $errors['maker'] ?? '' ?></div>
        <div><?= $errors['date'] ?? '' ?></div>
    </div>

    <?php

    /* Arriba hay un apartado en el cual ponemos los errores en diferentes divs por si queremos
     * ajustar posteriormente el estilo. Luego abajo un if en el cual si no hay errores y hay información
     * guardada en el array de $_POST, entonces ponemos el h1 con la frase dada. De lo contrario, mostramos el 
     * formulario con la información que ya han puesto, para que la corrijan.
     */

    if (empty($errors) && !empty($_POST)) {
        echo '<h1>Producto almacenado correctamente</h1>';
    } else {
    ?>
        <form action="#" method="post">
            <fieldset>
                <legend>
                    <h1>Pon aquí tus datos...</h1>
                </legend>
                <label for="code">Código:</label>
                <input type="text" name="code" id="code" value="<?= $_POST['code'] ?? '' ?>"><br>
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="<?= $_POST['name'] ?? '' ?>"><br>
                <label for="cost">Precio:</label>
                <input type="text" name="cost" id="cost" value="<?= $_POST['cost'] ?? '' ?>"><br>
                <label for="descrip">Descripción:</label>
                <input type="text" name="descrip" id="descrip" value="<?= $_POST['descrip'] ?? '' ?>"><br>
                <label for="maker">Fabricante:</label>
                <input type="text" name="maker" id="maker" value="<?= $_POST['maker'] ?? '' ?>"><br>
                <label for="date">Fecha de adquisición:</label>
                <input type="text" name="date" id="date" value="<?= $_POST['date'] ?? '' ?>"><br><br>
                <input type="submit" value="Envía">
            </fieldset>
        </form>

    <?php
    }
    ?>

</body>

</html>