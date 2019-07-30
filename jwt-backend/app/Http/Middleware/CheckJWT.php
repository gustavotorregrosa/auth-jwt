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
        $jwtValidator = new \App\JWTValidator($request);
        if($jwtValidator->isJwtValido()){
            \Auth::login($jwtValidator->objUsuario());
            return $next($request);
        }
        if($conteudoRefresh = $jwtValidator->refreshToken()){
            return respostaCors($conteudoRefresh, 203);
        }
        return respostaCors("Login com senha", 301);
    }


    public function terminate($request, $response)
    {  
        if(\Auth::check()) {
            \Auth::logout();
        }
    }
}
