<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$produtos = new \controller\Produto();
$produtos = $produtos->listarVendaSemEstoque($parametros);
$agrupador = '';

?>
<?php if (!empty($produtos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Produto</div>
                <div class="column">Quantidade</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($produtos->resultado as $produto) { ?>
            <?php
            if ($agrupador != $produto->marca) {
                $agrupador = $produto->marca;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $produto->marca
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Produto"><?php echo $produto->produto; ?></div>
                    <div class="column" label="Quantidade"><?php echo $produto->quantidade; ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($produto->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $produtos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $produtos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $produtos 
?>