<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Main
{

    // ============================================================
    public function index()
    {
        Store::Layout([
            'layouts/header',
            'inicio',
            'layouts/footer',
        ]);
    }

    // ============================================================
    public function bilheteira()
    {
        //  buscar a lista de bilhetes disponiveis 
        $produtos = new Produtos();
        $lista_produtos = $produtos->lista_produtos_disponiveis();

        // apresenta a página da bilheteira 
        Store::Layout([
            'layouts/header_cart',
            'bilheteira',
            'layouts/footer',
        ], ['produtos' => $lista_produtos]);
    }

    // ============================================================
    public function contacto()
    {

        Store::Layout([
            'layouts/header',
            'contacto',
            'layouts/footer',
        ]);
    }

    // ============================================================
    public function sobre()
    {

        Store::Layout([
            'layouts/header',
            'sobre',
            'layouts/footer',
        ]);
    }


    // ============================================================
    public function novo_cliente()
    {

        // verifica se existe uma sessão aberta 
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // apresenta o layout para criar um novo utilizador
        Store::Layout([
            'layouts/header',
            'criar_cliente',
            'layouts/footer',
        ]);
    }

    //=============================================================
    public function criar_cliente()
    {
        //verifica se já existe sessão
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // verifica se senha 1 = senha 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {

            // as passwords são diferentes
            $_SESSION['erro'] = 'As senhas não estão iguais.';
            $this->novo_cliente();
            return;
        }

        // verifica na base de dados  se existe um cliente com o mesmo email
        $cliente = new Clientes();
        if ($cliente->verificar_email($_POST['text_email'])) {

            $_SESSION['erro'] = 'Já existe um cliente com o mesmo email.';
            $this->novo_cliente();
            return;
        }

        // Inserir novo  cliente  na base de dados e devolver o purl 
        $purl = $cliente->registar_cliente();

        // Envia um Email ao cliente com o purl para validar a conta 
        $email = new EnviarEmail();
        $email_cliente = strtolower(trim($_POST['text_email']));

        $resultado = $email->Enviar_Email_confirmacao_novo_cliente($email_cliente, $purl);
        if ($resultado) {
            Store::Layout([
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
            ]);
        } else {
            echo 'Aconteceu Um Erro';
        }
    }

    // ============================================================
    public function confirmar_email()
    {

        //verifica se já existe sessão
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verificar se existe na query string um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        $purl = $_GET['purl'];
        //verifica se o purl é valido 
        if (strlen($purl) != 16) {
            $this->index();
            return;
        }

        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);

        if ($resultado) {

            // apresenta o layout para informar a conta foi confirmada com sucesso
            Store::Layout([
                'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer',
            ]);
            return;
        } else {

            // redirecionar para a página inicial
            //Store::redirect();
        }
    }

    // ===========================================================
    public function login()
    {

        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // apresentação do formulário de login
        Store::Layout([
            'layouts/header',
            'login',
            'layouts/footer',
        ]);
    }



    // ===========================================================
    public function login_submit()
    {

        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar se os campos vieram corretamente preenchidos
        if (
            !isset($_POST['text_usuario']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento do formulário
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        }

        // prepara os dados para o model
        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_senha']);

        // carrega o model e verifica se login é válido
        $cliente = new Clientes();
        $resultado = $cliente->validar_login($usuario, $senha);

        // analisa o resultado
        if(is_bool($resultado)){
         
            // login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;

        } else {

            // login válido. Coloca os dados na sessão
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;

            // redirecionar para o local correto
            if(isset($_SESSION['tmp_carrinho'])){
                
                // remove a variável temporária da sessão
                unset($_SESSION['tmp_carrinho']);

                // redireciona para resumo da encomenda
                Store::redirect('finalizar_encomenda_resumo');

            } else {

                // redirectionamento para a loja
                Store::redirect();
            }
        }
    }


    // ===========================================================
    public function logout()
    {

        // remove as variáveis da sessão
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);

        // redireciona para o início da loja
        Store::redirect('index');
        return;
    }

    // ======================================================
    public function Enviar_email_contacto()
    {

        // verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar se os campos vieram corretamente preenchidos
        if (
            !isset($_POST['name']) ||
            !isset($_POST['phone']) ||
            !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) ||
            !isset($_POST['message'])
        ) {
            // erro de preenchimento do formulário
            $_SESSION['erro'] = 'Dados inválidos';
            Store::redirect('contacto');
            return;
        }


        $nome  = $_POST['name'];
        $telefone  = $_POST['phone'];
        $email_visitante  = $_POST['email'];
        $mensagem = $_POST['message'];

        $email_visitante = strtolower(trim($_POST['email']));

        $enviar_email = new EnviarEmail();
        $acao = $enviar_email->Enviar_email_contacto($email_visitante, $mensagem, $nome);

        if ($acao) {
            $_SESSION['Sucesso'] = 'Mensagem enviada, iremos responder assim que possível, obrigado.';
            Store::redirect('contacto');
            return;
        } else {
            $_SESSION['erro'] ='Aconteceu Um Erro';
            Store::redirect('contacto');
        }
    }

    // ======================================================
    public function Enviar_email_newlester()
    {

        // verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        // validar se os campos vieram corretamente preenchidos
        if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL))
         {
            // erro de preenchimento do formulário
            $_SESSION['erro'] = 'Dados inválidos';
            Store::redirect('contacto');
            return;
        }


        $email_visitante  = $_POST['email'];

        $email_visitante = strtolower(trim($_POST['email']));

        $enviar_email = new EnviarEmail();
        $acao = $enviar_email->Enviar_email_newlester($email_visitante);

        if ($acao) {
            $_SESSION['Sucesso'] = 'Mensagem enviada, iremos responder assim que possível, obrigado.';
            return;
        } else {
            $_SESSION['erro'] ='Aconteceu Um Erro';
        }
    }
    // ===========================================================
    // PERFIL DO USUÁRIO
    // ===========================================================
    public function minha_conta()
    {

        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // buscar informações do client
        $cliente = new Clientes();
        $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente']);

        $dados_cliente = [
            'Email' => $dtemp->email,
            'Nome completo' => $dtemp->nome_completo,
            'Telefone' => $dtemp->telefone
        ];

        $dados = [
            'dados_cliente' => $dados_cliente
        ];

        // apresentação da página de perfil
        Store::Layout([
            'layouts/header',
            'minha_conta',
            'minha_conta_nav',
            'layouts/footer',
        ], $dados);
    }


    // ===========================================================
    public function alterar_dados_pessoais()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // vai buscar os dados pessoais
        $cliente = new Clientes();
        $dados = [
            'dados_pessoais' => $cliente->buscar_dados_cliente($_SESSION['cliente'])
        ];

        // apresentação da página de perfil
        Store::Layout([
            'layouts/header',
            'alterar_dados_pessoais',
            'minha_conta_nav',
            'layouts/footer',
        ], $dados);
    }

    // ===========================================================
    public function alterar_dados_pessoais_submit()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $email = trim(strtolower($_POST['text_email']));
        $nome_completo = trim($_POST['text_nome_completo']);
        $telefone = trim($_POST['text_telefone']);

        // validar se é email válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "Endereço de email inválido.";
            $this->alterar_dados_pessoais();
            return;
        }

        // validar rapidamente os restantes campos
        if (empty($nome_completo)) {
            $_SESSION['erro'] = "Preencha corretamente o formulário.";
            $this->alterar_dados_pessoais();
            return;
        }

        // validar se este email já existe noutra conta de cliente
        $cliente = new Clientes();
        $existe_noutra_conta = $cliente->verificar_se_email_existe_noutra_conta($_SESSION['cliente'], $email);
        if ($existe_noutra_conta) {
            $_SESSION['erro'] = "O email já pertence a outro cliente.";
            $this->alterar_dados_pessoais();
            return;
        }

        // atualizar os dados do cliente na base de dados
        $cliente->atualizar_dados_cliente($email, $nome_completo, $telefone);

        // atualizar os dados do cliente na sessao
        $_SESSION['usuario'] = $email;
        $_SESSION['nome_cliente'] = $nome_completo;

        // redirecionar para a página do perfil
        Store::redirect('minha_conta');
    }

    // ===========================================================
    public function alterar_password()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // apresentação da página de alteração da password
        Store::Layout([
            'layouts/header',
            'alterar_password',
            'minha_conta_nav',
            'layouts/footer',
        ]);
    }

    // ===========================================================
    public function alterar_password_submit()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $senha_atual = trim($_POST['text_senha_atual']);
        $nova_senha = trim($_POST['text_nova_senha']);
        $repetir_nova_senha = trim($_POST['text_repetir_nova_senha']);

        // validar se a nova senha vem com dados
        if (strlen($nova_senha) < 6) {
            $_SESSION['erro'] = "Indique a nova senha e a repetição da nova senha.";
            $this->alterar_password();
            return;
        }

        // verificar se a nova senha a a sua repetição coincidem
        if ($nova_senha != $repetir_nova_senha) {
            $_SESSION['erro'] = "A nova senha e a sua repetição não são iguais.";
            $this->alterar_password();
            return;
        }

        // verificar se a senha atual está correta
        $cliente = new Clientes();
        if (!$cliente->ver_se_senha_esta_correta($_SESSION['cliente'], $senha_atual)) {
            $_SESSION['erro'] = "A senha atual está errada.";
            $this->alterar_password();
            return;
        }

        // verificar se a nova senha é diferente da senha atual
        if ($senha_atual == $nova_senha) {
            $_SESSION['erro'] = "A nova senha é igual à senha atual.";
            $this->alterar_password();
            return;
        }

        // atualizar a nova senha
        $cliente->atualizar_a_nova_senha($_SESSION['cliente'], $nova_senha);

        // redirecionar para a página do perfil
        Store::redirect('minha_conta');
    }

    // ===========================================================
    public function esqueceu_a_senha()
    {
        /*
        if(Store::clienteLogado())
        Store::redirect();
        return ('inicio');
        */
        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // verifica na base de dados  se existe um cliente com o mesmo email
        $cliente = new Clientes();
        if ($cliente->verificar_email(!isset($_POST['text_email']))) {

            $_SESSION['erro'] = 'Já existe um cliente com o mesmo email.';
            $this->novo_cliente();
            return;
        }

        // Envia um Email ao cliente para recuperar a senha  
        $email = new EnviarEmail();
        $email_cliente = strtolower(trim($_POST['text_email']));

        $resultado = $email->enviar_email_recuperar_senha($email_cliente);
        if ($resultado) {
            Store::Layout([
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
            ]);
        } else {
            echo 'Aconteceu Um Erro';
        }
    }

    // ===========================================================
    public function historico_encomendas()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // carrega o histórico das encomendas
        $encomendas = new Encomendas();
        $historico_encomendas = $encomendas->buscar_historico_encomendas($_SESSION['cliente']);

        // Store::printData($historico_encomendas);

        $data = [
            'historico_encomendas' => $historico_encomendas
        ];

        // apresentar a view com o histórico das encomendas
        Store::Layout([
            'layouts/header',
            'historico_encomendas',
            'minha_conta_nav',
            'layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function historico_encomendas_detalhe()
    {

        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se veio indicado um id_encomenda (encriptado)
        if (!isset($_GET['id'])) {
            Store::redirect();
            return;
        }

        $id_encomenda = null;

        // verifica se o id_encomenda é uma string com 32 caracteres
        if (strlen($_GET['id']) != 32) {
            Store::redirect();
            return;
        } else {
            $id_encomenda = Store::aesDesencriptar($_GET['id']);
            if (empty($id_encomenda)) {
                Store::redirect();
                return;
            }
        }

        // verifica se a encomenda pertence a este cliente
        $encomendas = new Encomendas();
        $resultado = $encomendas->verificar_encomenda_cliente($_SESSION['cliente'], $id_encomenda);
        if (!$resultado) {
            Store::redirect();
            return;
        }

        // vamos buscar os dados de detalhe da encomenda.
        $detalhe_encomenda = $encomendas->detalhes_de_encomenda($_SESSION['cliente'], $id_encomenda);

        // calcular o valor total da encomenda
        $total = 0;
        foreach ($detalhe_encomenda['produtos_encomenda'] as $produto) {
            $total += ($produto->quantidade * $produto->preco_unidade);
        }

        $data = [
            'dados_encomenda' => $detalhe_encomenda['dados_encomenda'],
            'produtos_encomenda' => $detalhe_encomenda['produtos_encomenda'],
            'total_encomenda' => $total
        ];

        // vamos apresentar a nova view com esses dados.
        Store::Layout([
            'layouts/header',
            'minha_conta_nav',
            'encomenda_detalhe',
            'layouts/footer',
        ], $data);
    }


    public function rino_detalhe()
    {
        

        // apresentação do formulário de login
        Store::Layout([
            'layouts/header',
            'rino',
            'layouts/footer',
        ]);
    }
}
