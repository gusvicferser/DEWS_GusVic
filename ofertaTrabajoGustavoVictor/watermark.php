<?php

/**
 * En este apartado se incluye una marca de agua para todas las fotografías:
 * 
 * @author = Gustavo Víctor
 * @version = 1.0
 */

// Creamos la variable de la marca de agua:
$watermark = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']. '/images/marca.png');
$watermark = imagescale($watermark, 50);

// Indicamos el modo en cómo fusionaremos las dos imágenes:
imagealphablending($watermark, false); // Establece el modo de mezcla.
imagesavealpha($watermark, true); // Intenta guardar información del canal alpha.

// Hay que obtener las dimensiones para la imagen de la marca de agua:
$watermarkWidth = intval(imagesx($watermark));
$watermarkHeight = intval(imagesy($watermark));

// Hay que aplicarle un filtro a la marca de agua para cambiarle el tono y la opacidad:
imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 60);

// Hemos de cargar la imagen y obtener sus dimensiones:
$image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']. '/images/candidates/' . $_GET['img']);
$imageWidth = intval(imagesx($image));
$imageHeight = intval(imagesy($image));

// Se añade pues la marca de agua a la imagen:
imagecopy($image, $watermark, ($imageWidth-$watermarkWidth), ($imageHeight-$watermarkHeight), 0, 0, $imageWidth, $imageHeight);

// Indicamos cabecera:
header('Content-type: image/png');

// Enviamos la imagen entonces:
imagepng($image);

// Liberamos memoria:
imagedestroy($image);
imagedestroy($watermark);
unset($watermarkHeight, $watermarkWidth, $imageWidth, $imageHeight);
