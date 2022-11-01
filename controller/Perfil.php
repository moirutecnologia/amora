<?php

namespace controller;

class Perfil extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Perfil();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/perfil-tabela.php';
    }

    public function salvar($parametros)
    {
        $model = new \model\Perfil();
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->permissoes = json_encode($parametros['permissoes']);

        $dados = $model->buscarPor('nome', $model->nome);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um perfil cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Perfil salvo com sucesso', 'id' => $model->id);
    }
}