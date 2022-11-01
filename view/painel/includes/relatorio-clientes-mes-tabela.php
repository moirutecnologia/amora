<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioMes($parametros);
$agrupador = '';

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Mês</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <?php
            if ($agrupador != $cliente->nome) {
                $agrupador = $cliente->nome;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $cliente->nome
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Mês"><?php echo data($cliente->mes . '01', 'mes-Y'); ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($cliente->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $clientes 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $clientes->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $clientes 
?>