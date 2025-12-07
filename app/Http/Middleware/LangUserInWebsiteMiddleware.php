<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class LangUserInWebsiteMiddleware
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

        $auth=Auth::user();
        if($auth && $auth->locale != $lang){
            $lang=$auth->locale;
        }

        app()->setLocale($lang);

        return $next($request);
    }
}
