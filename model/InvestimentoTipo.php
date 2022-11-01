<?php

namespace model;

class InvestimentoTipo extends _BaseModel
{
    public $id;
    public $nome;
    public $usuario_id;

    public function __construct()
    {
        $this->tabela = 'investimentostipos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    it.id,
                    it.nome
                FROM investimentostipos AS it
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR it.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY it.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
