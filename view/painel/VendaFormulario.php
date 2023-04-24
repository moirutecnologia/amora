<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php $marca = \controller\Marca::_obter($args['id'] ?? ''); ?>

<section id="pagina-venda" class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de venda</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $marca->id ?? 12; ?>">
            <div class="columns is-multiline">
                <div class="column is-2">
                    <div class="field">
                        <label class="label">Data</label>
                        <div class="control">
                            <input id="data" class="input" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="column is-10">
                    <div class="field">
                        <label class="label">
                            <div class="columns is-mobile is-gapless mb-0">
                                <div class="column is-4">
                                    Cliente
                                </div>
                                <div class="column has-text-right">
                                    <a href="#novo-cliente" data-fancybox class="button is-small is-primary is-link">
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>cliente</span>
                                    </a>
                                </div>
                            </div>
                        </label>
                        <div class="control">
                            <div class="select is-fullwidth com-filtro">
                                <input type="text">
                                <select id="cliente_id" required>
                                    <?php include '../view/painel/includes/clientes-opcoes.php'; ?>
                                </select>
                            </div>
                            <div id="novo-cliente" class="columns" style="display: none;">
                                <div class="column">
                                    <h2 class="subtitle">Novo cliente</h2>
                                    <div class="field">
                                        <label class="label">Nome</label>
                                        <div class="control">
                                            <input id="nome" class="input" type="text" required>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">E-mail</label>
                                        <div class="control">
                                            <input id="email" class="input" type="mail">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">WhatsApp</label>
                                        <div class="control">
                                            <input id="whatsapp" class="input" mascara="telefone" type="tel">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Endereço</label>
                                        <div class="control">
                                            <input id="endereco" class="input" type="text">
                                        </div>
                                    </div>

                                    <div class="field is-grouped is-grouped-centered">
                                        <div class="control">
                                            <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                        </div>
                                        <div class="control">
                                            <button id="salvar-cliente" class="button is-primary">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">
                            <div class="columns is-mobile is-gapless mb-0">
                                <div class="column is-4">
                                    Produto
                                </div>
                                <div class="column has-text-right">
                                    <a href="#novo-produto" data-fancybox class="button is-small is-primary is-link">
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>produto</span>
                                    </a>
                                </div>
                            </div>
                        </label>

                        <div class="control">
                            <div class="select is-fullwidth com-filtro">
                                <input type="text">
                                <select id="produto_id">
                                    <?php include '../view/painel/includes/produtos-opcoes.php'; ?>
                                </select>
                            </div>
                            <div id="novo-produto" class="columns" style="display: none;">
                                <div class="column">
                                    <h2 class="subtitle">Novo produto</h2>
                                    <div class="field">
                                        <label class="label">Nome</label>
                                        <div class="control">
                                            <input id="nome" class="input" type="text" required>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Fornecedor</label>
                                        <div class="select is-fullwidth">
                                            <select id="marca_id" required>
                                                <?php include '../view/painel/includes/marcas-opcoes.php'; ?>
                                            </select>
                                        </div>
                                        <div id="novo-marca" class="columns" style="display: none;">
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
                                                        <button id="salvar-marca" class="button is-primary">Salvar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <label class="label">Preço</label>
                                        <div class="control">
                                            <input id="preco" class="input" type="tel" mascara="valor" required>
                                        </div>
                                    </div>

                                    <div class="field is-grouped is-grouped-centered">
                                        <div class="control">
                                            <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                        </div>
                                        <div class="control">
                                            <button id="salvar-produto" class="button is-primary">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3">
                    <div class="field">
                        <label class="label">Entregue</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select id="entregue">
                                    <option value="" selecione>Selecione o produto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-1">
                    <div class="field">
                        <label class="label">Preço</label>
                        <div class="control">
                            <input id="preco_produto" class="input" mascara="valor" />
                        </div>
                    </div>
                </div>
                <div class="column is-1">
                    <div class="field">
                        <label class="label">Qtd</label>
                        <div class="control">
                            <input id="quantidade" class="input" type="number" mascara="numero">
                        </div>
                    </div>
                </div>
                <div class="column is-2">
                    <div class="field">
                        <label class="label is-hidden-touch">&nbsp;</label>
                        <div class="control">
                            <button id="adicionar" class="button is-primary is-outlined is-fullwidth">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Pedido</label>
                <div js-pedido>
                    <?php
                    $parametros = array('produtos' => '');
                    include '../view/painel/includes/produtos-tabela-venda.php';
                    ?>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/marcas" class="button is-link is-primary">Voltar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>