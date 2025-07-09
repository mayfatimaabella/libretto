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
        
        $existingToken = $user->tokens()
            ->where('created_at', '>', Carbon::now()->subMinute())
            ->first();

        if ($existingToken) {
            return response()->json([
                'message' => 'You already have a valid token. Please use your existing token.',
                'token_exists' => true,
                'token_created' => $existingToken->created_at,
                'token_expires' => $existingToken->created_at->addMinute(),
                'user' => $user,
                'hours_until_expiry' => Carbon::now()->diffInHours($existingToken->created_at->addMinute()),
                'note' => 'Your existing token is still valid. No new token generated.'
            ]);
        }

        $user->tokens()->where('created_at', '<=', Carbon::now()->subMinute())->delete();
        
        $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addDay());

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addMinute(),
            'user' => $user,
            'message' => 'New token generated - save this token!',
            'token_created' => Carbon::now(),
            'important' => 'This token will not be shown again. Save it now!'
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated. Make sure you have Authorization Bearer token set.'
                ], 401);
            }
            
            $deletedTokens = $user->tokens()->count();
            $user->tokens()->delete();
            
            return response()->json([
                'message' => 'Logged out successfully',
                'user_id' => $user->id,
                'deleted_tokens' => $deletedTokens
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $token = $user->currentAccessToken();
        
        return response()->json([
            'user' => $user,
            'token_created' => $token->created_at,
            'token_expires' => $token->created_at->addMinute(),
            'token_valid' => $token->created_at->addMinute()->isFuture()
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

        $token = $user->createToken('libretto-token', ['*'], Carbon::now()->addMinute());

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => Carbon::now()->addMinute(),
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
    
    public function deleteSpecificToken(Request $request, $tokenId)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated'
                ], 401);
            }
            
            // Find the specific token belonging to the user
            $token = $user->tokens()->where('id', $tokenId)->first();
            
            if (!$token) {
                return response()->json([
                    'message' => 'Token not found or does not belong to you'
                ], 404);
            }
            
            // Delete the specific token
            $token->delete();
            
            return response()->json([
                'message' => 'Token deleted successfully',
                'deleted_token_id' => $tokenId
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Token deletion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
