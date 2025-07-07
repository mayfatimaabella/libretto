<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GenreApiController extends Controller
{
    /**
     * Display a listing of the genres.
     */
    public function index(): JsonResponse
    {
        $genres = Genre::withCount('books')->get();
        
        return response()->json([
            'success' => true,
            'data' => $genres,
            'message' => 'Genres retrieved successfully'
        ]);
    }

    /**
     * Store a newly created genre in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::create($request->only(['name', 'description']));

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre created successfully'
        ], 201);
    }

    /**
     * Display the specified genre.
     */
    public function show(string $id): JsonResponse
    {
        $genre = Genre::with('books.author')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre retrieved successfully'
        ]);
    }

    /**
     * Update the specified genre in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:genres,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $genre = Genre::findOrFail($id);
        $genre->update($request->only(['name', 'description']));

        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre updated successfully'
        ]);
    }

    /**
     * Remove the specified genre from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $genre = Genre::findOrFail($id);
        
        // Check if genre has books
        if ($genre->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete genre with existing books'
            ], 400);
        }

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully'
        ]);
    }
}
