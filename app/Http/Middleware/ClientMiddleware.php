<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ClientMiddleware
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
        if($request->user()->user_type != 'Client'){
            return redirect('/');
        }
        return $next($request);
    }
}
