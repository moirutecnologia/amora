<?php

namespace controller;

class Marca extends _BaseController
{
    public function listar($parametros = null)
    {
        $model = new \model\Marca();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Marca();
        $dados = $model->listarRelatorioTotais($parametros);

        return $dados;
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Marca();
        $dados = $model->listarRelatorioMes($parametros);

        return $dados;
    }

    public function listarRelatorioDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Marca();
        $dados = $model->listarRelatorioDetalhado($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/marcas-tabela.php';
    }

    public function salvar($parametros)
    {
        global $_usuario;

        $model = new \model\Marca();
        $model->usuario_id = $_usuario->id;
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->comissao = real_para_decimal($parametros['comissao']);

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um fornecedor cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Fornecedor salvo com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        global $_usuario;

        $model = new \model\Marca();
        $model->usuario_id = $_usuario->id;
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->comissao = real_para_decimal($parametros['comissao']);

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um fornecedor cadastrada com esse nome');
            }
        }
        
        $model->salvar();

        ob_start();

        include '../view/painel/includes/marcas-opcoes.php';

        $opcoes = ob_get_contents();

        ob_end_clean();

        return array('resultado' => '1', 'mensagem' => 'Fornecedor criado com sucesso', 'id' => $model->id, 'opcoes' => $opcoes);
    }
}