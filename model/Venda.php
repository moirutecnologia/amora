<?php

namespace model;

class Venda extends _BaseModel
{
    public $id;
    public $usuario_id;
    public $cliente_id;
    public $data;
    public $comissao;

    public function __construct()
    {
        $this->tabela = 'vendas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    m.id
                FROM vendas AS v
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                ORDER BY m.id";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT 
                    DATE_FORMAT(v.data, '%m/%Y') AS rotulo,
                    SUM(vp.quantidade * vp.preco) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                WHERE
                    v.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                GROUP BY
                    rotulo
                ORDER BY
                    DATE_FORMAT(v.data, '%Y%m')";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarGraficoGanhos($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    DATE_FORMAT(CREATEDAT, '%m/%Y') AS rotulo,
                    SUM(total) AS total
                FROM
                (
                    SELECT 
                        i.data AS CREATEDAT,
                        it.nome,
                        i.valor * -1 AS total
                    FROM investimentos AS i
                    INNER JOIN investimentostipos AS it
                        ON i.investimentotipo_id = it.id
                    WHERE
                        it.usuario_id = '{$_usuario->id}'
                        AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                        AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                    UNION
                    SELECT 
                        cp.data AS CREATEDAT,
                        c.nome AS NAME,
                        cp.valor AS TOTAL
                    FROM clientespagamentos AS cp
                    INNER JOIN clientes c
                        ON cp.cliente_id = c.id
                    WHERE
                        c.usuario_id = '{$_usuario->id}'
                        AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                        AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                ) AS GAIN
                GROUP BY
                    rotulo
                ORDER BY
                    DATE_FORMAT(CREATEDAT, '%Y%m')";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
