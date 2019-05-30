<?php

namespace App\Http\Middleware;

use Closure;

class CheckPartenaire
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

        if( Auth::user()->organisation_id == 1)
        {
            return response('unauthorized',401);
        }else {
            return $next($request);
        }
    }
}
