<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;
use core\models\Encomendas;

class carrinho
{
    // ===========================================================
    public function adicionar_carrinho()
    {
        // vai buscar o id_produto à query string
        if (!isset($_GET['n_bilhete'])) {

            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        // define o id do produto
        $n_bilhete = $_GET['n_bilhete'];

        $produtos = new Produtos();
        $resultados = $produtos->verificar_stock_produto($n_bilhete);

        if (!$resultados) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        // adiciona/gestão da variável de SESSAO do carrinho
        $carrinho = [];

        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
        }

        // adicionar o produto ao carrinho
        if (key_exists($n_bilhete, $carrinho)) {

            // já existe o produto. Acrescenta mais uma unidade
            $carrinho[$n_bilhete]++;
        } else {

            // adicionar novo produto ao carrinho
            $carrinho[$n_bilhete] = 1;
        }

        // atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach ($carrinho as $quantidade) {
            $total_produtos += $quantidade;
        }
        echo $total_produtos;
    }

    // ===========================================================
    public function remover_produto_carrinho()
    {

        // vai buscar o n_bilhete na query string
        $n_bilhete = $_GET['n_bilhete'];

        // buscar o carrinho à sessão
        $carrinho = $_SESSION['carrinho'];

        // remover o produto do carrinho
        unset($carrinho[$n_bilhete]);

        // atualizar o carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // apresentar novamente a página do carrinho
        $this->carrinho();
    }

    // ===========================================================
    public function limpar_carrinho()
    {

        // limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);

        // refrescar a página do carrinho
        $this->carrinho();
    }

    // ===========================================================
    public function carrinho()
    {
        // verificar se existe carrinho
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null
            ];
        } else {

            $ids = [];
            foreach ($_SESSION['carrinho'] as $n_bilhete => $quantidade) {
                array_push($ids, $n_bilhete);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);


            /* 
            fazer um ciclo por cada produto no carrinho
                - identificar o id e usar os dados da bd para criar
                  uma coleção de dados para a página do carrinho

                imagem | titulo | quantidade | preço | xxx
            */

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $n_bilhete => $quantidade_carrinho) {

                // imagem do produto
                foreach ($resultados as $produto) {
                    if ($produto->n_bilhete == $n_bilhete) {
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_bilhete;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;

                        // colocar o produto na coleção
                        array_push($dados_tmp, [
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);

                        break;
                    }
                }
            }

            // calcular o total
            $total_da_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_da_encomenda += $item['preco'];
            }
            array_push($dados_tmp, $total_da_encomenda);

            $dados = [
                'carrinho' => $dados_tmp
            ];
        }

        // apresenta a página do carrinho
        Store::Layout([
            'layouts/header_cart',
            'carrinho',
            'layouts/footer',
        ], $dados);
    }

    // ===========================================================
    public function finalizar_encomenda()
    {

        // verifica se existe cliente logado
        if (!isset($_SESSION['cliente'])) {

            // coloca na sessão um referrer temporário
            $_SESSION['tmp_carrinho'] = true;

            // redirecionar para o quadro de login
            Store::redirect('login');
        } else {

            Store::redirect('finalizar_encomenda_resumo');
        }
    }

    // ===========================================================
    public function finalizar_encomenda_resumo()
    {

        // verifica se existe cliente logado
        if (!isset($_SESSION['cliente'])) {
            Store::redirect('inicio');
        }

        // verifica se pode avançar para gravação da encomenda
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            Store::redirect('inicio');
            return;
        }

        // -------------------------------------------------------
        // informações do carrinho
        $ids = [];
        foreach ($_SESSION['carrinho'] as $n_bilhete => $quantidade) {
            array_push($ids, $n_bilhete);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);

        $dados_tmp = [];
        foreach ($_SESSION['carrinho'] as $n_bilhete => $quantidade_carrinho) {

            // imagem do produto
            foreach ($resultados as $produto) {
                if ($produto->n_bilhete == $n_bilhete) {
                    $n_bilhete = $produto->n_bilhete;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_bilhete;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;

                    // colocar o produto na coleção
                    array_push($dados_tmp, [
                        'n_bilhete' => $n_bilhete,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);

                    break;
                }
            }
        }

        // calcular o total
        $total_da_encomenda = 0;
        foreach ($dados_tmp as $item) {
            $total_da_encomenda += $item['preco'];
        }
        array_push($dados_tmp, $total_da_encomenda);

        // preparar os dados da view
        $dados = [];
        $dados['carrinho'] = $dados_tmp;

        // -------------------------------------------------------
        // buscar informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;

        // -------------------------------------------------------
        // gerar o código da encomenda
        if (!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda = Store::gerarCodigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
            $_SESSION['total_encomenda'] = $total_da_encomenda;
        }

        // apresenta a página do carrinho
        Store::Layout([
            'layouts/header_cart',
            'encomenda_resumo',
            'layouts/footer',
        ], $dados);
    }

    // ===========================================================
    public function morada_alternativa()
    {

        // receber os dados via AJAX(axios)
        $post = json_decode(file_get_contents('php://input'), true);

        // adiciona ou altera na sessão a variável (coleção / array) dados_alternativos
        $_SESSION['dados_alternativos'] = [
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone'],
        ];
    }

    // ===========================================================
    public function confirmar_encomenda()
    {

        // verifica se existe cliente logado
        if (!isset($_SESSION['cliente'])) {
            Store::redirect();
        }

        // verifica se pode avançar para a gravação da encomenda
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect('inicio');
            return;
        }

        // ---------------------------------------
        // enviar email para o cliente com os dados da encomenda e pagamento
        $dados_encomenda = [];

        // buscar os dados dos produtos
        $ids = [];
        foreach ($_SESSION['carrinho'] as $n_bilhete => $quantidade) {
            array_push($ids, $n_bilhete);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos->buscar_produtos_por_ids($ids);

        // estrutura dos dados dos produtos
        $string_produtos = [];

        foreach ($produtos_da_encomenda as $resultado) {

            // quantidade
            $quantidade = $_SESSION['carrinho'][$resultado->n_bilhete];

            // string do produto
            $string_produtos[] = "$quantidade x $resultado->nome_bilhete - " . number_format($resultado->preco, 2, ',', '.') . '€ / Uni.';
        }

        // lista de produtos para o email
        $dados_encomenda['lista_produtos'] = $string_produtos;

        // preco total da encomenda para o email
        $dados_encomenda['total'] = number_format($_SESSION['total_encomenda'], 2, ',', '.') . '€';

        // dados de pagamento
        $dados_encomenda['dados_pagamento'] = [
            'referência' => '6789',
            'entidade' => '305314',
            'codigo_encomenda' => $_SESSION['codigo_encomenda'],
            'total' => number_format($_SESSION['total_encomenda'], 2, ',', '.') . '€'
        ];

        // enviar o email para o cliente com os dados da encomenda
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'], $dados_encomenda);
        

        // ---------------------------------------
        // guardar na base de dados a encomenda

        $dados_encomenda = [];
        $dados_encomenda['id_cliente'] = $_SESSION['cliente'];
        // morada
        if (isset($_SESSION['dados_alternativos']['morada']) && !empty($_SESSION['dados_alternativos']['morada'])) {

            // considerar a morada alternativa
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {

            // considerar a morada do cliente na base de dados
            $CLIENTE = new Clientes();
            $dados_cliente = $CLIENTE->buscar_dados_cliente($_SESSION['cliente']);

            $dados_encomenda['email'] = $dados_cliente->email;
            $dados_encomenda['telefone'] = $dados_cliente->telefone;
        }

        // codigo encomenda
        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];

        // status
        $dados_encomenda['status'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';

        // -----------------------------------
        // dados dos produtos da encomenda
        // $produtos_da_encomenda (nome_produto, preco)
        $dados_produtos = [];
        foreach ($produtos_da_encomenda as $produto) {
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome_bilhete,
                'preco_unidade' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->n_bilhete]
            ];
        }

        $encomenda = new Encomendas();
        $encomenda->guardar_encomenda($dados_encomenda, $dados_produtos);

        // preparar dados para apresentar na página de agradecimento
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        // ---------------------------------------
        // limpar todos os dados da encomenda que estão no carrinho
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['total_encomenda']);
        unset($_SESSION['dados_alternativos']);

        // ---------------------------------------
        // apresenta a página a agradecer a encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];
        Store::Layout([
            'layouts/header_cart',
            'encomenda_confirmada',
            'layouts/footer',
        ], $dados);
    }
}
