<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$investimentos = new \controller\Investimento;
$investimentos = $investimentos->listarRelatorioMes($parametros);
$agrupador = '';

?>
<?php if (!empty($investimentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Mês</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($investimentos->resultado as $investimento) { ?>
            <?php
            if ($agrupador != $investimento->nome) {
                $agrupador = $investimento->nome;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $investimento->nome
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Mês"><?php echo data($investimento->mes . '01', 'mes-Y'); ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($investimento->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $investimentos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $investimentos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $investimentos 
?>