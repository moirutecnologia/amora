<?php

namespace model;

class VendaProduto extends _BaseModel
{
    public $id;
    public $venda_id;
    public $produto_id;
    public $preco;
    public $quantidade;

    public function __construct()
    {
        $this->tabela = 'vendas_produtos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    vp.id
                FROM vendas_produtos AS vp
                WHERE
                    ('{$parametros["busca"]}' = '' OR vp.id LIKE '%{$parametros["busca"]}%')
                ORDER BY vp.id";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
