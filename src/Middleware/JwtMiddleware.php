<?php

namespace Jamkrindo\Middleware;

use Closure;

class JwtMiddleware
{
    public string $middlewareAliases= 'jwt';

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}