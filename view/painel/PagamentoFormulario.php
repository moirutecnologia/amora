<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de recebimento</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $pagamento->id; ?>">
            <div class="field">
                <label class="label">Data</label>
                <div class="control">
                    <input id="data" class="input" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>

            <div class="field">
                <div class="field">
                    <label class="label">Cliente</label>

                    <div class="control">
                        <div class="select is-fullwidth com-filtro">
                            <input type="text">
                            <select id="cliente_id">
                                <?php include '../view/painel/includes/clientes-opcoes.php'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="field">
                    <label class="label">
                        <div class="columns is-mobile is-gapless mb-0">
                            <div class="column is-4">
                                Forma de recebimento
                            </div>
                            <div class="column has-text-right">
                                <a href="#novo-metodopagamento" data-fancybox class="button is-small is-primary is-link">
                                    <span class="icon">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span>forma de recebimento</span>
                                </a>
                            </div>
                        </div>
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth com-filtro">
                            <input type="text">
                            <select id="metodopagamento_id">
                                <?php include '../view/painel/includes/metodospagamentos-opcoes.php'; ?>
                            </select>
                        </div>
                        <div id="novo-metodopagamento" class="columns" style="display: none;">
                            <div class="column">
                                <h2 class="subtitle">Nova forma de recebimento</h2>
                                <div class="field">
                                    <label class="label">Nome</label>
                                    <div class="control">
                                        <input id="nome" class="input" type="text" required>
                                    </div>
                                </div>

                                <div class="field is-grouped is-grouped-centered">
                                    <div class="control">
                                        <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                    </div>
                                    <div class="control">
                                        <button id="salvar-metodopagamento" class="button is-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Valor</label>
                <div class="control">
                    <input id="valor" class="input" type="tel" mascara="valor" value="<?php echo $_GET['valor']; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Parcelas</label>
                <div class="control">
                    <input id="parcelas" class="input" type="tel" mascara="numero-2" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/<?php echo $_GET['voltar'] ?? 'pagamentos'; ?>" class="button is-link is-primary">Voltar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>