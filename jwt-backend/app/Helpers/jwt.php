<?php

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;



function isJwtValido($request, $validade = 2)
{
    if(!$jwt = $request->header('jwt')){
        return false;
    }
    $token = (new Parser())->parse((string) $jwt);
    $signer = new Sha256();
    $dataValidation = new ValidationData();
    if ($token->validate($dataValidation) && $token->verify($signer, env('APP_KEY'))) {
        $validade *= 60 * 60;
        if (($token->getClaim('iat') + $validade > time()) && ($token->getClaim('iat') < time())) {
            return true;
        }
    }
    return false;
}


function usuarioDoToken($request){
    $token = (new Parser())->parse((string) $request->header('jwt'));
    return [
        'id' => $token->getClaim('id'),
        'email' => $token->getClaim('email')
    ];
}


function objUsuario($usuarioToken){
    $usuario = new \App\User();
    $usuario->id = $usuarioToken['id'];
    $usuario->email = $usuarioToken['email'];
    return $usuario;
}


function usuarioDoBanco($usuarioToken){
    if($usuario = \App\User::where('id', $usuarioToken['id'])->where('email', $usuarioToken['email'])->first()){
        return $usuario;
    }
    return false;
}

function refreshToken($request)
{
    $validade = 24*15;
    if(!isJwtValido($request, $validade)){
        return false;
    }

    if($usuario = usuarioDoBanco(usuarioDoToken($request))){
        return dadosUsuario($usuario);
    }

}


function dadosUsuario($usuario)
{
    return [
        'usuario' => [
            'nome' => $usuario->name,
            'email' => $usuario->email,

        ],
        'jwt' => tokenUsuario($usuario)
    ];
}

function tokenUsuario($usuario)
{
    function geraStringParcial($arr){
        $arr = json_encode($arr);
        $str = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($arr));
        return $str;
    }
    $headers = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];
    $claims = [
        'id' => $usuario->id,
        'name' => $usuario->name,
        'email' => $usuario->email,
        'iat' => time()
    ];
    $token = geraStringParcial($headers);
    $token .=".".geraStringParcial($claims);
    $signature = hash_hmac('sha256', $token, env('APP_KEY'), true);
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    $token .= ".".$signature;
    return $token;
}
