<?php

namespace controller;

class Cidade extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\Cidade();
        $dados = $model->listar($parametros);

        return $dados;
    }

    public function carregarOpcoes($parametros)
    {
        include '../view/includes/cidade-opcoes.php';
        exit;
    }
}