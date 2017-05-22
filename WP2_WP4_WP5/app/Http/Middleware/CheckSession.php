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

    //middleware om binnenkomende requests te checken of dat ze een sessie hebben
    public function handle($request, Closure $next)
    {
        if($request->cookies->has('sessionId')) //check if user has a session_id
        {
            return $next($request);
        }
        else //als ze geen sessiecookie hebben worden ze geredirect naar index
        {
            $urlToAccess = $request->url();
            return Redirect::to('/')->with('errorNotLoggedIn', $urlToAccess);
        }
    }
}
