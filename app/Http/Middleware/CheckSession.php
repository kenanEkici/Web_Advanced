<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckSession
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
        if($request->cookies->has('sessionId')) //check if user has a session_id
        {
            return $next($request);
        }
        else // if not then redirect to login page
        {
            $urlToAccess = $request->url();
            return Redirect::to('/')->with('errorNotLoggedIn', $urlToAccess);
        }
    }
}
