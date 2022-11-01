<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$saldos = new \controller\Pagamento();
$saldos = $saldos->listarSaldo($parametros);

?>
<?php if (!empty($saldos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Valor</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($saldos->resultado as $saldo) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $saldo->nome; ?></div>
                    <div class="column  <?php echo $saldo->saldo < 0 ? 'negativo' : 'positivo'; ?>" label="Valor">R$ <?php echo mask(abs($saldo->saldo), '$'); ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <?php if ($saldo->saldo < 0) { ?>
                            <div class="columns is-mobile">
                                <div class="column">
                                    <a href="/painel/cadastro/pagamento?cliente_id=<?php echo $saldo->id; ?>&voltar=saldo" class="is-primary" title="Pagamento parcial">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </a>
                                </div>
                                <div class="column">
                                    <a href="/painel/cadastro/pagamento?cliente_id=<?php echo $saldo->id; ?>&valor=<?php echo mask($saldo->saldo, '$'); ?>&voltar=saldo" class="is-primary" title="Pagamento total">
                                        <i class="fas fa-coins"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } // if $saldo->saldo < 0 
                        ?>
                    </div>
                </div>
            </div>
        <?php } // foreach $saldos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $saldos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir
    </div>
<?php } // if !empty $saldos 
?>