<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class AdminModel
{

    // ===========================================================
    public function validar_login($usuario_admin, $senha)
    {

        // verificar se o login é válido
        $parametros = [
            ':usuario_admin' => $usuario_admin
        ];

        $bd = new Database();
        $resultados = $bd->select("
            SELECT * FROM admins 
            WHERE usuario = :usuario_admin 
            AND deleted_at IS NULL
        ", $parametros);

        if (count($resultados) != 1) {
            // não existe usuário admin
            return false;
        } else {

            // temos usuário admin. Vamos ver a sua password
            $usuario_admin = $resultados[0];

            // verificar a password
            if (!password_verify($senha, $usuario_admin->senha)) {

                // password inválida
                return false;
            } else {

                // login válido
                return $usuario_admin;
            }
        }
    }

    // ===========================================================
    // CLIENTES
    // ===========================================================
    public function lista_clientes()
    {
        // vai buscar todos os clientes registados na base de dados
        $bd = new Database();
        $resultados = $bd->select("
            SELECT 
                clientes.id_cliente,
                clientes.nome_completo,
                clientes.email,
                clientes.telefone,  
                clientes.ativo,
                clientes.deleted_at,
            COUNT(encomendas.id_encomenda) total_encomendas
            FROM clientes LEFT JOIN encomendas
            ON clientes.id_cliente = encomendas.id_cliente
            GROUP BY clientes.id_cliente
        ");
        return $resultados;
    }

    // ===========================================================
    public function buscar_cliente($id_cliente)
    {
        $parametros = [
            'id_cliente' => $id_cliente
        ];

        $bd = new Database();
        $resultados = $bd->select("
                SELECT 
                    *
                FROM clientes 
                WHERE id_cliente = :id_cliente
            ", $parametros);
        return $resultados[0];
    }

    // ===========================================================
    public function total_encomendas_cliente($id_cliente)
    {
        $parametros = [
            'id_cliente' => $id_cliente
        ];
        $bd = new Database();
        return $bd->select("
            SELECT COUNT(*) total 
            FROM encomendas 
            WHERE id_cliente = :id_cliente
        ", $parametros)[0]->total;
    }

    // ===========================================================
    public function buscar_encomendas_cliente($id_cliente)
    {
        // buscar todas as encomendas do cliente indicado
        $parametros = [
            ':id_cliente' => $id_cliente
        ];
        $bd = new Database();
        return $bd->select("
            SELECT * FROM encomendas WHERE id_cliente = :id_cliente
        ", $parametros);
    }



    // ===========================================================
    // ENCOMENDAS
    // ===========================================================
    public function total_encomendas_pendentes()
    {

        // vai buscar a quantidade de encomendas pendentes
        $bd = new Database();
        $resultados = $bd->select("
            SELECT COUNT(*) total FROM encomendas
            WHERE status = 'PENDENTE'
        ");
        return $resultados[0]->total;
    }

    // ===========================================================
    public function total_encomendas_em_processamento()
    {

        // vai buscar a quantidade de encomendas em processamento
        $bd = new Database();
        $resultados = $bd->select("
            SELECT COUNT(*) total FROM encomendas
            WHERE status = 'Em PROCESSAMENTO'
        ");
        return $resultados[0]->total;
    }

    // ===========================================================
    public function lista_encomendas($filtro, $id_cliente)
    {
        $bd = new Database();
        $sql = "SELECT e.*, c.nome_completo FROM encomendas e LEFT JOIN clientes c ON e.id_cliente = c.id_cliente WHERE 1";
        if ($filtro != '') {
            $sql .= " AND e.status = '$filtro'";
        }
        if(!empty($id_cliente)){
            $sql .= " AND e.id_cliente = $id_cliente";
        }
        $sql .= " ORDER BY e.id_encomenda DESC";
        return $bd->select($sql);
    }

    // ===========================================================
    public function buscar_detalhes_encomenda($id_encomenda)
    {
        // vai buscar os detalhes de uma encomenda
        $bd = new Database();

        $parametros = [
            ':id_encomenda' => $id_encomenda
        ];

        // buscar os dados da encomenda
        $dados_encomenda = $bd->select("
            SELECT clientes.nome_completo, encomendas.* 
            FROM clientes, encomendas 
            WHERE encomendas.id_encomenda = :id_encomenda
            AND clientes.id_cliente = encomendas.id_cliente
            ", $parametros);

        // lista de produtos da encomenda
        $lista_produtos = $bd->select("
            SELECT * 
            FROM encomenda_produto 
            WHERE id_encomenda = :id_encomenda", $parametros);
            
        return [
            'encomenda' => $dados_encomenda[0],
            'lista_produtos' => $lista_produtos
        ];

    }

    // ===========================================================
    public function atualizar_status_encomenda($id_encomenda, $estado)
    {
        // atualizar o estado da encomenda
        $bd = new Database();

        $parametros = [
            ':id_encomenda' => $id_encomenda,
            ':status' => $estado
        ];

        $bd->update("
            UPDATE encomendas
            SET
                status = :status,
                updated_at = NOW()
            WHERE id_encomenda = :id_encomenda
        ", $parametros);
    }
}
