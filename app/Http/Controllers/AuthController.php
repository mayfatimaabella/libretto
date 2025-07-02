<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = $request->user();

        $existingToken = $user->tokens()->first();
        if ($existingToken && Carbon::parse($existingToken->created_at)->addDay()->isFuture()) {
            return response()->json(['token' => $existingToken->plainTextToken]);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
