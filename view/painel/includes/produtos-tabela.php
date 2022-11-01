<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$produtos = \controller\Produto::_listar($parametros);

?>
<?php if (!empty($produtos->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Preço</div>
                <div class="column">Quantidade</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($produtos->resultado as $produto) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $produto->nome; ?></div>
                    <div class="column" label="Comissão">R$ <?php echo mask($produto->preco, '$'); ?></div>
                    <div class="column" label="Comissão"><?php echo $produto->quantidade; ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $produto->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $produto->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $produto->nome; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $produto->id; ?>" controller="produto">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <a href="/painel/cadastro/produto/<?php echo $produto->id; ?>" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $produtos 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $produtos->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem produtos para exibir
    </div>
<?php } // if !empty $produtos 
?>