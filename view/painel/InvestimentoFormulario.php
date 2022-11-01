<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de investimento</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $investimento->id; ?>">
            <div class="field">
                <label class="label">Data</label>
                <div class="control">
                    <input id="data" class="input" type="date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">
                    <div class="columns is-mobile is-gapless mb-0">
                        <div class="column is-4">
                            Tipo
                        </div>
                        <div class="column has-text-right">
                            <a href="#novo" data-fancybox class="button is-small is-primary is-link">
                                <span class="icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span>tipo de investimento</span>
                            </a>
                        </div>
                    </div>
                </label>
                <div class="select is-fullwidth">
                    <select id="investimentotipo_id" required>
                        <?php include '../view/painel/includes/investimentostipos-opcoes.php'; ?>
                    </select>
                </div>
                <div id="novo" class="columns" style="display: none;">
                    <div class="column">
                        <h2 class="subtitle">Novo tipo de investimento</h2>
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
                                <button id="salvar-novo" class="button is-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Valor</label>
                <div class="control">
                    <input id="valor" class="input" type="tel" mascara="valor" value="<?php echo $investimento->valor; ?>" required>
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
                    <a href="/painel/investimentos" class="button is-link is-primary">Voltar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>