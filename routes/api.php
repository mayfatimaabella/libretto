<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibrettoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Debug AuthController
Route::get('/debug-auth', function () {
    $controller = new App\Http\Controllers\AuthController();
    return response()->json(['message' => 'AuthController loaded successfully']);
});

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

// Libretto routes
Route::apiResource('librettos', LibrettoController::class);