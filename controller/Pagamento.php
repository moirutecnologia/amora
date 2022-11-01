<?php

namespace controller;

class Pagamento extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Pagamento();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarGrafico($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Pagamento();
        $dados = $model->listarGrafico($parametros);

        return $dados;
    }

    public function listarSaldo($parametros = null)
    {
        $model = new \model\Pagamento();
        $dados = $model->listarSaldo($parametros);

        return $dados;
    }

    public function carregarTabela($parametros){
        include '../view/painel/includes/pagamentos-tabela.php';
    }

    public function carregarTabelaSaldo($parametros){
        include '../view/painel/includes/pagamentos-saldo-tabela.php';
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
                return array('resultado' => '0', 'mensagem' => 'Já existe uma fornecedor cadastrado com esse nome');
            }
        }
        
        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Fornecedor salvo com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        $parametros['parcelas'] = intval($parametros['parcelas']);

        $data = strtotime($parametros['data']);

        for ($indice = 0; $indice < $parametros['parcelas']; $indice++) {
            $model = new \model\Pagamento();
            $model->id = $parametros['id'];
            $model->data = date("Y-m-d", strtotime("+$indice month", $data));
            $model->cliente_id = $parametros['cliente_id'];
            $model->metodopagamento_id = $parametros['metodopagamento_id'];
            $model->valor = real_para_decimal($parametros['valor']) / $parametros['parcelas'];

            $model->salvar();
        }

        return array('resultado' => '1', 'mensagem' => 'Recebimento inserido com sucesso');
    }
}