<?php
    /**
     * Página principal de los juegos de cartas.
     * @author: Gustavo Víctor
     * @version: 1.0
     */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

     <?php
     // Espacio reservado para la cabecera:
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/cabeceraGustavoVictor.inc.php');  
    ?>

<?php
    $suits = [
        "corazones" => "cor",
        "rombos" => "rom",
        "treboles" => "tre",
        "picas" => "pic"
    ];

    $values = [
        "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"
    ];

    $deck = [];

    foreach ($suits as $suit => $prefix) {
        foreach ($values as $value) {
            $deck[] = [
                "suit" => $suit,
                "value" => $value,
                "image" => "{$prefix}_{$value}.png"
            ];
        }
    }

// Imprime el deck para verificarlo
print_r($deck);
?>


     <?php
     // Espacio reservado para el footer:
        require_once($_SERVER['DOCUMENT_ROOT'].'/includes/footerGustavoVictor.inc.php');
     ?>
    
</body>
</html>