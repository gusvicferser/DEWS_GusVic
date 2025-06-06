<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\EnsureUserHasRole;

// Accounts:
Route::resource('users', UserController::class)
    ->only(['index', 'update', 'inhabilitate'])
    ->middleware('auth');

Route::resource('users', UserController::class)
    ->middleware(EnsureUserHasRole::class.':admin')
    ->only(['create', 'edit', 'destroy']);

// Products:
Route::resource('products', ProductController::class)
    ->middleware(EnsureUserHasRole::class.':admin')
    ->except('index', 'show');

Route::resource('products', ProductController::class);

//Events:
Route::resource('events', EventController::class)
->middleware(EnsureUserHasRole::class.':admin')
->except('index', 'show');

Route::resource('events', EventController::class);

// Login features:
Route::get('signup', [LoginController::class, 'signupForm'])->name('signupForm');
Route::post('signup', [LoginController::class, 'signup'])->name('signup');
Route::get('login', [LoginController::class, 'loginForm'])->name('loginForm');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Politics routes:
Route::get('terms', function() {
    return view('about.terms');
})->name('terms');

Route::get('privacy', function() {
    return view('about.privacy');
})->name('privacy');

Route::get('cookies', function() {
    return view('about.cookies');
})->name('cookies');

Route::get('contact', function() {
    return view('about.contact');
})->name('contact');

// Index as index:
Route::get('/', function () {
    return view('index');
})->name('index');
