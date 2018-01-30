<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }
        switch ($guard) {
            case 'web':
                if(Auth::guard($guard)->check()){
                    return redirect('/admin/home');
                }
                break;

            case 'client':
                if(Auth::guard($guard)->check()){
                    return redirect('/client/home');
                }
                break;

            case 'supplier':
                if(Auth::guard($guard)->check()){
                    return redirect('/supplier/home');
                }
                break;
            
            default:
                return $next($request);
                break;
        }

        
    }
}
