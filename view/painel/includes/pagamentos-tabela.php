<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$pagamentos = new \controller\Pagamento();
$pagamentos = $pagamentos->listar($parametros);

?>
<?php if (!empty($pagamentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Data</div>
                <div class="column">Nome</div>
                <div class="column">Forma de recebimento</div>
                <div class="column">Valor</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($pagamentos->resultado as $pagamento) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Data"><?php echo data($pagamento->data, 'br-data'); ?></div>
                    <div class="column" label="Nome"><?php echo $pagamento->cliente; ?></div>
                    <div class="column" label="Forma de recebimento"><?php echo $pagamento->metodopagamento; ?></div>
                    <div class="column" label="Valor">R$ <?php echo mask($pagamento->valor, '$'); ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $pagamento->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $pagamento->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de R$ <?php echo mask($pagamento->valor, '$'); ?><br/>pagos por <?php echo $pagamento->cliente; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $pagamento->id; ?>" controller="pagamento">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $pagamentos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $pagamentos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem pagamentos para exibir
    </div>
<?php } // if !empty $pagamentos 
?>