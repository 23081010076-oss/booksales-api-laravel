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

    /**
     * Display the specified genre.
     */
    public function show($id)
    {
        $genre = Genre::find($id);
        if (! $genre) {
            return response()->json([
                'status' => 'error',
                'message' => 'Genre not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Genre retrieved successfully',
            'data' => $genre
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified genre in storage.
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (! $genre) {
            return response()->json([
                'status' => 'error',
                'message' => 'Genre not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id
        ]);

        $genre->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Genre updated successfully',
            'data' => $genre
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified genre from storage.
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (! $genre) {
            return response()->json([
                'status' => 'error',
                'message' => 'Genre not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $genre->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Genre deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
