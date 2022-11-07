<?php

namespace model;

class Investimento extends _BaseModel
{
    public $id;
    public $investimentotipo_id;
    public $valor;
    public $data;

    public function __construct()
    {
        $this->tabela = 'investimentos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    i.id,
                    i.data,
                    i.valor,
                    it.nome AS investimento
                FROM investimentos AS i
                INNER JOIN investimentostipos AS it
                    ON i.investimentotipo_id = it.id
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["investimentotipo_id"]}' = '' OR it.id = '{$parametros["investimentotipo_id"]}')
                ORDER BY i.data DESC, i.id DESC";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT 
                    DATE_FORMAT(i.data, '%m/%Y') AS rotulo,
                    SUM(i.valor) AS total
                FROM investimentos AS i
                INNER JOIN investimentostipos AS it
                    ON i.investimentotipo_id = it.id
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                GROUP BY
                    rotulo,
                    DATE_FORMAT(i.data, '%Y%m')
                ORDER BY
                    DATE_FORMAT(i.data, '%Y%m')";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    it.nome,
                    SUM(i.valor) AS total
                FROM investimentos AS i
                INNER JOIN investimentostipos AS it
                    ON i.investimentotipo_id = it.id
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["investimentotipo_id"]}' = '' OR it.id = '{$parametros["investimentotipo_id"]}')
                GROUP BY it.nome
                ORDER BY it.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    it.nome,
                    DATE_FORMAT(i.data, '%Y%m') AS mes,
                    SUM(i.valor) AS total
                FROM investimentos AS i
                INNER JOIN investimentostipos AS it
                    ON i.investimentotipo_id = it.id
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["investimentotipo_id"]}' = '' OR it.id = '{$parametros["investimentotipo_id"]}')
                GROUP BY
                    it.nome,
                    DATE_FORMAT(i.data, '%Y%m')
                ORDER BY it.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarRelatorioMesDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    it.nome,
                    i.data,
                    DATE_FORMAT(i.data, '%Y%m') AS mes,
                    i.valor
                FROM investimentos AS i
                INNER JOIN investimentostipos AS it
                    ON i.investimentotipo_id = it.id
                WHERE
                    it.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                    AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                    AND ('{$parametros["investimentotipo_id"]}' = '' OR it.id = '{$parametros["investimentotipo_id"]}')
                ORDER BY
                    it.nome,
                    i.data";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
