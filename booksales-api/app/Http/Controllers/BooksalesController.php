<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Author;

class BooksalesController extends Controller
{
    public function index()
    {
        $genres = Genre::allGenres();
        $authors = Author::allAuthors();

        return view('booksales.index', compact('genres', 'authors'));
    }
}
