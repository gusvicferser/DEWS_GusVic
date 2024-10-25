<?php

/**
 * Página a incluir para sacar los errores de la página principal y tratarlos:
 * 
 * @author = Gustavo Víctor
 * @version = 1.1
 */


// Si el array de $_POST NO está vacío, chequeamos si hay errores:
if (!empty($_POST)) {

    // Este array, proporcionado por ChatGPT nos permite comprobar si se dan las condiciones adecuadas:
    $regex_patterns = [
        'user' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,12}$/',
        'name' => '/^[A-Za-zÀ-ÿ\s]{1,30}$/',
        'lastName1' => '/^[A-Za-zÀ-ÿ\s]{5,30}$/',
        'lastName2' => '/^[A-Za-zÀ-ÿ\s]{0,30}$/',
        'dni' => '/^\d{8}[A-Za-z]$/',
        'address' => '/^.{10,100}$/',
        'mail' => '/^[\w\.-]+@[\w\.-]+\.\w{2,6}$/',
        'tlf' => '/^\d{9}$/',
        'birthDate' => '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/'
    ];


    // Ahora añadimos varios ifs en los cuales comprobamos si las expresiones cumplen la reg exp:
    if (preg_match($regex_patterns['user'], $_POST['user']) == 0) {
        $errors['user'] = 'El nombre de usuario no es correcto, ha de tener al menos una letra, al menos un número y de 5 a 12 caracteres';
    }

    if (preg_match($regex_patterns['name'], $_POST['name']) == 0) {
        $errors['name'] = 'El nombre solo puede contener letras y espacios, mínimo de 5, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['lastName1'], $_POST['lastName1']) == 0) {
        $errors['lastName1'] = 'El apellido 1 solo puede contener letras y espacios, mínimo de 5, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['lastName2'], $_POST['lastName2']) == 0) {
        $errors['lastName2'] = 'El apellido 2 puede estar en blanco y sólo puede contener letras y espacios, máximo de 30 caracteres';
    }

    if (preg_match($regex_patterns['dni'], $_POST['dni']) == 0) {
        $errors['dni'] = 'El dni deben ser 8 números con una letra [12345678A].';
    }

    if (preg_match($regex_patterns['address'], $_POST['address']) == 0) {
        $errors['address'] = 'La dirección ha de tener un mínimo de 10 caracteres, max. de 100';
    }

    if (preg_match($regex_patterns['mail'], $_POST['mail']) == 0) {
        $errors['mail'] = 'El email ha de seguir este patrón: nombre@servidor.algo';
    }

    if (preg_match($regex_patterns['tlf'], $_POST['tlf']) == 0) {
        $errors['tlf'] = 'El teléfono ha de estar compuesto por 9 números';
    }
    if (preg_match($regex_patterns['birthDate'], $_POST['birthDate']) == 0) {
        $errors['birthDate'] = 'La fecha ha de estar en formato dd/mm/aaaa';
    }

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($errors);
    // echo '</pre>';

    // Vamos a hacer un if para los errores que puedan tener las fotos o currículum:
    if (!empty($_FILES)) {

        // Si $_FILES no está vacío, hemos de comprobar si existe algún error posible de subida:
        if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {

            switch ($_FILES['photo']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors['photo'] = 'Fotografía demasiado grande';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors['photo'] = 'La fotografía no se ha podido subir entera';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors['photo'] = 'No se ha encontrado la fotografía';
                    break;
                default:
                    $errors['photo'] = 'Error indeterminado';
            }
        }

        // Si los errores están vacíos, entramos por aquí:
        if (empty($errors['photo'])) {

            // Si no hay errores, pasaremos a comprobar si es el tipo de archivo que requerimos:
            if ($_FILES['photo']['type'] != 'image/jpeg' && $_FILES['photo']['type'] != 'image/png') {
                $errors['photo'] = 'El tipo de archivo de la foto no es el correcto, debe ser .jpg/.jpeg o .png';
            }

            // Hacemos ahora otro if para detectar errores en el cv. Creo que es importante separar los dos if
            // ya que si no, no tendríamos forma de saber qué archivo da error.
            if ($_FILES['cv']['error'] != UPLOAD_ERR_OK) {
                switch ($_FILES['cv']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $errors['cv'] = 'CV demasiado grande';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $errors['cv'] = ' El CV no se ha podido subir entero';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $errors['cv'] = ' No se ha encontrado el currículum';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $errors['cv'] = 'El tipo de archivo del CV no es correcto';
                        break;
                    default:
                        $errors['cv'] = 'Error indeterminado';
                }
            }

            if (empty($errors['cv'])) {
                // Comprobamos si es del tipo que necesitamos
                if ($_FILES['cv']['type'] != 'application/pdf') {
                    $errors['cv'] = 'El tipo de archivo del cv no es el correcto, debe ser .pdf';
                }

                // Para añadir la foto, lo hacemos en otro include:
                require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/addPhotoGustavoVictor.inc.php');
            }
        } else {
            // Si $_FILES está vacío, hemos de lanzar un error para que vuelva al formulario:
            $errors['files'] = '¡Ha de adjuntar los archivos!';
        }
    }
}
