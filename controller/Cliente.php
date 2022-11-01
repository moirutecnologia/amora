<?php

namespace controller;

class Cliente extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Cliente();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function listarRelatorioTotais($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioTotais($parametros);

        return $dados;
    }

    public function listarRelatorioMes($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioMes($parametros);

        return $dados;
    }

    public function listarRelatorioMelhores($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioMelhores($parametros);

        return $dados;
    }

    public function listarRelatorioIntervaloCompra($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioIntervaloCompra($parametros);

        return $dados;
    }

    public function listarRelatorioIntervaloCompraProduto($parametros)
    {
        global $_usuario;

        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioIntervaloCompraProduto($parametros);

        return $dados;
    }

    public function listarRelatorioProdutosComprados($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioProdutosComprados($parametros);

        return $dados;
    }

    public function listarRelatorioExtrato($parametros)
    {
        global $_usuario;
        
        $parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y').'-01-01' : date('Y-m-d', strtotime('-2 months')));

        $model = new \model\Cliente();
        $dados = $model->listarRelatorioExtrato($parametros);

        return $dados;
    }

    public function salvar($parametros)
    {
        global $_usuario;

        $model = new \model\Cliente();
        $model->id = $parametros['id'];
        $model->usuario_id = $_usuario->id;
        $model->nome = htmlspecialchars($parametros['nome']);
        $model->email = htmlspecialchars($parametros['email']);
        $model->whatsapp = htmlspecialchars(str_apenas_int($parametros['whatsapp']));
        $model->endereco = htmlspecialchars($parametros['endereco']);

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um cliente com esse nome');
            }
        }

        $dados = $model->buscarPor(array('usuario_id', 'email'), array($model->usuario_id, $model->email));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um cliente com esse e-mail');
            }
        }

        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Cliente salvo com sucesso', 'id' => $model->id);
    }

    public function criar($parametros)
    {
        global $_usuario;

        $model = new \model\Cliente();
        $model->id = $parametros['id'];
        $model->usuario_id = $_usuario->id;
        $model->nome = htmlspecialchars($parametros['nome']);
        $model->email = htmlspecialchars($parametros['email']);
        $model->whatsapp = htmlspecialchars(str_apenas_int($parametros['whatsapp']));
        $model->endereco = htmlspecialchars($parametros['endereco']);

        $dados = $model->buscarPor(array('usuario_id', 'nome'), array($model->usuario_id, $model->nome));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um cliente com esse nome');
            }
        }

        $dados = $model->buscarPor(array('usuario_id', 'email'), array($model->usuario_id, $model->email));

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um cliente com esse e-mail');
            }
        }

        $model->salvar();

        ob_start();

        include '../view/painel/includes/clientes-opcoes.php';

        $opcoes = ob_get_contents();

        ob_end_clean();

        return array('resultado' => '1', 'mensagem' => 'Cliente criado com sucesso', 'id' => $model->id, 'opcoes' => $opcoes);
    }

    public function carregarTabela($parametros)
    {
        include '../view/painel/includes/clientes-tabela.php';
    }

    public function carregarOpcoes($parametros)
    {
        include '../view/painel/includes/cliente-opcoes.php';
    }
}
