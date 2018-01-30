<?php

namespace App\Http\Middleware;

use Closure;

class SuppliersMiddleware
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
        if($request->user()->user_type != 'Suppliers'){
            return redirect('/');
        }
        return $next($request);
    }
}
