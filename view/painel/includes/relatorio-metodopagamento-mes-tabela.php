<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$metodospagamentos = new \controller\MetodoPagamento;
$metodospagamentos = $metodospagamentos->listarRelatorioMes($parametros);
$agrupador = '';

?>
<?php if (!empty($metodospagamentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Mês</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($metodospagamentos->resultado as $metodopagamento) { ?>
            <?php
            if ($agrupador != $metodopagamento->nome) {
                $agrupador = $metodopagamento->nome;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $metodopagamento->nome
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                <div class="column" label="Mês"><?php echo data($metodopagamento->mes . '01', 'mes-Y'); ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($metodopagamento->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $metodospagamentos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $metodospagamentos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $metodospagamentos 
?>