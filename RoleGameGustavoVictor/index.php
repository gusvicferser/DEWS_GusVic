<?php

// Incluye las clases que creaste
require_once 'Hero.php';
require_once 'Weapon.php';
require_once 'Armor.php';
require_once 'Potion.php';

// Crea un objeto de la clase Hero
$heroGandalf = new Hero("Gandalf", "Altmer", "Mago");
$heroAragorn = new Hero("Aragorn", "Nórdico", "Guerrero", 100, 15, 12);
$heroPrueba = new Hero("Alduin", "Avestruz", "Papanatas", -40, -12, -20);

// Añade armas al héroe
$weapon1 = new Weapon("Bastón de Mago", 30);
$weapon2 = new Weapon("Daga", 5);
$weapon3 = new Weapon("Anduril", 40);
$heroGandalf->addWeapon($weapon1);
$heroGandalf->addWeapon($weapon2);

$heroAragorn->addWeapon($weapon2);
$heroAragorn->addWeapon($weapon3);
$heroAragorn->addWeapon($weapon1);

// Añade armadura al héroe
$armor1 = new Armor("Armadura de Hierro", 10);
$heroGandalf->armor = $armor1;

$armor2 = new Armor("Armadura de Acero", 15);
$heroAragorn->armor = $armor2;
$heroGandalf->armor = $armor2;

// Añade pociones al héroe
$potion1 = new Potion(10);
$potion2 = new Potion(25);
$potion3 = new Potion(-15);
$potion4 = new Potion(20);
$potion5 = new Potion(80);

$heroGandalf->addPotion($potion5);
$heroGandalf->addPotion($potion3);
$heroGandalf->addPotion($potion2);


$heroAragorn->addPotion($potion4);
$heroAragorn->addPotion($potion3);
$heroAragorn->addPotion($potion1);
$heroAragorn->addPotion($potion5);


// Muestra la información inicial del héroe
echo "Información inicial del héroe:<br>";
echo $heroGandalf;
echo '<br><br>Armas:<br>';
foreach ($heroGandalf->weapons as $weapon){
    echo $weapon;
    echo '<br>';
}
echo '<br>Armadura:<br>';
echo $heroGandalf->armor;
echo '<br><br>Pociones:<br>';
foreach ($heroGandalf->potions as $potion){
    echo $potion;
    echo '<br>';
}

echo "<br>Información inicial del héroe:<br>";
echo $heroAragorn;
echo '<br><br>Armas:<br>';
foreach ($heroAragorn->weapons as $weapon){
    echo $weapon;
    echo '<br>';
}
echo '<br>Armadura:<br>';
echo $heroAragorn->armor;
echo '<br><br>Pociones:<br>';
foreach ($heroAragorn->potions as $potion){
    echo $potion;
    echo '<br>';
}

echo "<br>Información inicial del héroe:<br>";
echo $heroPrueba . ', '. $heroPrueba->baseAttack . ', '. $heroPrueba->baseDefense;

$heroPrueba->species = 'Dunmer';
$heroPrueba->class = 'Ladrón';

echo '<br><br>';
echo $heroPrueba;
echo '<br><br>';


// Realiza un ataque
$attackGandalf = $heroGandalf->attack();
echo "<br>Poder de ataque total de Alduin: $attackGandalf<br>";
$attackAragorn = $heroAragorn->attack();
echo "<br>Poder de ataque total de Aragorn: $attackAragorn<br>";
$attackPrueba = $heroPrueba->attack();
echo "<br>Poder de ataque total de Alduin: $attackPrueba<br>";

// Realiza una defensa y muestra el resultado
echo '<br>';
echo $heroGandalf;
$attackAragorn = $heroGandalf->defense($attackAragorn);
$heroGandalf->health -= $attackAragorn;
echo "<br>Daño a Alduin recibido tras defensa: $attackAragorn<br>";
echo 'Vida de Alduin: ' . $heroGandalf->health;
echo '<br><br>';
echo $heroAragorn;
$attackGandalf = $heroAragorn->defense($attackGandalf);
$heroAragorn->health -= $attackGandalf;
echo "<br>Daño realizado a Aragorn: " . $attackGandalf . "<br>";
echo 'Vida de Aragorn: ' . $heroAragorn->health;


// Usa una poción y muestra la salud actualizada
$heroGandalf->usePotion();
echo '<br><br>';
echo "<br>Información de Alduin tras usar una poción:<br>";
echo $heroGandalf;
echo '<br>';

// Probar el método usePotion
echo "<br>Aragorn está usando poción...";
$heroAragorn->usePotion();
// $heroAragorn->usePotion();
// $heroAragorn->usePotion();

// Mostrar información del héroe después de usar una poción
echo "<br>Información de Aragorn después de usar una poción:<br>";
echo $heroAragorn;

// Sacar armadura y arma de Alduin:
$heroGandalf->removeWeapon($weapon1);
$heroGandalf->removeArmor();
echo '<br><br>';
echo 'Armadura: ' . $heroGandalf->armor . ' / Arma: ';
foreach ($heroGandalf->weapons as $arma) {
    echo $arma;
    echo '<br>';
}


?>
