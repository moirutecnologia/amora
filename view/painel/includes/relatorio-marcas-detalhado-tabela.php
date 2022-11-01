<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$produtos = new \controller\Marca();
$produtos = $produtos->listarRelatorioDetalhado($parametros);

?>
<?php if (!empty($produtos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column is-1">Data</div>
                <div class="column">Produto</div>
                <div class="column">Cliente</div>
                <div class="column is-1">Quantidade</div>
                <div class="column is-1">Preço</div>
                <div class="column is-1">Total</div>
            </div>
        </div>

        <?php foreach ($produtos->resultado as $produto) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column is-1" label="Cliente"><?php echo data($produto->data, 'br-data'); ?></div>
                    <div class="column" label="Cliente"><?php echo $produto->marca . ' - ' . $produto->produto; ?></div>
                    <div class="column" label="Cliente"><?php echo $produto->cliente; ?></div>
                    <div class="column is-1" label="Cliente"><?php echo $produto->quantidade; ?></div>
                    <div class="column is-1" label="Valor">R$ <?php echo mask($produto->preco, '$'); ?></div>
                    <div class="column is-1" label="Total">R$ <?php echo mask($produto->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $produtos 
        ?>

        <div class="column is-12 linha">
            <div class="columns is-vcentered">
                <div class="column is-1" label="Cliente"></div>
                <div class="column" label="Cliente"></div>
                <div class="column" label="Cliente"></div>
                <div class="column is-1" label="Cliente"></div>
                <div class="column is-1" label="Valor"></div>
                <div class="column is-1" label="Valor"><strong>R$ <?php echo mask($produtos->total, '$'); ?></strong></div>
            </div>
        </div>
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