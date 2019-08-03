<?php

namespace App;

use \Lcobucci\JWT\Parser;
use \Lcobucci\JWT\Signer\Hmac\Sha256;
use \Lcobucci\JWT\ValidationData;


class JWTValidator
{


    function __construct($request)
    {
        $this->request = $request;
        $this->jwt = $this->request->header('jwt');
    }


    public function isStringJwt(){
        return (strlen($this->jwt) > 10);
    }


    public function isJwtValido($validade = 2)
    {
        if(!$this->isStringJwt()){
            return false;
        }

        $token = (new Parser())->parse((string) $this->jwt);
        $signer = new Sha256();
        $dataValidation = new ValidationData();
        if ($token->validate($dataValidation) && $token->verify($signer, env('APP_KEY'))) {
            $validade *= 60 * 60;
            if (($token->getClaim('iat') + $validade >= time()) && ($token->getClaim('iat') <= time())) {
                return true;
            }
        }
        return false;
    }


    public function usuarioDoToken()
    {
        if(!$this->isStringJwt()){
            return false;
        }
        $token = (new Parser())->parse((string) $this->jwt);
        return [
            'id' => $token->getClaim('id'),
            'email' => $token->getClaim('email')
        ];
    }


    public function objUsuario()
    {
        $usuarioToken = $this->usuarioDoToken();
        $usuario = new \App\User();
        $usuario->id = $usuarioToken['id'];
        $usuario->email = $usuarioToken['email'];
        return $usuario;
    }


    public function usuarioDoBanco()
    {
        $usuarioToken = $this->usuarioDoToken();
        if ($usuario = \App\User::where('id', $usuarioToken['id'])->where('email', $usuarioToken['email'])->first()) {
            return $usuario;
        }
        return false;
    }

    public function refreshToken()
    {
        $validade = 24 * 15;
        if (!$this->isJwtValido($validade)) {
            return false;
        }

        if ($usuario = $this->usuarioDoBanco()) {
            return self::dadosUsuario($usuario);
        }
    }


    static public function dadosUsuario($usuario)
    {
        return [
            'usuario' => [
                'nome' => $usuario->name,
                'email' => $usuario->email,

            ],
            'jwt' => self::tokenUsuario($usuario)
        ];
    }

    static public function tokenUsuario($usuario)
    {
        function geraStringParcial($arr)
        {
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
        $token .= "." . geraStringParcial($claims);
        $signature = hash_hmac('sha256', $token, env('APP_KEY'), true);
        $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $token .= "." . $signature;
        return $token;
    }
}
