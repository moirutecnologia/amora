<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioIntervaloCompra($parametros);

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column is-2">Total compras</div>
                <div class="column is-2">Mínimo (Dias)</div>
                <div class="column is-2">Média (Dias)</div>
                <div class="column is-2">Máximo (Dias)</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $cliente->nome; ?></div>
                    <div class="column is-2" label="Mínimo (Dias)"><?php echo $cliente->totalcompras; ?></div>
                    <div class="column is-2" label="Mínimo (Dias)"><?php echo $cliente->minimodias; ?></div>
                    <div class="column is-2" label="Média (Dias)"><?php echo intval($cliente->mediadias); ?></div>
                    <div class="column is-2" label="Máximo (Dias)"><?php echo $cliente->maximodias; ?></div>
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