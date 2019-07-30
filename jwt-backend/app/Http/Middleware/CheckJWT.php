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
            \Auth::login(objUsuario(usuarioDoToken($request)));
            return $next($request);
        }

        if($conteudoRefresh = refreshToken($request)){
            return respostaCors($conteudoRefresh, 203);
        }

        return respostaCors("Login com senha", 301);
    }


    public function terminate($request, $response)
    {
       Auth::logout();
    }
}
