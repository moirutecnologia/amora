<?php $produto = \controller\Produto::_obter($args['id']); ?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de produto</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $produto->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $produto->nome; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">
                    <div class="columns is-mobile is-gapless mb-0">
                        <div class="column is-4">
                            Fornecedor
                        </div>
                        <div class="column has-text-right">
                            <a href="#novo" data-fancybox class="button is-small is-primary is-link">
                                <span class="icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span>fornecedor</span>
                            </a>
                        </div>
                    </div>
                </label>
                <div class="select is-fullwidth">
                    <select id="marca_id" required>
                        <?php include '../view/painel/includes/marcas-opcoes.php'; ?>
                    </select>
                </div>
                <div id="novo" class="columns" style="display: none;">
                    <div class="column">
                        <h2 class="subtitle">Novo fornecedor</h2>
                        <div class="field">
                            <label class="label">Nome</label>
                            <div class="control">
                                <input id="nome" class="input" type="text" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Comissão</label>
                            <div class="control">
                                <input id="comissao" class="input" mascara="valor" type="tel" required>
                            </div>
                        </div>

                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                            </div>
                            <div class="control">
                                <button id="salvar-novo" class="button is-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Preço de venda</label>
                <div class="control">
                    <input id="preco" class="input" type="tel" mascara="valor" value="<?php echo $produto->preco; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Quantidade</label>
                <div class="control">
                    <input id="quantidade" class="input" type="tel" mascara="numero" value="<?php echo $produto->quantidade; ?>" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/investimentostipos" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>

        <div js-estoque class="<?php echo empty($produto->id) ? 'is-hidden' : ''; ?>">

            <hr />

            <div class="columns">
                <div class="column is-10">
                    <h2 class="subtitle">Cadastro de estoque</h2>
                </div>
                <div class="column">
                    <div class="buttons is-right">
                        <a href="#novo-estoque" data-fancybox class="button is-primary is-link">
                            <span class="icon">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span>Novo estoque</span>
                        </a>
                        <div id="novo-estoque" class="columns" style="display: none;" data-id="<?php echo $produto->id; ?>">
                            <div class="column">
                                <h2 class="subtitle">Nova estoque</h2>
                                <div class="field">
                                    <label class="label">Preço de custo</label>
                                    <div class="control">
                                        <input id="preco" class="input" mascara="valor" type="tel" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Quantidade</label>
                                    <div class="control">
                                        <input id="quantidade" class="input" mascara="numero" type="tel" required>
                                    </div>
                                </div>

                                <div class="field is-grouped is-grouped-centered">
                                    <div class="control">
                                        <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                    </div>
                                    <div class="control">
                                        <button id="salvar-novo-estoque" class="button is-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div js-tabela>
                <?php
                $parametros = array('produto_id' => $produto->id);
                include '../view/painel/includes/produtoskus-tabela.php';
                ?>
            </div>

        </div>
    </div>
</section>