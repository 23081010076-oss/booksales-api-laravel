<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Author;

class BooksalesController extends Controller
{
    public function index()
    {
        // Ambil semua data dari database
        $genres = Genre::all();   // gunakan model Eloquent
        $authors = Author::all(); // gunakan model Eloquent

        return view('booksales.index', compact('genres', 'authors'));
    }
}
