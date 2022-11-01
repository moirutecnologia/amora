<?php

namespace controller;

class Relatorio extends _BaseController
{
    public function carregarTabela($parametros)
    {
        global $_usuario;

        $parametros['tipo'] = $parametros['tipo'] ?? 'total';

        if ($parametros['relatorio'] == 'marca' && $parametros['tipo'] == 'total') {
            include '../view/painel/includes/relatorio-marcas-totais-tabela.php';
        } else if ($parametros['relatorio'] == 'marca' && $parametros['tipo'] == 'mes') {
            include '../view/painel/includes/relatorio-marcas-mes-tabela.php';
        } else if ($parametros['relatorio'] == 'marca' && $parametros['tipo'] == 'detalhado') {
            include '../view/painel/includes/relatorio-marcas-detalhado-tabela.php';
        } else if ($parametros['relatorio'] == 'marca' && $parametros['tipo'] == 'vendidos-sem-estoque') {
            include '../view/painel/includes/relatorio-marcas-vendidos-sem-estoque-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'intervalo-compra') {
            include '../view/painel/includes/relatorio-clientes-intervalos-compras-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'intervalo-compra-produto') {
            if (!$_usuario->assinante) {
                include '../view/painel/includes/seja-assinante.php';
            } else {
                include '../view/painel/includes/relatorio-clientes-intervalos-compras-produtos-tabela.php';
            }
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'total') {
            include '../view/painel/includes/relatorio-clientes-totais-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'mes') {
            include '../view/painel/includes/relatorio-clientes-mes-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'melhores') {
            include '../view/painel/includes/relatorio-clientes-melhores-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'produtos-comprados') {
            include '../view/painel/includes/relatorio-clientes-produtocomprado-tabela.php';
        } else if ($parametros['relatorio'] == 'cliente' && $parametros['tipo'] == 'extrato') {
            if (!$_usuario->assinante) {
                include '../view/painel/includes/seja-assinante.php';
            } else {
                include '../view/painel/includes/relatorio-clientes-extrato-tabela.php';
            }
        } else if ($parametros['relatorio'] == 'investimento' && $parametros['tipo'] == 'total') {
            include '../view/painel/includes/relatorio-investimentos-totais-tabela.php';
        } else if ($parametros['relatorio'] == 'investimento' && $parametros['tipo'] == 'mes') {
            include '../view/painel/includes/relatorio-investimentos-mes-tabela.php';
        } else if ($parametros['relatorio'] == 'investimento' && $parametros['tipo'] == 'mes-detalhado') {
            include '../view/painel/includes/relatorio-investimentos-mes-detalhado-tabela.php';
        } else if ($parametros['relatorio'] == 'metodopagamento' && $parametros['tipo'] == 'total') {
            include '../view/painel/includes/relatorio-metodopagamento-totais-tabela.php';
        } else if ($parametros['relatorio'] == 'metodopagamento' && $parametros['tipo'] == 'mes') {
            include '../view/painel/includes/relatorio-metodopagamento-mes-tabela.php';
        } else if ($parametros['relatorio'] == 'metodopagamento' && $parametros['tipo'] == 'mes-detalhado') {
            include '../view/painel/includes/relatorio-metodopagamento-mes-detalhado-tabela.php';
        }
    }
}
