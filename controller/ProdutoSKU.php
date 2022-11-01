<?php

namespace controller;

class ProdutoSKU extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\ProdutoSKU();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/produtoskus-tabela.php';
    }

    public function carregarOpcoesVenda($parametros){
        include '../view/painel/includes/produtoskus-opcoes-venda.php';
    }

    public function salvar($parametros)
    {
        $model = new \model\ProdutoSKU();
        $model->id = $parametros['id'];
        $model->produto_id = $parametros['produto_id'];
        $model->preco = real_para_decimal($parametros['preco']);
        $model->quantidade = $parametros['quantidade'];

        $dados = $model->buscarPor(array('produto_id', 'preco'), array($model->produto_id, $model->preco));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe este preço cadastrado para este produto');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Estoque salvo com sucesso', 'id' => $model->id);
    }
}