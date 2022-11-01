<?php

namespace model;

class Cliente extends _BaseModel
{
    public $id;
    public $usuario_id;
    public $nome;
    public $email;
    public $whatsapp;
    public $endereco;

    public function __construct()
    {
        $this->tabela = 'clientes';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    c.id,
                    c.nome,
                    c.email,
                    c.whatsapp,
                    c.criado_em
                FROM clientes AS c
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR c.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY c.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    c.nome,
                    SUM(vp.preco * vp.quantidade) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes as c
                    ON v.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                GROUP BY c.nome
                ORDER BY c.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    c.nome,
                    DATE_FORMAT(v.data, '%Y%m') AS mes,
                    SUM(vp.preco * vp.quantidade) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes as c
                    ON v.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                GROUP BY
                    c.nome,
                    DATE_FORMAT(v.data, '%Y%m')
                ORDER BY c.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMelhores($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    c.nome,
                    DATE_FORMAT(v.data, '%Y%m') AS mes,
                    SUM(vp.preco * vp.quantidade) AS total,
                    COUNT(DISTINCT v.id) AS compras,
                    SUM(vp.preco * vp.quantidade) / COUNT(DISTINCT v.id) AS media,
                    COUNT(DISTINCT vp.produto_id) AS produtos
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes as c
                    ON v.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                GROUP BY
                    c.nome
                ORDER BY 3 DESC, 5 DESC, 6 DESC";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioIntervaloCompra($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    c.nome,
                    (SELECT COUNT(*) FROM vendas AS sv WHERE vt.cliente_id = sv.cliente_id) totalcompras,
                    MIN(DATEDIFF(proxima_data, data_venda)) minimodias,
                    AVG(DATEDIFF(proxima_data, data_venda)) mediadias,
                    MAX(DATEDIFF(proxima_data, data_venda)) maximodias
                FROM (
                    SELECT
                        cliente_id,
                        v.data data_venda,
                        (SELECT
                            data
                            FROM vendas AS sv
                            WHERE 
                            sv.data > v.data
                            AND v.cliente_id = sv.cliente_id
                            LIMIT 1
                        ) AS proxima_data
                    FROM vendas AS v
                    WHERE 
                        v.usuario_id = '{$_usuario->id}'
                        AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                        AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                        AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                ) AS vt
                INNER JOIN clientes AS c
                    ON vt.cliente_id = c.id
                WHERE
                    vt.proxima_data is NOT NULL
                GROUP BY
                    vt.cliente_id
                ORDER BY
                    2 DESC,
                    4";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioIntervaloCompraProduto($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    c.nome AS cliente,
                    CONCAT(m.nome , ' - ', p.nome) AS produto,
                    AVG(DATEDIFF(ultima, anterior)) AS media,
                    DATEDIFF(now(), MAX(ultima)) AS ultima,
                    AVG(DATEDIFF(ultima, anterior)) - DATEDIFF(now(), MAX(ultima)) AS ordem
                FROM
                (
                    SELECT
                        v.cliente_id,
                        (
                            SELECT
                                MAX(sv.data)
                            FROM vendas_produtos AS svp
                            INNER JOIN vendas AS sv
                                ON svp.venda_id = sv.id
                            WHERE
                                svp.produto_id = vp.produto_id
                                AND sv.cliente_id = v.cliente_id
                                AND sv.data < v.data
                            GROUP BY svp.produto_id
                        ) AS anterior,
                        v.data AS ultima,
                        vp.produto_id
                    FROM vendas_produtos AS vp
                    INNER JOIN vendas AS v
                        ON vp.venda_id = v.id
                    WHERE
                        v.usuario_id = '{$_usuario->id}'
                        AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                        AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                        AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                    ORDER BY v.data
                ) d
                INNER JOIN clientes AS c
                    ON d.cliente_id = c.id
                INNER JOIN produtos AS p
                    ON d.produto_id = p.id
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                WHERE d.anterior IS NOT NULL
                GROUP BY
                    cliente_id,
                    produto_id
                ORDER BY 
                    1,
                    5";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioProdutosComprados($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    v.data,
                    c.nome AS cliente,
                    vp.preco,
                    vp.quantidade,
                    CONCAT(m.nome , ' - ', p.nome) AS produto
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN produtos AS p
                    ON vp.produto_id = p.id
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                INNER JOIN clientes as c
                    ON v.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                ORDER BY v.data DESC";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioExtrato($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    v.data,
                    c.nome AS cliente,
                    (vp.preco * vp.quantidade) * -1 AS valor,
                    CONCAT(m.nome , ' - ', p.nome) AS descricao
                FROM vendas_produtos AS vp
                INNER JOIN vendas_produtos_entregas AS vpe
                    ON vp.id = vpe.vendaproduto_id
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN produtos AS p
                    ON vp.produto_id = p.id
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                INNER JOIN clientes as c
                    ON v.cliente_id = c.id
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR v.cliente_id = '{$parametros['cliente_id']}')
                
                UNION
                
                SELECT 
                    cp.data,
                    c.nome AS cliente,
                    cp.valor AS valor,
                    CONCAT('Pagamento', IF(mp.nome IS NOT NULL, CONCAT(' (', mp.nome, ')'), '')) AS descricao
                FROM clientespagamentos AS cp
                INNER JOIN clientes AS c
                    ON cp.cliente_id = c.id
                LEFT JOIN metodospagamentos AS mp
                    ON cp.metodopagamento_id = mp.id 
                WHERE
                    c.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros['cliente_id']}' = '' OR cp.cliente_id = '{$parametros['cliente_id']}')
                ORDER BY
                cliente,
                data 
                ";

        return $this->obterLista($sql);
    }
}
