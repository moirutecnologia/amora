<?php

namespace model;

class Produto extends _BaseModel
{
    public $id;
    public $usuario_id;
    public $nome;
    public $preco;
    public $marca_id;
    public $quantidade;

    public function __construct()
    {
        $this->tabela = 'produtos';
        parent::__construct();
    }

    public function listar($parametros)
    {
        global $_usuario;

        $sql = "SELECT
                    p.id,
                    CONCAT(m.nome , ' - ', p.nome) AS nome,
                    p.preco,
                    p.quantidade + estoque.quantidade AS quantidade
                FROM produtos AS p
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                LEFT JOIN (
                    SELECT
                        sps.produto_id,
                        SUM(IFNULL(quantidade,0)) AS quantidade
                    FROM produtosskus AS sps
                    GROUP BY sps.produto_id
                ) AS estoque
                    on p.id = estoque.produto_id
                WHERE
                    p.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["busca"]}' = '' OR p.nome LIKE '%{$parametros["busca"]}%')
                ORDER BY p.nome";

        return $this->obterLista($sql, $parametros['pagina']);
    }

    public function listarVendaSemEstoque($parametros)
    {
        global $_usuario;

        $sql = "SELECT 
                    vp.produto_id,
                    m.nome AS marca,  
                    p.nome AS produto,
                    SUM(vp.quantidade) - IFNULL(ps.quantidade, 0) AS quantidade,
                    vp.preco * (SUM(vp.quantidade) - IFNULL(ps.quantidade, 0)) AS total
                FROM vendas_produtos AS vp
                INNER JOIN produtos AS p
                    ON vp.produto_id = p.id
                LEFT JOIN produtosskus ps
                    ON p.id = ps.produto_id
                INNER JOIN marcas AS m
                    ON p.marca_id = m.id
                INNER JOIN vendas AS v
                    ON vp.venda_id = v.id
                LEFT JOIN vendas_produtos_entregas AS vpe
                    ON vp.id = vpe.vendaproduto_id
                WHERE
                    vpe.vendaproduto_id IS NULL
                    AND p.usuario_id = '{$_usuario->id}'
                    AND ('{$parametros["marca_id"]}' = '' OR m.id = '{$parametros["marca_id"]}')
                GROUP BY
                    produto_id,
                    marca,
                    produto
                HAVING
                    quantidade > 0
                ORDER BY
                    marca,
                    produto";

        return $this->obterLista($sql, $parametros['pagina']);
    }
}
