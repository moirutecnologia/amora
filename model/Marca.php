<?php

namespace model;

class Marca extends _BaseModel
{
    public $id;
    public $nome;
    public $usuario_id;
    public $comissao;
    public $enviar_whatsapp;

    public function __construct()
    {
        $this->tabela = 'marcas';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $parametros['busca'] ??= '';
        $parametros['pagina'] ??= '';

        $sql = "SELECT
                    m.id,
                    m.nome,
                    m.comissao
                FROM marcas AS m
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR m.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY m.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    m.nome,
                    SUM(vp.preco * vp.quantidade) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN produtos as p
                    ON vp.produto_id = p.id
                INNER JOIN marcas as m
                    on p.marca_id = m.id
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                GROUP BY m.nome
                ORDER BY m.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    m.nome,
                    DATE_FORMAT(v.data, '%Y%m') AS mes,
                    SUM(vp.preco * vp.quantidade) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN produtos as p
                    ON vp.produto_id = p.id
                INNER JOIN marcas as m
                    on p.marca_id = m.id
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                GROUP BY
                    m.nome,
                    mes
                ORDER BY
                    m.nome,
                    mes";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    v.data,
                    m.nome AS marca,
                    p.nome AS produto,
                    c.nome AS cliente,
                    vp.preco,
                    vp.quantidade,
                    vp.preco * vp.quantidade AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes AS c
                    ON v.cliente_id = c.id
                INNER JOIN produtos as p
                    ON vp.produto_id = p.id
                INNER JOIN marcas as m
                    on p.marca_id = m.id
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                ORDER BY
                    v.data";

        $retorno = $this->obterLista($sql, $parametros['pagina']);

        $sql = "SELECT
                    SUM(vp.preco * vp.quantidade) AS total
                FROM vendas_produtos AS vp
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                INNER JOIN clientes AS c
                    ON v.cliente_id = c.id
                INNER JOIN produtos as p
                    ON vp.produto_id = p.id
                INNER JOIN marcas as m
                    on p.marca_id = m.id
                WHERE
                    m.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                ORDER BY
                    v.data";

        $retorno->total = $this->obterRegistro($sql)->total;

        return $retorno;
    }
}
