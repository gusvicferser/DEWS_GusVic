<?php

/**
 * Actividad 01 del tema 3: Introduciendo datos en el almacén.
 * 
 * Página con el formulario
 * 
 * @author = Gustavo Víctor
 * @version = 2.0
 */

if (!empty($_POST)) {
    $regex_patterns = [
        'code' => '/^[A-Za-z]-\d{5}$/', // Una letra seguida de un guion y 5 dígitos
        'name' => '/^[A-Za-z]{3,20}$/', // Solo letras, mínimo 3 y máximo 20
        'cost' => '/^\d+(\.\d{1,2})?$/', // Decimal (puede ser entero o con 1-2 decimales)
        'descrip' => '/^[A-Za-z0-9\s]{50,}$/', // Alfanumérico (mínimo 50 letras, incluyendo espacios)
        'maker' => '/^[A-Za-z0-9]{10,20}$/', // Alfanumérico (entre 10 y 20 letras)
        'date' => '/^\d{4}-\d{2}-\d{2}$/', // Fecha en formato YYYY-MM-DD
    ];

    if (preg_match($regex_patterns['code'], $_POST['code']) == 0) {
        $errors['code'] = 'El código no es correcto, ha de ser una letra seguida de un guión y 5 dígitos. [L-01234]';
    }

    if (preg_match($regex_patterns['name'], $_POST['name']) == 0) {
        $errors['name'] = 'El nombre sólo puede contener letras, entre un mínimo de 3 y un máximo de 20';
    }

    if (preg_match($regex_patterns['cost'], $_POST['cost']) == 0) {
        $errors['cost'] = 'EL precio debe ser un número con 1 o 2 decimales.';
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

    if (empty($errors)) {
        echo '<form action="/processGustavoVictor_Act_01.php" method="post">';
    } else {
        echo '<form action="" method="post">';
    }
    ?>

    <fieldset>
        <legend>
            <h1>Pon aquí tus datos...</h1>
        </legend>
        <label for="code">Código:</label>
        <input type="text" name="code" id="code"><br>
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name"><br>
        <label for="cost">Precio:</label>
        <input type="text" name="cost" id="cost"><br>
        <label for="descrip">Descripción:</label>
        <input type="text" name="descrip" id="descrip"><br>
        <label for="maker">Fabricante:</label>
        <input type="text" name="maker" id="maker"><br>
        <label for="date">Fecha de adquisición:</label>
        <input type="text" name="date" id="date"><br><br>
        <input type="submit" value="Envía">
    </fieldset>
    </form>


</body>

</html>