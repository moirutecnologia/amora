<?php

namespace model;

class ProdutoSKU extends _BaseModel
{
    public $id;
    public $produto_id;
    public $preco;
    public $quantidade;

    public function __construct()
    {
        $this->tabela = 'produtosskus';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    ps.id,
                    ps.preco,
                    ps.quantidade
                FROM produtosskus AS ps
                WHERE
                    ('{$parametros["produto_id"]}' = '' OR ps.produto_id = '{$parametros["produto_id"]}')
                    AND ('{$parametros["em_estoque"]}' = '' OR ps.quantidade > 0)
                ORDER BY ps.preco";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
