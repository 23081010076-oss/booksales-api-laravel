<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksalesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/booksales', [BooksalesController::class, 'index']);

