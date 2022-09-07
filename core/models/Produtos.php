<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{

    //=============================================================
    public function lista_produtos_disponiveis(){
        
        // buscar as informações dos prodtudos a base de dados  
        $bd = new Database();

        $produtos = $bd->select("
        SELECT * FROM produtos
        WHERE visivel = 1
        ");
        return $produtos;
    }

    // ===========================================================
    public function verificar_stock_produto($n_bilhete){

        $bd = new Database();
        $parametros = [
            ':n_bilhete' => $n_bilhete
        ];
        $resultados = $bd->select("
            SELECT * FROM produtos 
            WHERE n_bilhete = :n_bilhete
            AND visivel = 1
            AND stock > 0
        ", $parametros);

        return count($resultados) != 0 ? true : false;
    }

    // ===========================================================
    public function buscar_produtos_por_ids($ids){

        $bd = new Database();
        return $bd->select("
            SELECT * FROM produtos
            WHERE n_bilhete IN ($ids)
        ");
    }    
}
