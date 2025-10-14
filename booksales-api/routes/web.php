<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksalesController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/booksales', [BooksalesController::class, 'index']);

Route::get('/books', [BookController::class, 'index']);