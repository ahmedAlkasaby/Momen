<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetUserApiLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang=app()->getLocale();

        if($request->header('lang')){
            $lang=$request->header('lang');
        }

        $auth=Auth::guard('api')->user();
        if($auth && $auth->lang != $lang){
            $lang=$auth->lang;
        }

        app()->setLocale($lang);

        return $next($request);
    }
}
