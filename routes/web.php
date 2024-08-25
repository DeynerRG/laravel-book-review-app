<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Route::resource() permite registrar todas las routes basicas para ejecutar un CRUD al modelo.
Route::resource('books', BookController::class)->only(['index', 'show']); // only() permite activar unicamente las routes que se está utilizando en el controlador.

Route::resource('books.reviews', ReviewController::class)->scoped(['review'=>'book'])->only(['create', 'store']);


Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('books.reviews.store')->middleware('throttle:reviews');

Route::redirect('/', '/books');

