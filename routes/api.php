<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibrettoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});

// Libretto routes
Route::apiResource('librettos', LibrettoController::class);