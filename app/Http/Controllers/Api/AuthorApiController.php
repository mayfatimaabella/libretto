<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthorApiController extends Controller
{
    /**
     * Display a listing of the authors.
     */
    public function index(): JsonResponse
    {
        $authors = Author::withCount('books')->get();
        
        return response()->json([
            'success' => true,
            'data' => $authors,
            'message' => 'Authors retrieved successfully'
        ]);
    }

    /**
     * Store a newly created author in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after:birth_date',
        ]);

        $author = Author::create($request->only([
            'name', 'biography', 'birth_date', 'death_date'
        ]));

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author created successfully'
        ], 201);
    }

    /**
     * Display the specified author.
     */
    public function show(string $id): JsonResponse
    {
        $author = Author::with('books')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author retrieved successfully'
        ]);
    }

    /**
     * Update the specified author in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after:birth_date',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->only([
            'name', 'biography', 'birth_date', 'death_date'
        ]));

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author updated successfully'
        ]);
    }

    /**
     * Remove the specified author from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $author = Author::findOrFail($id);
        
        // Check if author has books
        if ($author->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete author with existing books'
            ], 400);
        }

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }
}
