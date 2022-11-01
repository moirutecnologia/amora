<?php

namespace model;

class Perfil extends _BaseModel
{
    public $id;
    public $nome;
    public $permissoes;

    public function __construct()
    {
        $this->tabela = 'perfis';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    p.id,
                    p.nome
                FROM perfis AS p
                WHERE
                    ('{$parametros["busca"]}' = '' OR p.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY p.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
