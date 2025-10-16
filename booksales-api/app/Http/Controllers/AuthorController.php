<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Display a listing of the authors.
     */
    public function index()
    {
        $authors = Author::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Retrieved all authors successfully',
            'data' => $authors
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created author in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'bio' => 'nullable|string'
        ]);

        $author = Author::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Author created successfully',
            'data' => $author
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified author.
     */
    public function show(Author $author)
    {
        return response()->json([
            'status' => 'success',
            'data' => $author
        ]);
    }

    /**
     * Update the specified author in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:authors,email,' . $author->id,
            'bio' => 'nullable|string'
        ]);

        $author->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Author updated successfully',
            'data' => $author
        ]);
    }

    /**
     * Remove the specified author from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Author deleted successfully'
        ]);
    }
}