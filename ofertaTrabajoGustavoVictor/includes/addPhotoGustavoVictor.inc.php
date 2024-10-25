<?php

/**
 * Página a incluir para añadir las fotografías:
 * 
 * @author = Gustavo Víctor
 * @version = 1.2
 */


/**
 * Función para determinar si la imagen es .jpg/.jpeg o .png y guardarla
 * como .png independientemente de qué fuera antes.
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 * @param = String (la carpeta donde se guardará la foto)
 * @return = boolean (True si lo ha conseguido, false si no)
 */
function createPng(String $fileRoute): bool
{
    // Averiguamos el tipo MIME del archivo temporal:
    $mimeType = mime_content_type($_FILES['photo']['tmp_name']);
    $photoName = $_POST['dni'] . '.png'; // Le damos nombre a la foto.

    // Si es .jpg, se guarda como png y devuelve true. Si es png se mueve a su destino y devuelve true:
    if ($mimeType === 'image/jpeg') {
        return imagepng(imagecreatefromjpeg($_FILES['photo']['tmp_name']), $fileRoute . '/' . $photoName);
    } else if ($mimeType === 'image/png') {
        return move_uploaded_file($_FILES['photo']['tmp_name'], $fileRoute . '/' . $photoName);
    }

    return false; // Caso predeterminado
}

// Vamos a almacenar la imagen. Para ello creamos el nombre de las carpetas:
$route = $_SERVER['DOCUMENT_ROOT'] . '/cvs';
$candidates = $_SERVER['DOCUMENT_ROOT'] . '/images/candidates';

//  Comprobamos si la foto que nos han pasado existe o no:
if (is_uploaded_file($_FILES['photo']['tmp_name']) === true) {

    // Si no existen las carpetas, las creamos. Una para los cvs, otra para las fotos:
    if (is_dir($route) === false) {
        mkdir($route);
    }

    if (is_dir($candidates) === false) {
        mkdir($candidates);
    }

    // Creamos el nombre de las imagenes y su ruta:
    $photoName = $_POST['dni'] . '.png';
    $routePhoto = $candidates . '/' . $photoName;
    $photoSmall = $_POST['dni'] . '-thumbnail.png';
    $routeSmall = $candidates . '/' . $photoSmall;

    // Enviamos la dirección de la foto para crear la primera imagen en formato png. 
    // Devuelve true si lo ha conseguido, false si no:
    if (createPng($candidates)) {

        // Según la documentación de PHP debemos crear variables de altura y anchura 
        // para la nueva foto:
        list($width, $height) = getimagesize($routePhoto);

        // Aquí ajustamos variables con una nueva altura y nuevo ancho:
        $new_width = intval($width / 5);
        $new_height = intval($height / 5);

        // Según la documentación de PHP ha de crearse una imagen estandar:
        $image = imagecreatefrompng($routePhoto);
        $smallImg = imagecreatetruecolor($new_width, $new_height);

        // Ahora le cambiaríamos el tamaño:
        if (!imagecopyresized($smallImg, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
            $errors['resize'] = 'No se ha podido reescalar la imagen';
        }

        // Este paso he tenido que buscarlo en chatGPT porque yo no averiguaba la forma  
        // de guardar esta img cambiada de tamaño al archivo:
        if (!imagepng($smallImg, $routeSmall)) {
            $errors['moveSmall'] = 'No se ha podido mover la foto pequeña' . $photoSmall;
        } else {
            // Si ha logrado moverlo, toca liberar espacio destruyendo las imágenes:
            imagedestroy($image);
            imagedestroy($smallImg);
        }
    } else {
        $errors['move'] = 'No se ha podido mover el archivo ';
    }
} else {
    if (is_file($routePhoto)) {
        // En cualquier caso que el archivo no se haya subido al servidor, lanzamos un aviso:
        $errors['hack'] = 'Posible ataque. Nombre ' . $_FILES['photo']['tmp_name'];
    }
}

//  Comprobamos si el cv que nos han pasado existe o no:
if (is_uploaded_file($_FILES['cv']['tmp_name']) === true) {

    // Comprobamos si la carpeta no existe, y si es así, creamos dos directorios. Uno para los cvs, otro para las fotos:
    if (is_dir($route) === false) {
        mkdir($route, 0700);
        mkdir($candidates, 0700);
    }

    // Creamos el nombre del cv y su ruta:
    $cvName = $_POST['dni'] . '-' . $_POST['name'] . '-' . $_POST['lastName1'] . '.pdf';
    $routeCV = $route . '/' . $cvName;

    // Movemos el archivo a una dirección permanente y si no ha podido, guardamos un mensaje de error:
    if (!move_uploaded_file($_FILES['cv']['tmp_name'], $routeCV) === true) {
        $errors['move'] = 'No se ha podido mover el archivo ' . $cvName;
    }
} else {
    // En cualquier caso que el archivo no se haya subido al servidor, lanzamos un aviso:
    $errors['hack'] = 'Posible ataque. Nombre ' . $_FILES['cv']['tmp_name'];
}
