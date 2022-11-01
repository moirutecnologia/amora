<?php

namespace controller;

class VendaProduto extends _BaseController
{
    public function listar($parametros)
    {
        $model = new \model\VendaProduto();
        $dados = $model->listar($parametros);

        return $dados;
    }
}