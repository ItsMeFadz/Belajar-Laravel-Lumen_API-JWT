<?php

namespace App\Http\Middleware;

use Closure;

class ParseJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isJson()) {
            $jsonData = json_decode($request->getContent(), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $request->merge($jsonData);
            }
        }

        return $next($request);
    }
}

