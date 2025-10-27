<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of all books.
     */
    public function index()
    {
        $books = Book::with(['author', 'genres'])->get();

        return $this->successResponse('Retrieved all books successfully', $books);
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'author_id' => 'required|exists:authors,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
            'stock' => 'required|integer|min:0',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $coverPath = $this->uploadCover($request);

        $book = Book::create([
            'title' => $validated['title'],
            'price' => $validated['price'],
            'author_id' => $validated['author_id'],
            'stock' => $validated['stock'],
            'cover_photo' => $coverPath
        ]);

        $book->genres()->attach($validated['genre_ids']);
        $book->load(['author', 'genres']);

        return $this->successResponse('Book created successfully', $book, 201);
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'genres']);
        return $this->successResponse('Book retrieved successfully', $book);
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'author_id' => 'sometimes|exists:authors,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
            'stock' => 'sometimes|integer|min:0',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('cover_photo')) {
            $this->deleteCover($book->cover);
            $validated['cover_photo'] = $this->uploadCover($request);
        }

        $book->update($validated);

        if (isset($validated['genre_ids'])) {
            $book->genres()->sync($validated['genre_ids']);
        }

        $book->load(['author', 'genres']);

        return $this->successResponse('Book updated successfully', $book);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book)
    {
        $this->deleteCover($book->cover);
        $book->genres()->detach();
        $book->delete();

        return $this->successResponse('Book deleted successfully');
    }

    /* -------------------------------------------------------
       Helper methods for clean & reusable code
    ------------------------------------------------------- */

    private function uploadCover(Request $request)
    {
        $file = $request->file('cover_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('cover_photo', $filename, 'public');
    }

    private function deleteCover(?string $path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function successResponse(string $message, $data = null, int $status = 200)
    {
        $response = [
            'status' => 'success',
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }
}
