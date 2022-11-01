<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$metodospagamentos = new \controller\MetodoPagamento;
$metodospagamentos = $metodospagamentos->listarRelatorioMesDetalhado($parametros);
$agrupador = '';
$subagrupador = '';

?>
<?php if (!empty($metodospagamentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Cliente</div>
                <div class="column">Valor</div>
            </div>
        </div>

        <?php foreach ($metodospagamentos->resultado as $metodopagamento) { ?>
            <?php
            if ($agrupador != $metodopagamento->nome) {
                $agrupador = $metodopagamento->nome;
                $subagrupador = '';
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $metodopagamento->nome
            ?>
            <?php
            if ($subagrupador != $metodopagamento->mes) {
                $subagrupador = $metodopagamento->mes;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo data($subagrupador.'01', 'mes-Y'); ?></span>
                </div>
            <?php
            } // if $subagrupador != $metodopagamento->mes
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                <div class="column" label="Cliente"><?php echo $metodopagamento->cliente; ?></div>
                    <div class="column" label="Valor">R$ <?php echo mask($metodopagamento->valor, '$'); ?></div>
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