<?php

namespace model;

class Estado extends _BaseModel
{
    public $id;
    public $nome;
    
    public function __construct()
    {
        $this->tabela = 'estados';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    e.id,
                    e.nome,
                    e.uf
                FROM estados AS e";

        return $this->obterLista($sql);
    }
}