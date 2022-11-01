<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$marcas = new \controller\Marca;
$marcas = $marcas->listarRelatorioTotais($parametros);

?>
<?php if (!empty($marcas->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Total</div>
            </div>
        </div>

        <?php foreach ($marcas->resultado as $marca) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $marca->nome; ?></div>
                    <div class="column" label="Total">R$ <?php echo mask($marca->total, '$'); ?></div>
                </div>
            </div>
        <?php } // foreach $marcas 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $marcas->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $marcas 
?>