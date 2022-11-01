<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$investimentos = \controller\Investimento::_listar($parametros);

?>
<?php if (!empty($investimentos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Data</div>
                <div class="column">Tipo</div>
                <div class="column">Valor</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($investimentos->resultado as $investimento) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Data"><?php echo data($investimento->data, 'br-data'); ?></div>
                    <div class="column" label="Investimento"><?php echo $investimento->investimento; ?></div>
                    <div class="column" label="Valor">R$ <?php echo mask($investimento->valor, '$'); ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $investimento->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $investimento->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão do investimento<br/>de R$ <?php echo mask($investimento->valor, '$'); ?> para <?php echo data($investimento->data, 'br-data'); ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $investimento->id; ?>" controller="investimento">
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
        <?php } // foreach $investimentos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $investimentos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem investimentos para exibir<br />
    </div>
<?php } // if !empty $investimentos 
?>