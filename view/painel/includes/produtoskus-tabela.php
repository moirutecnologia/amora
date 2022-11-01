<?php $produtoskus = \controller\ProdutoSKU::_listar($parametros); ?>
<?php if (!empty($produtoskus)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Preço de custo</div>
                <div class="column">Quantidade</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($produtoskus as $produtosku) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Preço de cusco">R$ <?php echo mask($produtosku->preco, '$'); ?></div>
                    <div class="column" label="Quantidade"><?php echo $produtosku->quantidade; ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $produtosku->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $produtosku->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão do preço R$ <?php echo mask($produtosku->preco, '$'); ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $produtosku->id; ?>" controller="marca">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <a href="#editar-<?php echo $produtosku->id; ?>" data-fancybox title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                                <div id="editar-<?php echo $produtosku->id; ?>" style="display: none;">
                                    <div class="column" id="editar-estoque" data-produtosku_id="<?php echo $produtosku->id; ?>" data-id="<?php echo $produto->id; ?>">
                                        <h2 class="subtitle">Editar estoque</h2>
                                        <div class="field">
                                            <label class="label">Preço de custo</label>
                                            <div class="control">
                                                <input id="preco" class="input" mascara="valor" type="tel" required value="<?php echo mask($produtosku->preco, '$'); ?>">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <label class="label">Quantidade</label>
                                            <div class="control">
                                                <input id="quantidade" class="input" mascara="numero" type="tel" required value="<?php echo $produtosku->quantidade; ?>">
                                            </div>
                                        </div>

                                        <div class="field is-grouped is-grouped-centered">
                                            <div class="control">
                                                <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                            </div>
                                            <div class="control">
                                                <button id="salvar-editar-estoque" class="button is-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $produtoskus 
        ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem dados para exibir<br />
    </div>
<?php } // if !empty $produtoskus 
?>