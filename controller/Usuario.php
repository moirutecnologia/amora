<?php

namespace controller;

class Usuario extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Usuario();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function contadores($parametros)
    {
        global $_usuario;

        if (!$_usuario->assinante) {
            $parametros['data_de'] = date('Y-m-d', strtotime('-2 months'));
        }

        $model = new \model\Usuario();
        $dados = $model->contadores($parametros);

        return $dados;
    }

    public function carregarTabela($parametros)
    {
        include '../view/painel/includes/usuarios-tabela.php';
    }

    public function carregarContadores($parametros)
    {
        include '../view/painel/includes/contadores.php';
    }

    public function salvar($parametros)
    {
        $model = new \model\Usuario();
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->email = $parametros['email'];
        $model->whatsapp = str_apenas_int($parametros['whatsapp']);
        $model->senha = (isset($parametros['senha']) && !empty($parametros['senha'])) ? password_hash($parametros['senha'], PASSWORD_DEFAULT) : "";
        $model->perfil_ids = json_encode($parametros['perfil_ids']);

        $dados = $model->buscarPor('nome', $model->nome);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse nome');
            }
        }

        $dados = $model->buscarPor('email', $model->email);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse e-mail');
            }
        }

        if (!empty($model->id) && empty($model->senha)) {
            $usuario = $model->obterPor('id', $model->id);
            $model->senha = $usuario->senha;
        } else if (empty($model->id) && empty($model->senha)) {
            return array('resultado' => '0', 'mensagem' => 'Para cadastrar um usuário é necessario informar a senha');
        }

        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Usuário salvo com sucesso', 'id' => $model->id);
    }

    public function cadastrar($parametros)
    {
        $model = new \model\Usuario();
        $model->id = $parametros['id'];
        $model->nome = $parametros['nome'];
        $model->email = $parametros['email'];
        $model->whatsapp = str_apenas_int($parametros['whatsapp']);
        $model->senha = (isset($parametros['senha']) && !empty($parametros['senha'])) ? password_hash($parametros['senha'], PASSWORD_DEFAULT) : "";
        $model->perfil_ids = '[]';
        $model->assinante = 0;

        $dados = $model->buscarPor('nome', $model->nome);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse nome');
            }
        }

        $dados = $model->buscarPor('email', $model->email);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse e-mail');
            }
        }

        if (empty($model->id) && empty($model->senha)) {
            return array('resultado' => '0', 'mensagem' => 'Para cadastrar um usuário é necessario informar a senha');
        }

        $model->salvar();

        $model->email = $parametros['email'];
        $model->senha = $parametros['senha'];
        $dados = $model->obterPor('email', $model->email);

        global $_usuario;
        $_usuario = $dados;

        if (!empty($dados) && password_verify($parametros['senha'], $dados->senha)) {
            $model->_usuario_id = $dados->id;
            $model->criarToken();
            $retorno = array('resultado' => 1);
        } else {
            $retorno = array('resultado' => 0, 'mensagem' => 'Por favor, verifique os dados informados.');
        }

        return $retorno;
    }

    public function atualizar($parametros)
    {
        global $_usuario;

        $model = new \model\Usuario();
        $model->id = $_usuario->id;
        $model->nome = $parametros['nome'];
        $model->email = $parametros['email'];
        $model->whatsapp = str_apenas_int($parametros['whatsapp']);

        $dados = $model->buscarPor('nome', $model->nome);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse nome');
            }
        }

        $dados = $model->buscarPor('email', $model->email);

        foreach ($dados as $dado) {
            if ($dado->id != $model->id) {
                return array('resultado' => '0', 'mensagem' => 'Já existe um usuário cadastrado com esse e-mail');
            }
        }

        $usuario = $model->obterPor('id', $model->id);
        $model->senha = $usuario->senha;
        $model->perfil_ids = $usuario->perfil_ids;
        $model->assinante = $usuario->assinante;

        $model->salvar();

        return array('resultado' => '1', 'mensagem' => 'Dados atualizados com sucesso');
    }

    public function obterPorToken($token)
    {
        $model = new \model\Usuario();

        $dados = $model->obterPorToken($token);

        return $dados;
    }

    public function login($parametros)
    {
        global $_usuario;

        $model = new \model\Usuario();
        $model->email = $parametros['email'];
        $model->senha = $parametros['senha'];
        $dados = $model->obterPor('email', $model->email);

        $_usuario = $dados;

        if (!empty($dados) && password_verify($parametros['senha'], $dados->senha)) {
            $model->_usuario_id = $dados->id;
            $model->criarToken();
            $retorno = array('resultado' => 1);
        } else {
            $retorno = array('resultado' => 0, 'mensagem' => 'Por favor, verifique os dados informados.');
        }

        return $retorno;
    }

    public function sair($parametros)
    {
        $model = new \model\Usuario();

        return $model->sair($parametros['token']);
    }

    public function trocarSenha($parametros)
    {
        global $_usuario;

        $model = new \model\Usuario();
        $model->id = $_usuario->id;

        $dados = $model->obterPor('id', $_usuario->id);

        $parametros['senha'] = htmlspecialchars($parametros['senha']);

        if (!empty($dados) && password_verify($parametros['senha'], $dados->senha)) {
            if ($parametros['nova_senha'] == $parametros['confirmar_senha']) {
                $model->atualizarCampo('senha', password_hash($parametros['nova_senha'], PASSWORD_DEFAULT));
            } else {
                return array('resultado' => '0', 'mensagem' => 'A confirmação precisa ser igual a nova senha');
            }
        } else {
            return array('resultado' => '0', 'mensagem' => 'Senha atual inválida');
        }

        return array('resultado' => '1', 'mensagem' => 'Senha atualizada com sucesso');
    }

    public function novaSenha($parametros)
    {
        $model = new \model\Usuario();
        $usuario = $model->obterPor('email', $parametros['email']);

        $senha = strtoupper(bin2hex(random_bytes(4)));

        if (!empty($usuario)) {
            $model->id = $usuario->id;
            $model->atualizarCampo('senha', password_hash($senha, PASSWORD_DEFAULT));

            $dados = array(
                'nome' => $usuario->nome,
                'senha' => $senha,
            );

            enviaremail($usuario->email, 'Amora', 'Nova senha', 'NovaSenha', $dados);
        }

        return array('resultado' => '1', 'mensagem' => 'Se seu e-mail está correto você receberá uma nova senha');
    }
}
