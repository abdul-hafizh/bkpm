<?php

namespace SimpleCMS\Core\Http\Middleware;

use Closure;

class HttpsProtocol
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
        if (!$request->secure() && force_https())
        {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
