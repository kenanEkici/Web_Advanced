<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class RoleMiddleware
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
        if ($request->cookies->has('sessionId')) //check if authorised
        {
            return $next($request);
        }
        else
        {
            $urlToAccess = $request->url();
            return Redirect::to('/')->with('errorAuthorisation', $urlToAccess);
        }
    }
}
