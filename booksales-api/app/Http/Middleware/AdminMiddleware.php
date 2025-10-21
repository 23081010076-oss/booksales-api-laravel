<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized - Admin only'], 401);
        }

        return $next($request);
    }

}
