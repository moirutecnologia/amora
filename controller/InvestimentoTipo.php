<?php

namespace controller;

class InvestimentoTipo extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\InvestimentoTipo();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/investimentostipos-tabela.php';
    }

    public function salvar($parametros)
    {
        global $_usuario;

        $model = new \model\InvestimentoTipo();
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->usuario_id = $_usuario->id;

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um perfil cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Tipo de investimento salvo com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        global $_usuario;

        $model = new \model\InvestimentoTipo();
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->usuario_id = $_usuario->id;

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um tipo de investimento cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        ob_start();

        include '../view/painel/includes/investimentostipos-opcoes.php';

        $opcoes = ob_get_contents();

        ob_end_clean();

        return array('resultado' => '1', 'mensagem' => 'Tipo de investimento criado com sucesso', 'id' => $model->id, 'opcoes' => $opcoes);
    }
}