<?php

namespace controller;

class MetodoPagamento extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\MetodoPagamento();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\MetodoPagamento();
        $dados = $model->listarRelatorioTotais($parametros);

        return $dados;
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\MetodoPagamento();
        $dados = $model->listarRelatorioMes($parametros);

        return $dados;
    }

    public function listarRelatorioMesDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\MetodoPagamento();
        $dados = $model->listarRelatorioMesDetalhado($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/metodospagamentos-tabela.php';
    }

    public function salvar($parametros)
    {
        global $_usuario;

        $model = new \model\MetodoPagamento();
        $model->usuario_id = $_usuario->id;
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->comissao = real_para_decimal($parametros['comissao']);

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe uma forma de recebimento cadastrada com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Forma de recebimento salva com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        global $_usuario;

        $model = new \model\MetodoPagamento();
        $model->usuario_id = $_usuario->id;
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe uma forma de recebimento cadastrada com esse nome');
            }
        }
        
        $model->salvar();

        ob_start();

        include '../view/painel/includes/metodospagamentos-opcoes.php';

        $opcoes = ob_get_contents();

        ob_end_clean();

        return array('resultado' => '1', 'mensagem' => 'Forma de recebimento criada com sucesso', 'id' => $model->id, 'opcoes' => $opcoes);
    }
}