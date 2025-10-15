<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Author;

use function pest\laravel\json;

class GenreController extends Controller
{
    public function index()
    {

        $genres = Genre::all();   
        return response()->json([
            "success" => true,
            "message" => "get all resousces",
            "data" => $genres
        ], 200);


    }
}
