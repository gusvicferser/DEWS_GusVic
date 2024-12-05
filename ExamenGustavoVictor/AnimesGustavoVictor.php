<?php
/**
 * Ejercicio 2
 * 
 * @author Gustavo Victor
 * @version 1.0
 */

 require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/connectionGustavoVictor.inc.php');

 try {

    $connection = dbConnection();

    $query = $connection->query(
        'SELECT 
            title, episodes 
        FROM 
            animes
        ORDER BY
            episodes DESC 
        LIMIT 
            1');

    $mostEpi = $query->fetchObject();

    $query = $connection->query(
        'SELECT 
            title, genre, episodes, studio, release_year, rating 
        FROM 
            animes');

    $animes = $query->fetchAll(PDO::FETCH_OBJ);

    unset($query);
    unset($connection);

 } catch (Exception $exc) {
    $errors[] = $exc;
 }
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO 2</title>
 </head>
 <body>
    <?php
    if(isset($animes)){
        ?>
        <table>
        <thead>
        <th>Title</th>
        <th>Genre</th>
        <th>Episodes</th>
        <th>Studio</th>
        <th>Release Year</th>
        <th>Rating</th>
        </thead>
        <tbody>
        <?php
        foreach ($animes as $anime) {
            echo '<tr>';
            echo '<tr>';
            echo '<td>'. $anime->title .'</td>';
            echo '<td>'. $anime->genre .'</td>';
            echo '<td>'. $anime->episodes .'</td>';
            echo '<td>'. $anime->studio .'</td>';
            echo '<td>'. $anime->release_year .'</td>';
            echo '<td>'. $anime->rating .'</td>';
            echo '<tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    echo '<div>';
    echo 
        '<h3>El anime con más episodios es '.
        $mostEpi->title . 
        ' con '. 
        $mostEpi->episodes . 
        ' episodios.';
    echo '</div>';

    ?>
    

 </body>
 </html>