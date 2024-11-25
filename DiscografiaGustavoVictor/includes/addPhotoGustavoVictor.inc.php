<?php

/**
 * Página a incluir para añadir la fotografía del álbum:
 * 
 * @author = Gustavo Víctor
 * @version = 2.0
 */


/**
 * Función para determinar si la imagen es .jpg/.jpeg o .png y guardarla
 * como .png independientemente de qué fuera antes.
 * 
 * @author Gustavo Víctor
 * @version 2.0
 * @param  String (nombre de la foto)
 * @param  String (ruta de la carpeta de guardado)
 * @return boolean (True si lo ha conseguido, false si no)
 */
function createPng(String $photoName, String $fileRoute): bool
{
    // Averiguamos el tipo MIME del archivo temporal:
    $mimeType = mime_content_type($_FILES['photo']['tmp_name']);

    // Si es .jpg, se guarda como png y devuelve true. 
    // Si es png se mueve a su destino y devuelve true:
    if ($mimeType === 'image/jpeg') {
        return imagepng(
            imagecreatefromjpeg(
                $_FILES['photo']['tmp_name']
            ),
            $fileRoute .
                '/' .
                $photoName
        );
    } else if ($mimeType === 'image/png') {
        return move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            $fileRoute .
                '/' .
                $photoName
        );
    }

    return false; // Caso predeterminado
}

// Vamos a almacenar la imagen. Para ello creamos la ruta de las carpetas:
$route = $_SERVER['DOCUMENT_ROOT'] . '/img';
$albumPath = $_SERVER['DOCUMENT_ROOT'] . '/img/albumes';

//  Comprobamos si la foto que nos han pasado existe o no:
if (is_uploaded_file($_FILES['photo']['tmp_name']) === true) {

    // Creamos el nombre de las imagenes y su ruta:
    $photoName = uniqid() . '.png';
    $routePhoto = $albumPath . '/' . $photoName;

    // Creamos la imagen:
    if (createPng($photoName, $albumPath)) {

        // Colocamos el nombre de la foto como $_POST['photo']:
        $_POST['photo'] = $photoName;

    } else {
        if (is_file($routePhoto)) {
            // En cualquier caso que el archivo no se haya subido al servidor, lanzamos un aviso:
            $errors['hack'] = 'Posible ataque. Nombre ' . $_FILES['photo']['tmp_name'];
        }
    }
}
