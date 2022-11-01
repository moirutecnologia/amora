<?php

namespace model;

class Cidade extends _BaseModel
{
    public $id;
    public $nome;
    public $estado_id;
    
    public function __construct()
    {
        $this->tabela = 'cidades';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    c.id,
                    c.nome,
                    e.uf
                FROM cidades AS c
                INNER JOIN estados AS e
                    ON c.estado_id = e.id
                WHERE
                ('{$parametros['estado_id']}' = '' OR c.estado_id = '{$parametros['estado_id']}')
                AND (
                    '{$parametros['com_anuncio']}' = '' 
                    OR
                    (
                            SELECT COUNT(1)
                            FROM itens AS si
                            INNER JOIN clientes AS sc
                            ON si.cliente_id = sc.id
                            WHERE
                            sc.cidade_id = c.id
                            AND IFNULL((SELECT SUM(IFNULL(confirmada, 0)) FROM propostas AS sp WHERE sp.item_id = si.id),0) = 0
                            GROUP BY sc.cidade_id
                    )
                        
                )
                ORDER BY c.nome";

        return $this->obterLista($sql);
    }
}