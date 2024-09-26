<?php
/**
 * Una página sobre funciones simples para la actividad seis de la unidad 02:
 * @author: Gustavo Víctor
 * @version: 1.0
 */

// Suma o addition:
function addition(float ...$numbers): float {

    $addition = 0;

    for($i=0; $i<func_num_args();$i++) {
        $addition += func_get_arg($i);

    }

    return $addition;
}

// Resta o sustraction:
function sustraction(float ...$numbers): float {

    $sustraction = 0;

    for($i=0; $i<func_num_args();$i++) {
        $sustraction -= func_get_arg($i);

    }

    return $sustraction;
}

// Multiplicacion:
function multiplication(float ...$numbers): float {

    $multiplication = 0;

    for($i=0; $i<func_num_args();$i++) {
        $multiplication *= func_get_arg($i);
    }

    return $multiplication;
}

// Division o divide:
function divide(float ...$numbers): float {

    $division = 0;

    for($i=0; $i<func_num_args();$i++) {

        if (func_get_arg($i)!=0){
            $division = $division/func_get_arg($i);
        } 
    }

    return $division;
}

// Calculo del módulo "Module calculation":
function moduleCalc(int $number1, int $number2): float {

    $module=0;

    if ($number2!=0) {
        $module=$number1%$number2;
    }

    return $module;
}

// Calculo si son iguales:
function intEquals(int $number1, int $number2): bool {

    $equals = false;

    if ($number1==$number2) {
        $equals=true;
    }

    return $equals;
}

// Calculo de número par:
function isEven(int $number1): bool {

    $even=false;

    if (($number1%2)==0) {
        $even=true;
    }

    return $even;
}

