<?php

namespace model;

class MetodoPagamento extends _BaseModel
{
    public $id;
    public $nome;
    public $usuario_id;

    public function __construct()
    {
        $this->tabela = 'metodospagamentos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    mp.id,
                    mp.nome
                FROM metodospagamentos AS mp
                WHERE
                    mp.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR mp.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY mp.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    mp.nome,
                    SUM(cp.valor) AS total
                FROM metodospagamentos AS mp
                INNER JOIN clientespagamentos AS cp
                    ON mp.id = cp.metodopagamento_id
                WHERE
                    mp.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["metodopagamento_id"]}' = '' OR mp.id = '{$parametros["metodopagamento_id"]}')
                GROUP BY mp.nome
                ORDER BY mp.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    mp.nome,
                    DATE_FORMAT(cp.data, '%Y%m') AS mes,
                    SUM(cp.valor) AS total
                FROM metodospagamentos AS mp
                INNER JOIN clientespagamentos AS cp
                    ON mp.id = cp.metodopagamento_id
                WHERE
                    mp.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["metodopagamento_id"]}' = '' OR mp.id = '{$parametros["metodopagamento_id"]}')
                GROUP BY
                    mp.nome,
                    DATE_FORMAT(cp.data, '%Y%m')
                ORDER BY mp.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMesDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    mp.nome,
                    c.nome AS cliente,
                    cp.data,
                    DATE_FORMAT(cp.data, '%Y%m') AS mes,
                    cp.valor
                FROM metodospagamentos AS mp
                INNER JOIN clientespagamentos AS cp
                    ON mp.id = cp.metodopagamento_id
                INNER JOIN clientes AS c
                    ON cp.cliente_id = c.id
                WHERE
                    mp.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["metodopagamento_id"]}' = '' OR mp.id = '{$parametros["metodopagamento_id"]}')
                ORDER BY mp.nome, DATE_FORMAT(cp.data, '%Y%m')";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
