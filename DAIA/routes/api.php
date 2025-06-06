<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\CommentApiController;

Route::get('/events', [EventApiController::class, 'index'])->name('events');
Route::get('/products', [ProductApiController::class, 'index'])->name('products');
Route::get('/reviews', [ReviewApiController::class, 'index'])->name('reviews');
Route::get('/comments', [CommentApiController::class, 'index'])->name('comment');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
