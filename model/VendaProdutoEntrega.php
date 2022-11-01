<?php

namespace model;

class VendaProdutoEntrega extends _BaseModel
{
    public $id;
    public $entrega_id;
    public $vendaproduto_id;

    public function __construct()
    {
        $this->tabela = 'vendas_produtos_entregas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    vpe.id
                FROM vendas_produtos_entregas AS vpe
                WHERE
                    ('{$parametros["busca"]}' = '' OR vpe.id LIKE '%{$parametros["busca"]}%')
                ORDER BY vpe.id";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
