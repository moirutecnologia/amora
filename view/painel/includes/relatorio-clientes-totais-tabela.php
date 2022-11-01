<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioTotais($parametros);

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $cliente->nome; ?></div>
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