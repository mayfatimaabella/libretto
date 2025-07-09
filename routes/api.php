<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibrettoController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\GenreApiController;
use App\Http\Controllers\Api\ReviewApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes - require authentication
Route::middleware(['auth:sanctum', 'check.token.expiration'])->group(function () {
    // Debug/Test route for authentication
    Route::get('/test-auth', function (Request $request) {
        return response()->json([
            'message' => 'Authenticated successfully',
            'user' => $request->user(),
            'token' => $request->user()->currentAccessToken(),
            'debug' => [
                'token_id' => $request->user()->currentAccessToken()->id,
                'token_name' => $request->user()->currentAccessToken()->name,
                'token_created' => $request->user()->currentAccessToken()->created_at,
                'token_expires' => $request->user()->currentAccessToken()->created_at->addDay(),
                'current_time' => \Carbon\Carbon::now(),
                'is_expired' => $request->user()->currentAccessToken()->created_at->addDay()->isPast()
            ]
        ]);
    });
    
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
    Route::delete('/tokens/{tokenId}', [AuthController::class, 'deleteSpecificToken']);

    // CRUD routes for all resources
    Route::apiResource('authors', AuthorApiController::class);
    Route::apiResource('books', BookApiController::class);
    Route::apiResource('genres', GenreApiController::class);
    Route::apiResource('reviews', ReviewApiController::class);
    
    // Additional routes
    Route::get('/books/{book}/reviews', [ReviewApiController::class, 'getBookReviews']);
    
    // Dashboard stats
    Route::get('/dashboard/stats', function () {
        $stats = [
            'total_authors' => \App\Models\Author::count(),
            'total_books' => \App\Models\Book::count(),
            'total_genres' => \App\Models\Genre::count(),
            'total_reviews' => \App\Models\Review::count(),
            'total_users' => \App\Models\User::count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'message' => 'Dashboard stats retrieved successfully'
        ]);
    });
});

// Public routes (read-only access)
Route::prefix('public')->group(function () {
    Route::get('/authors', [AuthorApiController::class, 'index']);
    Route::get('/authors/{author}', [AuthorApiController::class, 'show']);
    Route::get('/books', [BookApiController::class, 'index']);
    Route::get('/books/{book}', [BookApiController::class, 'show']);
    Route::get('/genres', [GenreApiController::class, 'index']);
    Route::get('/genres/{genre}', [GenreApiController::class, 'show']);
    Route::get('/reviews', [ReviewApiController::class, 'index']);
    Route::get('/books/{book}/reviews', [ReviewApiController::class, 'getBookReviews']);
});

// Legacy routes (keeping for backward compatibility)
Route::apiResource('librettos', LibrettoController::class);