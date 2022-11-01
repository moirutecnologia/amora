<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = new \controller\Cliente;
$clientes = $clientes->listarRelatorioExtrato($parametros);

?>
<?php if (!empty($clientes)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Data</div>
                <div class="column">Nome</div>
                <div class="column">Descritivo</div>
                <div class="column">Valor</div>
                <div class="column">Saldo</div>
            </div>
        </div>

        <?php
        $agrupador = '';
        $total = 0;
        
        foreach ($clientes as $cliente) {
            if($agrupador != $cliente->cliente){
                $agrupador = $cliente->cliente;
                $total = 0;
            }

            $total += $cliente->valor;
            ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered is-mobile is-multiline">
                    <div class="column is-6-mobile" label="Data"><?php echo data($cliente->data, 'br-data'); ?></div>
                    <div class="column is-6-mobile" label="Nome"><?php echo $cliente->cliente; ?></div>
                    <div class="column is-12-mobile" label="Descritivo"><?php echo $cliente->descricao; ?></div>
                    <div class="column is-6-mobile" label="Valor">R$ <?php echo mask($cliente->valor, '$'); ?></div>
                    <div class="column is-6-mobile <?php echo $total < 0 ? 'negativo' : 'positivo'; ?>" label="Saldo">R$ <?php echo mask($total, '$'); ?></div>
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