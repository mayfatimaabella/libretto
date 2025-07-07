<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewApiController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(): JsonResponse
    {
        $reviews = Review::with(['book.author', 'user'])->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $reviews,
            'message' => 'Reviews retrieved successfully'
        ]);
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // Check if user already reviewed this book
        $existingReview = Review::where('book_id', $request->book_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this book'
            ], 400);
        }

        $review = Review::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $review->load(['book.author', 'user']);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review created successfully'
        ], 201);
    }

    /**
     * Display the specified review.
     */
    public function show(string $id): JsonResponse
    {
        $review = Review::with(['book.author', 'user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review retrieved successfully'
        ]);
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::findOrFail($id);

        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update your own reviews'
            ], 403);
        }

        $review->update($request->only(['rating', 'comment']));
        $review->load(['book.author', 'user']);

        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review updated successfully'
        ]);
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $review = Review::findOrFail($id);

        // Check if user owns this review
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own reviews'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Get reviews for a specific book.
     */
    public function getBookReviews(string $bookId): JsonResponse
    {
        $book = Book::findOrFail($bookId);
        $reviews = Review::with(['user'])
            ->where('book_id', $bookId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'book' => $book,
                'reviews' => $reviews,
                'average_rating' => $reviews->avg('rating'),
                'total_reviews' => $reviews->count()
            ],
            'message' => 'Book reviews retrieved successfully'
        ]);
    }
}
