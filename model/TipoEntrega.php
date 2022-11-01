<?php

namespace model;

class TipoEntrega extends _BaseModel
{
    public $id;
    public $nome;

    public function __construct()
    {
        $this->tabela = 'tiposentregas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    te.id,
                    te.nome
                FROM tiposentregas AS te";

        return $this->obterLista($sql);
    }
}
