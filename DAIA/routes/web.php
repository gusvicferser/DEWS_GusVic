<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

// Accounts:
Route::resource('/account', UserController::class)
    ->only(['index', 'update', 'destroy'])
    ->middleware('auth');

// Login features:
Route::get('/signup', [LoginController::class, 'signupForm'])->name('signupForm');
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');
Route::get('/login', [LoginController::class, 'loginForm'])->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Politics routes:
Route::get('/terms', function() {
    return view('politics.terms');
})->name('terms');

Route::get('/privacy', function() {
    return view('politics.privacy');
})->name('privacy');

Route::get('/cookies', function() {
    return view('politics.cookies');
})->name('cookies');

Route::get('/contact', function() {
    return view('politics.contact');
})->name('contact');

// Index as index:
Route::get('/', function () {
    return view('index');
})->name('index');
