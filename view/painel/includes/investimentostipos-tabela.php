<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$investimentostipos = \controller\InvestimentoTipo::_listar($parametros);

?>
<?php if (!empty($investimentostipos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($investimentostipos->resultado as $investimentotipo) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $investimentotipo->nome; ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $investimentotipo->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $investimentotipo->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $investimentotipo->nome; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $investimentotipo->id; ?>" controller="investimentotipo">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <a href="/painel/cadastro/investimentotipo/<?php echo $investimentotipo->id; ?>" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $investimentostipos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $investimentostipos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem tipo de investimento para exibir<br />
    </div>
<?php } // if !empty $investimentostipos 
?>