<?php

/**
 * Página a incluir para añadir las fotografías:
 * 
 * @author = Gustavo Víctor
 * @version = 1.1
 */

// Vamos a almacenar la imagen. Para ello creamos el nombre de la ruta:
        $route = $_SERVER['DOCUMENT_ROOT'] . '/cvs';
        $candidates = $_SERVER['DOCUMENT_ROOT'] . '/images/candidates';

        //  Comprobamos si la foto que nos han pasado existe o no:
        if (is_uploaded_file($_FILES['photo']['tmp_name']) === true) {

            // Si no existe, creamos dos directorios. Uno para los cvs, otro para las fotos:
            if (is_dir($route) === false) {
                mkdir($route);
            }

            if (is_dir($candidates) === false) {
                mkdir($candidates);
            }

            // Creamos el nombre de la imagen y su ruta:
            $photoName = $_POST['dni'] . '.png';
            $photoSmall = $_POST['dni'] . '-thumbnail.png';
            $routePhoto = $candidates . '/' . $photoName;
            $routeSmall = $candidates . '/' . $photoSmall;

            // Movemos el archivo a una dirección permanente y si no ha podido, guardamos un mensaje de error:
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $routePhoto) === true && !move_uploaded_file($_FILES['photo']['tmp_name'], $routeSmall) === true) {
                $errors['move'] = 'No se ha podido mover el archivo ' . $photoName;
            }
        } else {
            if (is_file($_FILES['photo']['tmp_name'])) {
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