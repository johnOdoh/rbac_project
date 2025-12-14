<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAuthorized
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!request()->user()?->is_authorized($permission)) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => 'You are not authorized to perform this action'
            ], 400);
        }
        return $next($request);
    }
}