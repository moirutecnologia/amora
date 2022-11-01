<?php

namespace model;

class Entrega extends _BaseModel
{
    public $id;

    public function __construct()
    {
        $this->tabela = 'entregas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $parametros["aguardando_entrega"] ??= '';
        $parametros["entrege"] ??= '';
        $parametros["marca_id"] ??= '';
        $parametros["cliente_id"] ??= '';
        $parametros["pagina"] ??= '';

        $parametros["entregue_de"] = $parametros["entregue_de"] ?? '1900-01-01' ; 
        $parametros["entregue_ate"] = ($parametros["entregue_ate"] ?? '6000-01-01') . ' 23:59:59'; 

        $sql = "SELECT 
                    vpe.entrega_id,
                    e.criado_em AS data_entrega,
                    vp.id AS vendaproduto_id,
                    m.nome AS marca, 
                    c.id AS cliente_id, 
                    c.nome AS cliente, 
                    CONCAT(m.nome , ' - ', p.nome) AS produto, 
                    vp.quantidade, 
                    vp.preco,
                    p.id AS produto_id 
                FROM vendas_produtos AS vp
                LEFT JOIN vendas_produtos_entregas AS vpe
                    ON vp.id = vpe.vendaproduto_id
                LEFT JOIN entregas AS e
                    ON vpe.entrega_id = e.id
                INNER JOIN produtos AS p
                    ON vp.produto_id = p.id
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes AS c
                    ON v.cliente_id = c.id
                WHERE
                    v.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["aguardando_entrega"]}' = '' OR vpe.id IS NULL)
                    AND ('{$parametros["entrege"]}' = '' OR vpe.id IS NOT NULL)
                    AND ('{$parametros["entregue_de"]}' = '1900-01-01' OR e.criado_em >= '{$parametros["entregue_de"]}')
                    AND ('{$parametros["entregue_ate"]}' = '6000-01-01 23:59:59' OR e.criado_em <= '{$parametros["entregue_ate"]}')
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                    AND ('{$parametros["cliente_id"]}' = '' OR v.cliente_id = '{$parametros["cliente_id"]}')
                ORDER BY
                    {$parametros['ordem']}";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
