<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookApiController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index(): JsonResponse
    {
        $books = Book::with(['author', 'genres'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $books,
            'message' => 'Books retrieved successfully'
        ]);
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'nullable|string|max:13|unique:books,isbn',
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create($request->only([
            'title', 'author_id', 'isbn', 'publication_date', 'description'
        ]));

        // Attach genres if provided
        if ($request->has('genres')) {
            $book->genres()->attach($request->genres);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book created successfully'
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show(string $id): JsonResponse
    {
        $book = Book::with(['author', 'genres', 'reviews.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book retrieved successfully'
        ]);
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'isbn' => 'nullable|string|max:13|unique:books,isbn,' . $id,
            'publication_date' => 'nullable|date',
            'description' => 'nullable|string',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->only([
            'title', 'author_id', 'isbn', 'publication_date', 'description'
        ]));

        // Sync genres if provided
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }

        $book->load(['author', 'genres']);

        return response()->json([
            'success' => true,
            'data' => $book,
            'message' => 'Book updated successfully'
        ]);
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $book = Book::findOrFail($id);
        
        // Detach genres and delete reviews
        $book->genres()->detach();
        $book->reviews()->delete();
        
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ]);
    }
}
