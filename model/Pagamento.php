<?php

namespace model;

class Pagamento extends _BaseModel
{
    public $id;
    public $cliente_id;
    public $valor;
    public $metodopagamento_id;
    public $data;

    public function __construct()
    {
        $this->tabela = 'clientespagamentos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    cp.id,
                    cp.data,
                    cp.valor,
                    c.nome AS cliente,
                    c.id AS cliente_id,
                    mp.nome AS metodopagamento
                FROM clientespagamentos AS cp
                INNER JOIN clientes AS c
                    ON cp.cliente_id = c.id
                LEFT JOIN metodospagamentos AS mp
                    ON cp.metodopagamento_id = mp.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR c.nome LIKE '%{$parametros["busca"]}%')
                    AND ('{$parametros["metodopagamento_id"]}' = '' OR cp.metodopagamento_id = '{$parametros["metodopagamento_id"]}')
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                ORDER BY cp.data DESC";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT 
                    DATE_FORMAT(cp.data, '%m/%Y') AS rotulo,
                    SUM(cp.valor) AS total
                FROM clientespagamentos AS cp
                INNER JOIN clientes c
                    ON cp.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                GROUP BY
                    rotulo,
                    DATE_FORMAT(cp.data, '%Y%m')
                ORDER BY
                    DATE_FORMAT(cp.data, '%Y%m')";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarSaldo($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    c.id,
                    c.nome,
                    IFNULL(SUM(p.valor), 0) - IFNULL(SUM(d.valor), 0) AS saldo
                FROM clientes AS c
                LEFT JOIN
                (
                    SELECT 
                        sc.id,
                        SUM(scp.valor) AS valor
                    FROM clientes AS sc
                    LEFT JOIN clientespagamentos AS scp
                        ON sc.id = scp.cliente_id
                    WHERE
                        sc.usuario_id = '{$_usuario->id}'
                    GROUP BY
                        sc.id
                ) AS p
                ON c.id = p.id
                LEFT JOIN
                (
                    SELECT 
                        sc.id,
                        SUM(svp.preco * svp.quantidade) AS valor
                    FROM clientes AS sc
                    INNER JOIN vendas AS sv
                        ON sc.id = sv.cliente_id
                    INNER JOIN vendas_produtos AS svp
                        ON sv.id = svp.venda_id
                    INNER JOIN vendas_produtos_entregas AS svpe
                        ON svp.id = svpe.vendaproduto_id
                    WHERE
                        sc.usuario_id = '{$_usuario->id}'
                    GROUP BY
                        sc.id
                ) AS d
                    ON c.id = d.id
                WHERE
                    ('{$parametros["busca"]}' = '' OR c.nome LIKE '%{$parametros["busca"]}%')
                GROUP BY
                    id
                HAVING IFNULL(SUM(p.valor), 0) - IFNULL(SUM(d.valor), 0) <> 0
                ORDER BY 
                    c.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
