<?php

function respostaCors($conteudo, $codigo){
    $conteudo = json_encode($conteudo);
    $resposta = response($conteudo, $codigo);
    $resposta->header('Content-Type', 'application/json');
    $resposta->header('Access-Control-Allow-Origin', '*');
    return $resposta;
}

