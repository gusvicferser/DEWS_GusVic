<?php

use Illuminate\Support\Facades\Route;


Route::get('movies/{id}', function (int $id) {
    return 'Esta es la movie: ' . $id;
})->where('id', '[0-9]+')
    ->name('moviesID');


Route::get('movies', function () {
    return 'Listado de películas de FluxVid';
})->name('movies');

Route::get('/', function () {
    // return view('welcome');
    return 'Hola soy Gustavo Víctor, bienvenido a FluxVid.';
})->name('index');
