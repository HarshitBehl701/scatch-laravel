<?php

namespace App\Http\Middleware\Api\v1\AuthMiddleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        if(Session::has('userType') &&  Session::has('email') &&  Session::get('userType') == $role){
            return $next($request);
        }else{
            return  redirect('/login')->with('error','Please  Login First');
        }
    }
}
