<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    /**
     * Display a listing of the genres.
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Retrieved all genres successfully',
            'data' => $genres
        ]);
    }

    /**
     * Store a newly created genre in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name'
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Genre created successfully',
            'data' => $genre
        ], Response::HTTP_CREATED);
    }
}
