<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\PDF;
use core\classes\Store;
use core\models\AdminModel;

class admin
{
    // ===========================================================
    // usuário admin: admin@admin.com
    // senha:         123456
    // ===========================================================
    public function index()
    {
        // verifica se já existe sessão aberta (admin)
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        // verificar se existem encomendas em estado PENDENTE
        $ADMIN = new AdminModel();
        $total_encomendas_pendentes = $ADMIN->total_encomendas_pendentes();
        $total_encomendas_em_processamento = $ADMIN->total_encomendas_em_processamento();

        $data = [
            'total_encomendas_pendentes' => $total_encomendas_pendentes,
            'total_encomendas_em_processamento' => $total_encomendas_em_processamento
        ];

        // já existe um admin logado
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
        ], $data);
    }


    // ===========================================================
    // AUTENTICAÇÃO
    // ===========================================================
    public function admin_login()
    {

        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // apresenta o quadro de login
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/login_frm',
            'admin/layouts/footer',
        ]);
    }

    // ===========================================================
    public function admin_login_submit()
    {
        // verifica se já existe um utilizador logado
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se foi efetuado o post do formulário de login do admin
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio', true);
            return;
        }

        // validar se os campos vieram corretamente preenchidos
        if (
            !isset($_POST['text_admin']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento do formulário
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('admin_login', true);
            return;
        }

        // prepara os dados para o model
        $admin = trim(strtolower($_POST['text_admin']));
        $senha = trim($_POST['text_senha']);

        // carrega o model e verifica se login é válido
        $admin_model = new AdminModel();
        $resultado = $admin_model->validar_login($admin, $senha);

        // analisa o resultado
        if (is_bool($resultado)) {

            // login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login', true);
            return;
        } else {

            // login válido. Coloca os dados na sessão do admin
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_usuario'] = $resultado->usuario;

            // redirecionar para a página inicial do backoffice
            Store::redirect('inicio', true);
        }
    }

    // ===========================================================
    public function admin_logout()
    {

        // faz o logout do admin da sessão
        unset($_SESSION['admin']);
        unset($_SESSION['admin_usuario']);

        // redirecionar para o início
        Store::redirect('inicio', true);
    }




    // ===========================================================
    // CLIENTES
    // ===========================================================
    public function lista_clientes()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // vai buscar a lista de clientes
        $ADMIN = new AdminModel();
        $clientes = $ADMIN->lista_clientes();
        $data = [
            'clientes' => $clientes
        ];

        // apresenta a página da lista de clientes
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/lista_clientes',
            'admin/layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function detalhe_cliente()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se existe um id_cliente na query string
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        }

        $id_cliente = Store::aesDesencriptar($_GET['c']);
        // verifica se o id_cliente é válido
        if (empty($id_cliente)) {
            Store::redirect('inicio', true);
            return;
        }

        // buscar os dados do cliente
        $ADMIN = new AdminModel();
        $data = [
            'dados_cliente' => $ADMIN->buscar_cliente($id_cliente),
            'total_encomendas' => $ADMIN->total_encomendas_cliente($id_cliente)
        ];

        // apresenta a página das encomendas
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/detalhe_cliente',
            'admin/layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function cliente_historico_encomendas()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se existe o id_cliente encriptado
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
        }

        // definir o id_cliente que vem encriptado
        $id_cliente = Store::aesDesencriptar($_GET['c']);
        $ADMIN = new AdminModel();

        $data = [
            'cliente' => $ADMIN->buscar_cliente($id_cliente),
            'lista_encomendas' => $ADMIN->buscar_encomendas_cliente($id_cliente)
        ];

        // apresenta a página das encomendas
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/lista_encomendas_cliente',
            'admin/layouts/footer',
        ], $data);
    }


    // ===========================================================
    // ENCOMENDAS
    // ===========================================================
    public function lista_encomendas()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // apresenta a lista de encomendas (usando filtro se for o caso)
        // verifica se existe um filtro da query string
        $filtros = [
            'pendente' => 'PENDENTE',
            'em_processamento' => 'EM PROCESSAMENTO',
            'cancelada' => 'CANCELADA',
            'usada' => 'USADA',
            'concluida' => 'CONCLUIDA',
        ];

        $filtro = '';
        if (isset($_GET['f'])) {

            // verifica se a variável é uma key dos filtros
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $filtros[$_GET['f']];
            }
        }

        // vai buscar o id cliente se existir na query string
        $id_cliente = null;
        if(isset($_GET['c'])){
            $id_cliente = Store::aesDesencriptar($_GET['c']);
        }

        // carregar a lista de encomendas
        $admin_model = new AdminModel();
        $lista_encomendas = $admin_model->lista_encomendas($filtro, $id_cliente);

        $data = [
            'lista_encomendas' => $lista_encomendas,
            'filtro' => $filtro
        ];

        // apresenta a página das encomendas
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/lista_encomendas',
            'admin/layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function detalhe_encomenda()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        //buscar o id_encomenda
        $id_encomenda = null;
        if (isset($_GET['e'])) {
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        //carregar os dados da encomenda selecionada
        $admin_model = new AdminModel();
        $encomenda = $admin_model->buscar_detalhes_encomenda($id_encomenda);

        //apresentar os dados por forma a poder ver os detalhes e alterar o seu status
        $data = $encomenda;
        Store::Layout_admin([
            'admin/layouts/header',
            'admin/encomenda_detalhe',
            'admin/layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function encomenda_alterar_estado()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        //buscar o id_encomenda
        $id_encomenda = null;
        if (isset($_GET['e'])) {
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        // buscar o novo estado
        $estado = null;
        if (isset($_GET['s'])) {
            $estado = $_GET['s'];
        }
        if (!in_array($estado, STATUS)) {
            Store::redirect('inicio', true);
            return;
        }

        // regras de negócio para gerir a encomenda (novo estado)

        // atualizar o estado da encomenda na base de dados
        $admin_model = new AdminModel();
        $admin_model->atualizar_status_encomenda($id_encomenda, $estado);

        // executar operações baseadas no novo estado
        switch ($estado) {
            case 'PENDENTE':
                // não existem ações
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;

            case 'EM PROCESSAMENTO':
                // não existem ações
                break;

            case 'USADA':
                // enviar um email com a notificação ao cliente sobre o envio da encomenda
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                $this->operacao_enviar_email_encomenda_usada($id_encomenda);

                break;

            case 'CANCELADA':
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;

            case 'CONCLUIDA':
                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);
                break;
        }

        // redireciona para a página da própria encomenda
        Store::redirect('detalhe_encomenda&e='.$_GET['e'], true);
    }


    // ===========================================================
    // OPERAÇÕES APÓS MUDANÇA DE ESTADO
    // ===========================================================
    
    public function operacao_notificar_cliente_mudanca_estado($id_encomenda)
    {
        // vai enviar um email para o cliente indicando que a encomenda sofreu alterações
    }

    // ===========================================================
    private function operacao_enviar_email_encomenda_usada($id_encomenda)
    {
        // executar as operações para enviar email ao cliente.
    }

    // ===========================================================
    public function criar_pdf_encomenda()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        //buscar o id_encomenda
        $id_encomenda = null;
        if (isset($_GET['e'])) {
            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        // vai buscar os dados da encomenda
        $id_encomenda = Store::aesDesencriptar($_GET['e']);
        $admin_model = new AdminModel();
        $encomenda = $admin_model->buscar_detalhes_encomenda($id_encomenda);
        
        // buscar dados do cliente
        // Store::printData($encomenda);

        // criar o PDF com os detalhes da encomenda

        $pdf = new PDF();
        $pdf->set_template(getcwd() . '/assets/templates_pdf/template.pdf');
        $pdf->apresentar_pdf();
        
    }
}
