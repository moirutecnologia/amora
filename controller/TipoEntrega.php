<?php

namespace controller;

class TipoEntrega extends _BaseController
{
    public function listar($parametros = null)
    {
        $model = new \model\TipoEntrega();
        $dados = $model->listar($parametros);

        return $dados;
    }
}