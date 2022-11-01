<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioIntervaloCompraProduto($parametros);
$agrupador = '';

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Produto</div>
                <div class="column">Média recompra (Dias)</div>
                <div class="column">Última compra (Dias)</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <?php
            if ($agrupador != $cliente->cliente) {
                $agrupador = $cliente->cliente;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $agrupador; ?></span>
                </div>
            <?php
            } // if $agrupador != $cliente->cliente
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Produto"><?php echo $cliente->produto; ?></div>
                    <div class="column" label="Médias recompra (Dias)"><?php echo intval($cliente->media); ?></div>
                    <div class="column" label="Última compra (Dias)"><?php echo $cliente->ultima; ?></div>
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