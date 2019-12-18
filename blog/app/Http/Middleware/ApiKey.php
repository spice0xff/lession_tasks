<?php

namespace App\Http\Middleware;

use Closure;

class ApiKey
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
        return $next($request);
        
        if ($request->header('x-api-key') != env("API_KEY")) {
            return response("ASS",401);
        }

        return $next($request);
    }
}
