<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Memeriksa token dan mengautentikasi pengguna
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found.'], 404);
            }
        } catch (JWTException $e) {
            // Menangani berbagai jenis kesalahan token
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired'], 401);
            } else {
                return response()->json(['error' => 'Authorization Token not found'], 401);
            }
        }

        \Log::info('Authorization Header: ', [$request->header('Authorization')]);

        return $next($request);
    }
}
