<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$investimentos = new \controller\Investimento();
$investimentos = $investimentos->listarRelatorioMesDetalhado($parametros);
$agrupador = '';
?>
<?php if (!empty($investimentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Data</div>
                <div class="column">Valor</div>
            </div>
        </div>

        <?php foreach ($investimentos->resultado as $investimento) { ?>
            <?php
            if ($agrupador != $investimento->nome) {
                $agrupador = $investimento->nome;
                $subagrupador = '';
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $investimento->nome
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Data"><?php echo data($investimento->data, 'br-data'); ?></div>
                    <div class="column" label="Valor">R$ <?php echo mask($investimento->valor, '$'); ?></div>
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