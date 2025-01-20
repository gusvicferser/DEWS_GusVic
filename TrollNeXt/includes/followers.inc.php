<?php

/**
 * Include para guardar los followers en la sesión:
 * 
 * @author Gustavo Victor
 * @version 1.0
 */

unset($_SESSION['user_fol']);

$query = $connection->query(
    'SELECT 
        f.user_followed AS fol_id,
        u.user AS fol_name
    FROM
        follows f LEFT JOIN users u
    ON 
        u.id = f.user_followed
    WHERE
        f.user_id =' .  $_SESSION['user_id'] . ';'
);
// Almacenamos el nombre y el id de todos a los que sigue:
foreach ($query->fetchAll(PDO::FETCH_OBJ) as $follower) {
    // var_dump($follower); // Traza para comprobar la salida
    $_SESSION['user_fol'][$follower->fol_id] = $follower;
}
