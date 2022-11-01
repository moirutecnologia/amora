<?php

namespace model;

class Usuario extends _BaseModel
{
    public $id;
    public $nome;
    public $email;
    public $whatsapp;
    public $senha;
    public $perfil_ids;
    public $assinante;

    public function __construct()
    {
        $this->tabela = 'usuarios';
        parent::__construct();
    }

    public function listar($parametros)
    {
        $sql = "SELECT
                    u.id,
                    u.nome,
                    u.email
                FROM usuarios AS u
                WHERE
                    ('{$parametros["busca"]}' = '' OR u.nome LIKE '%{$parametros["busca"]}%')
                    AND ('{$parametros["perfil_id"]}' = '' OR JSON_SEARCH(u.perfil_ids, 'one', '{$parametros['perfil_id']}') is not null)
                ORDER BY u.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function contadores($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?: '1900-01-01';
        $parametros['data_ate'] = $parametros['data_ate'] ?: '6000-01-01 23:59:59';

        $sql = "SELECT
                    (
                        SELECT COUNT(distinct cliente_id) FROM vendas AS v
                        WHERE
                            usuario_id = '{$_usuario->id}'
                            AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                            AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    ) AS clientes,
                    (
                        SELECT SUM(vp.preco * vp.quantidade) 
                        FROM vendas_produtos AS vp 
                        INNER JOIN vendas AS v
                            ON vp.venda_id = v.id 
                        WHERE
                            v.usuario_id = '{$_usuario->id}'
                            AND ('{$parametros['data_de']}' = '1900-01-01' OR v.data >= '{$parametros['data_de']}')
                            AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR v.data <= '{$parametros['data_ate']}')
                    ) AS vendas,
                    (
                        SELECT SUM(valor)
                        FROM investimentos AS i
                        INNER JOIN investimentostipos AS it
                            ON i.investimentotipo_id = it.id 
                        WHERE
                            it.usuario_id = '{$_usuario->id}'
                            AND ('{$parametros['data_de']}' = '1900-01-01' OR i.data >= '{$parametros['data_de']}')
                            AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR i.data <= '{$parametros['data_ate']}')
                    ) AS investimento,
                    (
                        SELECT SUM(valor)
                        FROM clientespagamentos AS cp
                        INNER JOIN clientes AS c 
                            ON cp.cliente_id = c.id
                        WHERE
                            c.usuario_id = '{$_usuario->id}'
                            AND ('{$parametros['data_de']}' = '1900-01-01' OR cp.data >= '{$parametros['data_de']}')
                            AND ('{$parametros['data_ate']}' = '6000-01-01 23:59:59' OR cp.data <= '{$parametros['data_ate']}')
                    ) AS recebido
                    ";

        return $this->obterRegistro($sql);
    }

    public function obterPorToken($token)
    {
        $sql = "SELECT 
                    u.*,
                    (SELECT JSON_EXTRACT(JSON_ARRAYAGG(sp.permissoes), '$[*][*]')
                    FROM perfis AS sp
                    WHERE JSON_SEARCH(u.perfil_ids, 'one', sp.id) is not null) AS permissoes
                FROM usuarios AS u
                INNER JOIN tokens AS t
                    ON u.id = t.usuario_id
                WHERE 
                    token = '$token'";

        return $this->obterRegistro($sql);
    }

    public function sair($token)
    {
        $sql = "DELETE FROM tokens WHERE token = '$token'";

        $this->executar($sql);
    }
}
