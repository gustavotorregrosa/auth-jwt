<?php

namespace App\Http\Middleware;

use Closure;

class CheckJWT
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

        if(isJwtValido($request)){
            \Log::debug("token foi valido sim");
            return $next($request);
        }

        if($conteudoRefresh = refreshToken($request)){
            return respostaCors($conteudoRefresh, 203);
        }

        return respostaCors("Login com senha", 301);
    }
}
