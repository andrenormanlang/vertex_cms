<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
        public function handle(Request $request, Closure $next): Response
        {
            if ($this->isAdmin()) {
                return $next($request);
            }

            Log::warning('Unauthorized access attempt', [
                'user_id' => Auth::id(),
                'route' => $request->path(),
                'ip' => $request->ip(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'You are not authorized to access this page.'], 403);
        }

        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }

    private function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->is_admin;
    }
}
