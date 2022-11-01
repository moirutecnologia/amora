<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioProdutosComprados($parametros);

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Data</div>
                <div class="column">Cliente</div>
                <div class="column is-4">Produto</div>
                <div class="column">Quantidade</div>
                <div class="column">Preço</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Data"><?php echo data($cliente->data, 'br-data'); ?></div>
                    <div class="column" label="Nome"><?php echo $cliente->cliente; ?></div>
                    <div class="column is-4" label="Produto"><?php echo $cliente->produto; ?></div>
                    <div class="column" label="Quantidade"><?php echo $cliente->quantidade; ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($cliente->preco, '$'); ?></div>
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