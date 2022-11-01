<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$investimentos = new \controller\Investimento;
$investimentos = $investimentos->listarRelatorioTotais($parametros);

?>
<?php if (!empty($investimentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($investimentos->resultado as $investimento) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $investimento->nome; ?></div>
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