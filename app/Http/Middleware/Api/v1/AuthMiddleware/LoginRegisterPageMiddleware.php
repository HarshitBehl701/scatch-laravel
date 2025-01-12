<?php

namespace App\Http\Middleware\Api\v1\AuthMiddleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class LoginRegisterPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('userType') &&  Session::has('email')){
            return  redirect('/'.session("userType").'/profile')->with('error','You  Are  Already Login');
        }else{
            return $next($request);
        }
    }
}
