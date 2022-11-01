<?php

namespace controller;

class Entrega extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Entrega();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function carregarTabela($parametros)
    {
        include '../view/painel/includes/aguardandoentrega-tabela.php';
    }

    public function carregarTabelaEntregas($parametros)
    {
        include '../view/painel/includes/entregas-tabela.php';
    }

    public function criar($parametros)
    {
        foreach ($parametros['produtos'] as $produto) {

            $vendaproduto = new \model\VendaProduto();
            $vendaproduto = $vendaproduto->obterPor('id', $produto['vendaproduto_id']);

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

        return array('resultado' => '1', 'mensagem' => 'Entrega salva com sucesso');
    }

    public function devolver($parametros)
    {
        $modelVendaproduto = new \model\VendaProduto();
        $vendaproduto = $modelVendaproduto->obterPor('id', $parametros['vendaproduto_id']);

        $modelVendasProdutosEntregas = new \model\VendaProdutoEntrega();
        $vendaProdutosEntrega = $modelVendasProdutosEntregas->obterPor('vendaproduto_id', $vendaproduto->id);

        $modelVendaproduto->excluirPor('id', $vendaproduto->id);
        $modelVendasProdutosEntregas->excluirPor('vendaproduto_id', $vendaproduto->id);

        $produtosVenda = $modelVendaproduto->buscarPor('venda_id', $vendaproduto->venda_id);

        if (count($produtosVenda) == 0) {
            $modelVenda = new \model\Venda();
            $modelVenda->excluirPor('id', $vendaproduto->venda_id);
        }

        $produtosVendaEntregas = $modelVendasProdutosEntregas->buscarPor('entrega_id', $vendaProdutosEntrega->entrega_id);

        if (count($produtosVendaEntregas) == 0) {
            $modelEntrega = new \model\Entrega();
            $modelEntrega->excluirPor('id', $vendaProdutosEntrega->entrega_id);
        }

        $modelProdutoSKUEntrega = new \model\ProdutoSKUEntrega();
        $produtosSKUsEntrega = $modelProdutoSKUEntrega->buscarPor('entrega_id', $vendaProdutosEntrega->entrega_id);

        $modelProdutoSKU = new \model\ProdutoSKU();
        if (!empty($produtosSKUsEntrega)) {
            foreach ($produtosSKUsEntrega as $produtoSKUEntrega) {
                $produtoSKU = $modelProdutoSKU->obterPor('id', $produtoSKUEntrega->produtosku_id);
                $modelProdutoSKU->id = $produtoSKUEntrega->produtosku_id;
                $modelProdutoSKU->atualizarCampo('quantidade', $produtoSKU->quantidade + $produtoSKUEntrega->quantidade);
            }

            $modelProdutoSKUEntrega->excluirPor('entrega_id', $vendaProdutosEntrega->entrega_id);
        } else {
            $modelProduto = new \model\Produto();
            $produto = $modelProduto->obterPor('id', $vendaproduto->produto_id);
            $modelProduto->id = $produto->id;
            $modelProduto->atualizarCampo('quantidade', $produto->quantidade + $vendaproduto->quantidade);
        }

        return array('resultado' => '1', 'mensagem' => 'Devolução realizada com sucesso');
    }
}
