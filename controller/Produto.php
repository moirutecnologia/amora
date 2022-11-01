<?php

namespace controller;

class Produto extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Produto();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarVendaSemEstoque($parametros)
    {
        $model = new \model\Produto();
        $dados = $model->listarVendaSemEstoque($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/produtos-tabela.php';
    }

    public function salvar($parametros)
    {
        global $_usuario;

        $model = new \model\Produto();
        $model->id = $parametros['id'];
        $model->usuario_id = $_usuario->id;
        $model->nome = $parametros['nome'];
        $model->preco = real_para_decimal($parametros['preco']);
        $model->marca_id = $parametros['marca_id'];
        $model->quantidade = $parametros['quantidade'];

        $dados = $model->buscarPor(array('usuario_id', 'nome', 'marca_id'), array($model->usuario_id, $model->nome, $model->marca_id));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um produto cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Produto salvo com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        global $_usuario;

        $model = new \model\Produto();
        $model->id = $parametros['id'];
        $model->usuario_id = $_usuario->id;
        $model->nome = $parametros['nome'];
        $model->preco = real_para_decimal($parametros['preco']);
        $model->marca_id = $parametros['marca_id'];
        $model->quantidade = $parametros['quantidade'];

        $dados = $model->buscarPor(array('usuario_id', 'nome', 'marca_id'), array($model->usuario_id, $model->nome, $model->marca_id));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um produto cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        $model->salvar();

        ob_start();

        include '../view/painel/includes/produtos-opcoes.php';

        $opcoes = ob_get_contents();

        ob_end_clean();

        return array('resultado' => '1', 'mensagem' => 'Produto criado com sucesso', 'id' => $model->id, 'opcoes' => $opcoes);
    }
}