<?php

namespace controller;

class Estado extends _BaseController
{
    public function listar($parametros = null)
    {
        $model = new \model\Estado();
        $dados = $model->listar($parametros);

        return $dados;
    }
}