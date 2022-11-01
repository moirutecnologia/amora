<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$marcas = \controller\Marca::_listar($parametros);

?>
<?php if (!empty($marcas->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Comissão</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($marcas->resultado as $marca) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $marca->nome; ?></div>
                    <div class="column" label="Comissão"><?php echo mask($marca->comissao, '$'); ?>%</div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $marca->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $marca->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $marca->nome; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $marca->id; ?>" controller="marca">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <a href="/painel/cadastro/marca/<?php echo $marca->id; ?>" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
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
        Sem fornecedores para exibir<br />
    </div>
<?php } // if !empty $marcas 
?>