<?php

/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 15/03/2018
 * Time: 17:11
 */

namespace controller;

class _BaseController
{
    public static function _obter($id){
        $caminho = "../controller/" . str_replace("\\", "", str_replace("controller", "", strtolower(get_called_class()))) . ".php";
        $nome_model = arquivo_nome_real($caminho, true, false);
        $model = "controller\\" . $nome_model;
        $model = new $model();

        $model->id = $id;

        $dados = $model->obter(array('id' => $id));

        return $dados;
    }

    public static function _listar($parametros = null)
    {
        $caminho = "../controller/" . str_replace("\\", "", str_replace("controller", "", strtolower(get_called_class()))) . ".php";
        $nome_model = arquivo_nome_real($caminho, true, false);
        $model = "controller\\" . $nome_model;
        $model = new $model();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function obter($parametros)
    {
        $caminho = "../model/" . str_replace("\\", "", str_replace("controller", "", strtolower(get_class($this)))) . ".php";
        $nome_model = arquivo_nome_real($caminho, true, false);
        $model = "model\\" . $nome_model;
        $model = new $model();
        // $model->token = $parametros["token"];
        $model->id = $parametros["id"];

        $dados = $model->obter();

        // $retorno = json_decode(json_encode($dados), true);

        // $retorno["token"] = $model->criarToken();

        return $dados;
    }

    public function excluir($parametros)
    {
        $caminho = "../model/" . str_replace("\\", "", str_replace("controller", "", strtolower(get_class($this)))) . ".php";
        $nome_model = arquivo_nome_real($caminho, true, false);
        $model = "model\\" . $nome_model;
        $model = new $model();
        //$model->token = $_COOKIE["token"];
        $model->id = $parametros["id"];

        $model->excluir();

        return array("resultado" => "1", "mensagem" => "Registro excluído com sucesso");
        //return array("resultado" => "1", "mensagem" => "Registro excluído com sucesso");
    }

    public function atualizarCampo($parametros)
    {

        $caminho = "../model/" . str_replace("\\", "", str_replace("controller", "", strtolower(get_class($this)))) . ".php";
        $nome_model = arquivo_nome_real($caminho, true, false);
        $model = "model\\" . $nome_model;
        $model = new $model();

        $model->id = $parametros['id'];
        if(isset($parametros['campos'])){
            foreach($parametros['campos'] as $campo){
                $model->atualizarCampo($campo['campo'], $campo['valor']);    
            }
        }else{
            $model->atualizarCampo($parametros['campo'], $parametros['valor']);
        }

        return array('resultado' => '1', 'mensagem' => 'Atualizado com sucesso');
    }
}
