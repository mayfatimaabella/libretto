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
        
        // Check if user has an existing valid token (not expired)
        $existingToken = $user->tokens()
            ->where('created_at', '>', Carbon::now()->subDay())
            ->first();

        if ($existingToken) {
            // For existing tokens, we can't return the plainTextToken (it's hashed)
            // So we need to delete and create a new one
            $user->tokens()->delete();
            
            // Create new token
            $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addDay());
            
            return response()->json([
                'message' => 'Previous token expired, new token generated',
                'token' => $token->plainTextToken,
                'expires_at' => Carbon::now()->addDay(),
                'user' => $user,
                'token_created' => Carbon::now(),
                'note' => 'Use this new token for API calls'
            ]);
        }

        // Delete all expired tokens and create new one only if no valid token exists
        $user->tokens()->delete();
        
        // Create new token with 24-hour expiration
        $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addDay(),
            'user' => $user,
            'message' => 'New token generated - save this token!',
            'token_created' => Carbon::now(),
            'important' => 'This token will not be shown again. Save it now!'
        ]);
    }

    public function logout(Request $request)
    {
        try {
            // Simple logout without complex debugging
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated. Make sure you have Authorization Bearer token set.'
                ], 401);
            }
            
            // Delete all tokens for the user
            $user->tokens()->delete();
            
            return response()->json(['message' => 'Logged out successfully']);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
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
    
    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            // Delete all user's tokens first
            $user->tokens()->delete();
            
            // Delete all user's reviews
            $user->reviews()->delete();
            
            // Delete the user account
            $user->delete();
            
            return response()->json([
                'message' => 'Account deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Account deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
