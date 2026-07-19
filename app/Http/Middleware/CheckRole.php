<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Ensure the user is authenticated via Sanctum
        if (! $request->user()) {
            return response()->json(['message' => __('auth.account.unauthenticated')], 401);
        }

        // 2. Check if the user's role matches any of the allowed roles passed to the middleware
        if (! in_array($request->user()->role, $roles)) {
            return response()->json([
                'status'  => 'error',
                'message' => __('auth.account.unauthorized')
            ], 403);
        }

        return $next($request);
    }
}
