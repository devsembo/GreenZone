<?php

// COLEÇÃO DE ROTAS 
$rotas = [
    'inicio' => 'main@index',
    'bilheteira' => 'main@bilheteira',
    'contacto' => 'main@contacto',
    'sobre' => 'main@sobre',
    'rino' => 'main@rino_detalhe',

    // Clientes  
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'confirmar_email' => 'main@confirmar_email',

    // Perfil
    'minha_conta' => 'main@minha_conta',
    'alterar_dados_pessoais' => 'main@alterar_dados_pessoais',
    'alterar_dados_pessoais_submit' => 'main@alterar_dados_pessoais_submit',
    'alterar_password' => 'main@alterar_password',
    'alterar_password_submit' => 'main@alterar_password_submit',
    'historico_encomendas' => 'main@historico_encomendas',
    'historico_encomendas_detalhe' => 'main@historico_encomendas_detalhe',

    // contacto
    'Enviar_email_contacto' => 'main@Enviar_email_contacto',

    //login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',
    'esqueceu_a_senha' => 'main@esqueceu_a_senha',

    // Carrinho
    'carrinho' => 'carrinho@carrinho',
    'adicionar_carrinho' => 'carrinho@adicionar_carrinho',
    'limpar_carrinho' => 'carrinho@limpar_carrinho',
    'finalizar_encomenda' => 'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo' => 'carrinho@finalizar_encomenda_resumo',
    'confirmar_encomenda' => 'carrinho@confirmar_encomenda',
    'encomenda_confirmada' => 'carrinho@Encomenda_confirmada',

];

// define por ação por defeito
$acao = 'inicio';

// verifica  se existe ação na query string 
if(isset($_GET['a'])){

    // verifica se a ação existe nas rotas
    if(!key_exists($_GET['a'], $rotas)){
        $acao = 'inicio';
    } else{
        $acao =$_GET['a'];
    }
}

// trata a definição da rota 
$partes = explode('@', $rotas[$acao]);
$controlador = 'core\\controllers\\'.ucfirst($partes[0]);
$metodo = $partes[1];

$ctr = new $controlador();
$ctr ->$metodo();