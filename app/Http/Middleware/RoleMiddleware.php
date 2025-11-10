<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /*
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        $user = $request->user();

        if(!$user) return response()->json(['error'=>'Unauthenticated'],401);

        $has = $user->roles()->whereIn('name',$roles)->exists();
        
        if(!$has) return response()->json(['error'=>'Forbidden'],403);
        return $next($request);
    }*/
public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Forbidden: Insufficient permissions'], 403);
        }

        return $next($request);
    }
    
}
