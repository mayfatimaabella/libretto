<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibrettoController;
use App\Http\Controllers\Api\AuthorApiController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\GenreApiController;
use App\Http\Controllers\Api\ReviewApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Public API routes (no authentication required) - READ operations only
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

// Demonstration: API routes using closures (without controllers)
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'app' => config('app.name')
    ]);
});

Route::get('/authors/count', function () {
    return response()->json([
        'count' => \App\Models\Author::count(),
        'endpoint' => 'closure-based route'
    ]);
});

// Protected API routes (authentication required via Sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Test authentication endpoint
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
    
    // Auth management routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);
    Route::delete('/tokens/{tokenId}', [AuthController::class, 'deleteSpecificToken']);

    // Resource WRITE operations (CREATE, UPDATE, DELETE) - READ operations available in public routes
    Route::post('/authors', [AuthorApiController::class, 'store']);
    Route::put('/authors/{author}', [AuthorApiController::class, 'update']);
    Route::patch('/authors/{author}', [AuthorApiController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorApiController::class, 'destroy']);
    
    Route::post('/books', [BookApiController::class, 'store']);
    Route::put('/books/{book}', [BookApiController::class, 'update']);
    Route::patch('/books/{book}', [BookApiController::class, 'update']);
    Route::delete('/books/{book}', [BookApiController::class, 'destroy']);
    
    Route::post('/genres', [GenreApiController::class, 'store']);
    Route::put('/genres/{genre}', [GenreApiController::class, 'update']);
    Route::patch('/genres/{genre}', [GenreApiController::class, 'update']);
    Route::delete('/genres/{genre}', [GenreApiController::class, 'destroy']);
    
    Route::post('/reviews', [ReviewApiController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewApiController::class, 'update']);
    Route::patch('/reviews/{review}', [ReviewApiController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewApiController::class, 'destroy']);
    
    // Dashboard stats (protected route)
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

// Legacy routes (keeping for backward compatibility)
Route::apiResource('librettos', LibrettoController::class);