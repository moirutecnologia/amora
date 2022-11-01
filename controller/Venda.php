<?php

namespace controller;

class Venda extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Venda();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Venda();
        $dados = $model->listarGrafico($parametros);

        return $dados;
    }

    public function listarGraficoGanhos($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));
        $parametros['data_ate'] = $parametros['data_ate'] ?? date('Y-m-d');

        $model = new \model\Venda();
        $dados = $model->listarGraficoGanhos($parametros);

        return $dados;
    }

    public function carregarProdutosVenda($parametros)
    {
        include '../view/painel/includes/produtos-tabela-venda.php';
    }

    public function salvar($parametros)
    {
        global $_usuario;
        $modalentrega = '';

        $model = new \model\Venda();
        $model->usuario_id = $_usuario->id;
        $model->id = $parametros['id'];
        $model->cliente_id = $parametros['cliente_id'];
        $model->data = $parametros['data'];
        $model->comissao = $parametros['comissao'];
        
        $model->salvar();

        foreach ($parametros['produtos'] as $produto) {
            $vendaproduto = new \model\VendaProduto();
            $vendaproduto->venda_id = $model->id;
            $vendaproduto->produto_id = $produto['produto_id'];
            $vendaproduto->preco = $produto['preco'];
            $vendaproduto->quantidade = $produto['quantidade'];

            $vendaproduto->salvar();

            if ($produto['entregue']) {
                if (empty($modalentrega)) {
                    $modalentrega = new \model\Entrega();
                    $modalentrega->salvar();
                }

                $vendaorodutoentrega = new \model\VendaProdutoEntrega();
                $vendaorodutoentrega->entrega_id = $modalentrega->id;
                $vendaorodutoentrega->vendaproduto_id = $vendaproduto->id;

                $vendaorodutoentrega->salvar();

                if (!empty($produto['produtosku_id'])) {
                    $produtoskuentrega = new \model\ProdutoSKUEntrega();
                    $produtoskuentrega->entrega_id = $modalentrega->id;
                    $produtoskuentrega->produtosku_id = $produto['produtosku_id'];
                    $produtoskuentrega->quantidade = $produto['quantidade'];

                    $produtoskuentrega->salvar();

                    $modelProdutosku = new \model\ProdutoSKU();

                    $modelProdutosku->id = $produto['produtosku_id'];
                    $produtosku = $modelProdutosku->obter();

                    $modelProdutosku->atualizarCampo('quantidade', $produtosku->quantidade - $produto['quantidade']);
                } else {
                    $modelProduto = new \model\Produto();
                    $modelProduto->id = $produto['produto_id'];

                    $produtoQuantidade = $modelProduto->obter();

                    $quantidade = $produtoQuantidade->quantidade - $produto['quantidade'];
                    $quantidade = $quantidade >= 0 ? $quantidade : 0;

                    $modelProduto->atualizarCampo('quantidade', $quantidade);
                }
            }
        }

        return array('resultado' => '1', 'mensagem' => 'Venda salva com sucesso', 'id' => $model->id);
    }

}
