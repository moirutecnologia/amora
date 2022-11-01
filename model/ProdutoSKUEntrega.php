<?php

namespace model;

class ProdutoSKUEntrega extends _BaseModel
{
    public $id;
    public $entrega_id;
    public $produtosku_id;
    public $quantidade;

    public function __construct()
    {
        $this->tabela = 'produtosskus_entregas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    pm.id
                FROM produtosskus_entregas AS pm
                WHERE
                    ('{$parametros["busca"]}' = '' OR pm.id LIKE '%{$parametros["busca"]}%')
                ORDER BY pm.id";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
