<?php

require_once($_SERVER['DOCUMENT_ROOT']. '/ComicGustavoVictor.php');

$comic1 = new Comic('Greg Capullo', 'Batman Año Uno', true);
// $comic2 = new Comic('Greg Capullo & Joel Schumacher', 'Superman Rojo');
// $comic3 = new Comic('Greg Capullo');

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
    
</body>
</html>
