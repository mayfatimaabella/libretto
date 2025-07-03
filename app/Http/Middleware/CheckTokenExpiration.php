<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckTokenExpiration
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $token = $request->user()->currentAccessToken();
            
            if ($token && $token->created_at->addDay()->isPast()) {
                $token->delete();
                return response()->json(['message' => 'Token expired'], 401);
            }
        }

        return $next($request);
    }
}
