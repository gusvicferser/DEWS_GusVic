<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('user', UserController::class)
    ->only(['show', 'destroy'])
    ->middleware('auth');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('events', EventController::class);
    Route::resource('players', PlayerController::class);
});
Route::resource('events', EventController::class)
    ->only('index', 'show');
Route::resource('players', PlayerController::class);
Route::resource('messages', MessageController::class);

Route::get('signup', [LoginController::class, 'signupForm'])->name('signupForm');
Route::post('signup', [LoginController::class, 'signup'])->name('signup');
Route::get('login', [LoginController::class, 'loginForm'])->name('loginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('signup', function() {
//     return view('auth.signup');
// })->name('signup');

// Route::get('login', function() {
//     return view('auth.login');
// })->name('login');

Route::get('terms', function() {
    return view('politics.terms');
})->name('terms');

Route::get('privacy', function() {
    return view('politics.privacy');
})->name('privacy');

Route::get('cookies', function() {
    return view('politics.cookies');
})->name('cookies');

Route::get('contact', function() {
    return view('politics.contact');
})->name('contact');

Route::get('location', function() {
    return view('politics.location');
})->name('location');

Route::get('/', function () {
    return view('index');
})->name('index');
