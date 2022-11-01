<?php

namespace controller;

class Investimento extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Investimento();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Investimento();
        $dados = $model->listarGrafico($parametros);

        return $dados;
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Investimento();
        $dados = $model->listarRelatorioTotais($parametros);

        return $dados;
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Investimento();
        $dados = $model->listarRelatorioMes($parametros);

        return $dados;
    }

    public function listarRelatorioMesDetalhado($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Investimento();
        $dados = $model->listarRelatorioMesDetalhado($parametros);

        return $dados;
    }

    public function carregarTabela($parametros)
    {
        include '../view/painel/includes/investimentos-tabela.php';
    }


    public function criar($parametros)
    {
        $parametros['parcelas'] = intval($parametros['parcelas']);

        $data = strtotime($parametros['data']);

        for ($indice = 0; $indice < $parametros['parcelas']; $indice++) {
            $model = new \model\Investimento();
            $model->id = $parametros['id'];
            $model->data = date("Y-m-d", strtotime("+$indice month", $data));
            $model->investimentotipo_id = $parametros['investimentotipo_id'];
            $model->valor = real_para_decimal($parametros['valor']) / $parametros['parcelas'];

            $model->salvar();
        }

        return array('resultado' => '1', 'mensagem' => 'Investimento inserido com sucesso');
    }
}
