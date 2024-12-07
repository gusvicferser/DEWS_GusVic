<?php

require_once($_SERVER['DOCUMENT_ROOT']. '/ExamenGustavoVictor/ComicGustavoVictor.php');

$comic1 = new Comic('Greg Capullo', 'Batman Año Uno', true);
$comic2 = new Comic('Greg Capullo & Joel Schumacher', 'Superman Rojo');
$comic3 = new Comic('Greg Capullo');

$comic1->addCharacter('Batman');
$comic1->addCharacter('Joker');
$comic1->addCharacter('Joker');
$comic1->addCharacter('Catwoman');
$comic1->removeCharacter('Joker');

$comic2->addCharacter('Superman');
$comic2->hasCharacter('Superman');
$comic2->hasCharacter('Batman');

$comic3->author = 'Joel Schumacher';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

    <h1>Comics:</h1>
    <h1><?=$comic1?></h1>
    <h1><?=$comic2?></h1>
    <h1><?=$comic3?></h1>
    <h2><?=$comic2->hasCharacter('Superman')? 'Contiene a Superman': 'Superman no está presente'?></h2>
    <h2><?=$comic2->hasCharacter('Batman')? 'Contiene a Batman': 'Batman no está presente'?></h2>

    
</body>
</html>
