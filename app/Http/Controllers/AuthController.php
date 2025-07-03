<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        
        // Check if user has an existing valid token (created within last 24 hours)
        $existingToken = $user->tokens()
            ->where('created_at', '>', Carbon::now()->subDay())
            ->first();

        if ($existingToken) {
            // Return existing token info (note: plainTextToken is only available on creation)
            return response()->json([
                'message' => 'Using existing valid token',
                'token_name' => $existingToken->name,
                'expires_at' => $existingToken->created_at->addDay(),
                'user' => $user
            ]);
        }

        // Delete all old tokens and create new one
        $user->tokens()->delete();
        
        // Create new token with 24-hour expiration
        $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addDay(),
            'user' => $user,
            'message' => 'Login successful'
        ]);
    }

    public function logout(Request $request)
    {
        // Delete all tokens for the user
        $request->user()->tokens()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'token_created' => $request->user()->currentAccessToken()->created_at,
            'token_expires' => $request->user()->currentAccessToken()->created_at->addDay()
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addDay(),
            'user' => $user,
            'message' => 'Registration successful'
        ], 201);
    }
}
