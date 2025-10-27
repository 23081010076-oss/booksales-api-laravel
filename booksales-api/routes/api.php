<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TransactionController;

// ========== AUTH ========== //
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/admin/register', [AdminAuthController::class, 'register']); // Register Admin

// ========== PUBLIC ROUTES ========== //
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{id}', [GenreController::class, 'show']);

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);

// BOOK (PUBLIC)
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

// ========== CUSTOMER (USER) ROUTES ========== //
Route::group(['middleware' => ['jwt.auth', 'customer']], function () {
    // TRANSACTIONS (CUSTOMER ONLY)
    Route::post('/transactions', [TransactionController::class, 'store']);   // Create
    Route::get('/transactions/{id}', [TransactionController::class, 'show']); // Show own
    Route::put('/transactions/{id}', [TransactionController::class, 'update']); // Update own

    // PROFILE & LOGOUT
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// ========== ADMIN ROUTES ========== //
Route::group(['middleware' => ['jwt.auth', 'admin']], function () {
    // GENRE CRUD
    Route::post('/genres', [GenreController::class, 'store']);
    Route::put('/genres/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/{id}', [GenreController::class, 'destroy']);

    // AUTHOR CRUD
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{id}', [AuthorController::class, 'update']);
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

    // TRANSACTIONS (ADMIN ONLY)
    Route::get('/transactions', [TransactionController::class, 'index']); 
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']); 

    // BOOK CRUD (ADMIN ONLY)
    Route::post('/books', [BookController::class, 'store']);
    // Note: Laravel membutuhkan rute update dengan file (cover) menggunakan POST, bukan PUT
    Route::post('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);
});
